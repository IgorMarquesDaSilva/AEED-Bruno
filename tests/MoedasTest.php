<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';
require_once __DIR__ . '/../Model/Quiz/RodadaQuiz.php';
set_error_handler(function ($nivel, $mensagem, $arquivo, $linha) {
    throw new ErrorException($mensagem, 0, $nivel, $arquivo, $linha);
});

$pdo = Conexao::conectar();
$quiz = new Quiz();
$carteira = new Carteira($pdo);
$verificacoes = 0;
$contas = [];
$dia = new DateTimeImmutable('2026-10-01 12:00:00', new DateTimeZone('America/Sao_Paulo'));
$rodadas = new RodadaQuiz($pdo, $dia);

function verificarMoedas($condicao, $mensagem)
{
    global $verificacoes;
    $verificacoes++;
    if (!$condicao) throw new RuntimeException($mensagem);
}

function rejeitarMoedas($operacao)
{
    try { $operacao(); } catch (DomainException $exception) {
        verificarMoedas(true, 'Operacao rejeitada.');
        return;
    }
    verificarMoedas(false, 'A operacao deveria ser rejeitada.');
}

function criarContaMoedas()
{
    global $contas;
    $email = 'moedas-test-' . bin2hex(random_bytes(8)) . '@example.invalid';
    $id = (new Usuario())->cadastrar('Teste isolado de moedas', $email, 'Teste123!');
    $contas[$id] = $email;
    return $id;
}

function jogarMoedas($modelo, $usuarioId, $tema, $erradas = [], $segurarFinal = false)
{
    global $quiz, $carteira;
    $saldoAntes = $carteira->saldo($usuarioId);
    $tentativa = $modelo->iniciar($usuarioId, $tema);
    while (!$tentativa['concluida']) {
        $id = $tentativa['perguntas'][$tentativa['indice']];
        $certa = $quiz->obterPergunta($id)['correta'];
        $errar = is_int($erradas) ? $tentativa['indice'] < $erradas : in_array($id, $erradas, true);
        $alternativa = $errar ? ($certa + 1) % 4 : $certa;
        $tentativa = $modelo->responder($usuarioId, $tentativa['id'], $id, (string) $alternativa);
        verificarMoedas($carteira->saldo($usuarioId) === $saldoAntes, 'Nenhum credito antes da conclusao.');
        if ($segurarFinal && $tentativa['indice'] === count($tentativa['perguntas']) - 1) return $tentativa;
        $tentativa = $modelo->avancar($usuarioId, $tentativa['id'], $id);
    }
    return $tentativa;
}

try {
    verificarMoedas(Carteira::recompensaPorErros(0) === 10, 'Primeira tentativa vale 10.');
    verificarMoedas(Carteira::recompensaPorErros(1) === 5, 'Um erro reduz para 5.');
    verificarMoedas(Carteira::recompensaPorErros(2) === 2 && Carteira::recompensaPorErros(8) === 2, 'Piso de 2 moedas.');
    $id = criarContaMoedas();
    verificarMoedas($carteira->saldo($id) === 0, 'Saldo inicial zero.');
    $r1 = jogarMoedas($rodadas, $id, 'tad', 3);
    verificarMoedas($carteira->saldo($id) === 30, 'Tres acertos iniciais rendem 30.');
    $r2 = jogarMoedas($rodadas, $id, 'tad', 2);
    verificarMoedas($r1['perguntas'] === $r2['perguntas'], 'Lote gratuito permanece igual no dia.');
    verificarMoedas($carteira->saldo($id) === 35, 'Um novo acerto apos um erro rende 5.');
    $r3 = jogarMoedas($rodadas, $id, 'tad');
    verificarMoedas($carteira->saldo($id) === 39, 'Dois novos acertos apos dois erros rendem 4.');
    $premios = $rodadas->recompensas($id, $r3['id']);
    verificarMoedas($premios['ganhas'] === 4 && $premios['por_questao'][$r1['perguntas'][0]]['moedas'] === 2, 'Detalhamento da recompensa.');
    $r4 = jogarMoedas($rodadas, $id, 'tad');
    verificarMoedas($carteira->saldo($id) === 39 && $rodadas->recompensas($id, $r4['id'])['ganhas'] === 0, 'Repetir nao rende moedas adicionais.');
    rejeitarMoedas(function () use ($rodadas, $id, $r4) { $rodadas->avancar($id, $r4['id'], end($r4['perguntas'])); });
    verificarMoedas($carteira->saldo($id) === 39, 'Conclusao duplicada nao duplica saldo.');
    $antesMeiaNoite = new RodadaQuiz($pdo, new DateTimeImmutable('2026-10-02T02:59:59Z'));
    jogarMoedas($antesMeiaNoite, $id, 'tad');
    verificarMoedas($carteira->saldo($id) === 39, 'Antes de 03:00 UTC ainda e o dia anterior em Brasilia.');
    $diaSeguinte = new RodadaQuiz($pdo, new DateTimeImmutable('2026-10-02T03:00:00Z'));
    jogarMoedas($diaSeguinte, $id, 'tad');
    verificarMoedas($carteira->saldo($id) === 99, 'Virada do dia restaura 10 por questao sem zerar saldo.');

    $abandono = criarContaMoedas();
    $t = $rodadas->iniciar($abandono, 'fila');
    $q = $t['perguntas'][0];
    $errada = (string) (($quiz->obterPergunta($q)['correta'] + 1) % 4);
    $t = $rodadas->responder($abandono, $t['id'], $q, $errada);
    rejeitarMoedas(function () use ($rodadas, $abandono, $t, $q, $errada) { $rodadas->responder($abandono, $t['id'], $q, $errada); });
    rejeitarMoedas(function () use ($rodadas, $id, $t, $q) { $rodadas->avancar($id, $t['id'], $q); });
    rejeitarMoedas(function () use ($rodadas, $abandono) { $rodadas->iniciar($abandono, 'todos'); });
    $recuperada = (new RodadaQuiz($pdo, $dia))->buscarAtual($abandono);
    verificarMoedas($recuperada['respostas'] === $t['respostas'], 'Rodada recuperada sem depender da sessao.');
    $rodadas->abandonar($abandono, $t['id']);
    verificarMoedas($carteira->saldo($abandono) === 0, 'Abandonar nao concede moedas.');
    jogarMoedas(new RodadaQuiz($pdo, $dia), $abandono, 'fila');
    verificarMoedas($carteira->saldo($abandono) === 55, 'Erro preservado no abandono; duplicata nao contou como segundo erro.');

    $geral = criarContaMoedas();
    $rGeral = jogarMoedas($rodadas, $geral, 'todos');
    verificarMoedas($carteira->saldo($geral) === 120, 'Rodada geral perfeita rende 120.');
    $distintas = array_fill_keys($rGeral['perguntas'], true);
    foreach (['tad', 'lisimples', 'lisdupla', 'fila', 'filaprioridade', 'pilha'] as $tema) {
        $feita = jogarMoedas($rodadas, $geral, $tema);
        foreach ($feita['perguntas'] as $pergunta) $distintas[$pergunta] = true;
    }
    verificarMoedas($carteira->saldo($geral) === 10 * count($distintas), 'Trocar modalidades nao duplica premios por questao.');

    $noturno = criarContaMoedas();
    $t = $antesMeiaNoite->iniciar($noturno, 'fila');
    $q = $t['perguntas'][0];
    $t = $antesMeiaNoite->responder($noturno, $t['id'], $q, (string) $quiz->obterPergunta($q)['correta']);
    $t = $diaSeguinte->avancar($noturno, $t['id'], $q);
    while (!$t['concluida']) {
        $q = $t['perguntas'][$t['indice']];
        $t = $diaSeguinte->responder($noturno, $t['id'], $q, (string) $quiz->obterPergunta($q)['correta']);
        $t = $diaSeguinte->avancar($noturno, $t['id'], $q);
    }
    verificarMoedas($carteira->saldo($noturno) === 60, 'Rodada atravessando meia-noite conserva recompensas.');
    jogarMoedas($diaSeguinte, $noturno, 'fila');
    verificarMoedas($carteira->saldo($noturno) === 120, 'Novo lote do dia seguinte preserva moedas e evita repeticao do dia anterior.');

    $legado = criarContaMoedas();
    $antiga = $quiz->criarTentativa('tad', $legado);
    while (!$antiga['concluida']) {
        $q = $antiga['perguntas'][$antiga['indice']];
        $quiz->responder($antiga, $antiga['id'], $q, (string) $quiz->obterPergunta($q)['correta']);
        $quiz->avancar($antiga, $antiga['id'], $q);
    }
    $rodadas->importarLegada($legado, $antiga);
    $rodadas->importarLegada($legado, $antiga);
    verificarMoedas($rodadas->buscarAtual($legado, $antiga['id']) === $antiga, 'Resultado anterior preservado.');
    verificarMoedas($carteira->saldo($legado) === 0, 'Sem pagamentos retroativos de rodadas antigas.');

    $falhaId = criarContaMoedas();
    $pendente = jogarMoedas($rodadas, $falhaId, 'tad', [], true);
    $proxy = new class($pdo) {
        private $pdo;
        public function __construct($pdo) { $this->pdo = $pdo; }
        public function __call($metodo, $args) {
            if ($metodo === 'prepare' && strpos($args[0], 'UPDATE moedas_carteiras SET saldo') === 0) {
                throw new RuntimeException('Falha simulada antes de atualizar saldo.');
            }
            return $this->pdo->$metodo(...$args);
        }
    };
    try {
        (new RodadaQuiz($proxy, $dia))->avancar($falhaId, $pendente['id'], end($pendente['perguntas']));
        verificarMoedas(false, 'Deveria ocorrer a falha simulada.');
    } catch (RuntimeException $exception) {
        verificarMoedas($exception->getMessage() === 'Falha simulada antes de atualizar saldo.', 'Falha esperada.');
    }
    verificarMoedas($carteira->saldo($falhaId) === 0, 'Falha nao altera saldo.');
    verificarMoedas(!$rodadas->buscarAtual($falhaId)['concluida'], 'Falha preserva rodada para nova tentativa.');
    $rodadas->avancar($falhaId, $pendente['id'], end($pendente['perguntas']));
    verificarMoedas($carteira->saldo($falhaId) === 60, 'Rollback tambem preservou as recompensas diarias.');

    $concorrente = criarContaMoedas();
    $t = jogarMoedas($rodadas, $concorrente, 'tad', [], true);
    $arquivo = realpath(__DIR__ . '/../Model/Quiz/RodadaQuiz.php');
    $codigo = 'require ' . var_export($arquivo, true) . '; try { (new RodadaQuiz(null, new DateTimeImmutable("2026-10-01T15:00:00Z")))->avancar('
        . $concorrente . ', ' . var_export($t['id'], true) . ', ' . var_export(end($t['perguntas']), true)
        . '); echo "creditado"; } catch (DomainException $e) { echo "duplicado"; }';
    $processos = [];
    $pdo->beginTransaction();
    $carteira->bloquear($concorrente);
    try {
        for ($i = 0; $i < 2; $i++) {
            $processo = proc_open([PHP_BINARY, '-r', $codigo], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, null, null, ['bypass_shell' => true]);
            if (!is_resource($processo)) throw new RuntimeException('Falha ao iniciar processo de teste.');
            fclose($pipes[0]);
            $processos[] = [$processo, $pipes];
        }
        usleep(200000);
    } finally {
        $pdo->commit();
    }
    $saidas = [];
    foreach ($processos as [$processo, $pipes]) {
        $saidas[] = stream_get_contents($pipes[1]);
        $erros = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        verificarMoedas(proc_close($processo) === 0 && $erros === '', 'Processo concorrente sem erro PHP.');
    }
    sort($saidas);
    verificarMoedas($saidas === ['creditado', 'duplicado'], 'Somente uma conclusao concorrente aceita.');
    verificarMoedas($carteira->saldo($concorrente) === 60, 'Concorrencia nao duplica saldo.');
    verificarMoedas(count($carteira->historico($concorrente)) === 1, 'Um unico registro no historico.');
    verificarMoedas($rodadas->recompensas($id, $t['id'])['por_questao'] === [], 'Historico de outra conta nao e exposto.');
    echo "$verificacoes verificacoes de moedas passaram.\n";
} finally {
    if ($pdo->inTransaction()) $pdo->rollBack();
    foreach ($contas as $id => $email) {
        $pdo->prepare('DELETE FROM usuarios WHERE id = ? AND email = ?')->execute([$id, $email]);
    }
}
