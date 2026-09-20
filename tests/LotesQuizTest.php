<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';
require_once __DIR__ . '/../Model/Quiz/RodadaQuiz.php';

$pdo = Conexao::conectar();
$quiz = new Quiz();
$carteira = new Carteira($pdo);
$dia = new DateTimeImmutable('2026-10-10 12:00:00', new DateTimeZone('America/Sao_Paulo'));
$modelo = new RodadaQuiz($pdo, $dia);
$contas = [];
$verificacoes = 0;

function conferirLote($condicao, $mensagem)
{
    global $verificacoes;
    $verificacoes++;
    if (!$condicao) throw new RuntimeException($mensagem);
}

function rejeitarLote($acao)
{
    try { $acao(); } catch (DomainException $exception) { return; }
    throw new RuntimeException('A operação deveria ser rejeitada.');
}

function criarContaLote()
{
    global $contas;
    $email = 'lote-test-' . bin2hex(random_bytes(8)) . '@example.invalid';
    $id = (new Usuario())->cadastrar('Teste de lotes', $email, 'Teste123!');
    $contas[$id] = $email;
    return $id;
}

function concluirLote($modelo, $usuarioId, $tentativa)
{
    global $quiz;
    while (!$tentativa['concluida']) {
        $pergunta = $tentativa['perguntas'][$tentativa['indice']];
        $tentativa = $modelo->responder($usuarioId, $tentativa['id'], $pergunta, (string) $quiz->obterPergunta($pergunta)['correta']);
        $tentativa = $modelo->avancar($usuarioId, $tentativa['id'], $pergunta);
    }
    return $tentativa;
}

try {
    $id = criarContaLote();
    conferirLote(!$modelo->podeRenovar($id, 'pilha'), 'Não há troca antes do lote grátis.');
    rejeitarLote(fn() => $modelo->renovarEIniciar($id, 'pilha'));
    $primeira = $modelo->iniciar($id, 'pilha');
    conferirLote(count($primeira['perguntas']) === 6, 'Pilha tem seis perguntas.');
    conferirLote($modelo->podeRenovar($id, 'pilha'), 'Outro lote disponível após iniciar.');
    rejeitarLote(fn() => $modelo->renovarEIniciar($id, 'pilha'));
    $primeira = concluirLote($modelo, $id, $primeira);
    conferirLote($carteira->saldo($id) === 60, 'Primeira rodada rende 60 moedas.');
    $repetida = concluirLote($modelo, $id, $modelo->iniciar($id, 'pilha'));
    conferirLote($repetida['perguntas'] === $primeira['perguntas'], 'Repetição gratuita usa o mesmo lote.');
    conferirLote($carteira->saldo($id) === 60, 'Repetição não gera moedas duplicadas.');

    $falha = new class($pdo) {
        private $pdo;
        public function __construct($pdo) { $this->pdo = $pdo; }
        public function __call($metodo, $args) {
            if ($metodo === 'prepare' && strpos($args[0], 'INSERT INTO quiz_rodadas') === 0) {
                throw new RuntimeException('Falha simulada depois do débito.');
            }
            return $this->pdo->$metodo(...$args);
        }
    };
    try {
        (new RodadaQuiz($falha, $dia))->renovarEIniciar($id, 'pilha');
        throw new RuntimeException('Deveria falhar ao criar a rodada.');
    } catch (RuntimeException $exception) {
        conferirLote($exception->getMessage() === 'Falha simulada depois do débito.', 'Falha simulada ocorreu.');
    }
    conferirLote($carteira->saldo($id) === 60, 'Falha não desconta moedas.');
    conferirLote($modelo->podeRenovar($id, 'pilha'), 'Falha não consome o próximo lote.');

    $nova = $modelo->renovarEIniciar($id, 'pilha');
    conferirLote($carteira->saldo($id) === 55, 'Troca desconta exatamente cinco moedas.');
    conferirLote(count(array_intersect($primeira['perguntas'], $nova['perguntas'])) === 0, 'Troca usa perguntas inéditas no modo naquele dia.');
    conferirLote(!$modelo->podeRenovar($id, 'pilha'), 'Lotes de Pilha esgotados no dia.');
    $nova = concluirLote($modelo, $id, $nova);
    conferirLote($carteira->saldo($id) === 115, 'Segundo lote também pode render moedas.');
    rejeitarLote(fn() => $modelo->renovarEIniciar($id, 'pilha'));
    conferirLote($carteira->saldo($id) === 115, 'Lote esgotado não desconta.');
    $stmt = $pdo->prepare("SELECT renovacoes, moedas_gastas FROM quiz_lotes_dia WHERE usuario_id = ? AND tema = 'pilha'");
    $stmt->execute([$id]);
    $registro = $stmt->fetch();
    conferirLote((int) $registro['renovacoes'] === 1 && (int) $registro['moedas_gastas'] === 5, 'Uma única troca registrada.');

    $amanha = new RodadaQuiz($pdo, $dia->modify('+1 day'));
    conferirLote(!$amanha->podeRenovar($id, 'pilha'), 'Novo dia começa com lote grátis.');
    $proxima = $amanha->iniciar($id, 'pilha');
    conferirLote(count(array_intersect($nova['perguntas'], $proxima['perguntas'])) === 0, 'Novo dia difere do último lote do dia anterior.');
    conferirLote($carteira->saldo($id) === 115, 'Novo lote diário é gratuito.');
    $amanha->abandonar($id, $proxima['id']);

    $semMoedas = criarContaLote();
    $t = $modelo->iniciar($semMoedas, 'tad');
    $modelo->abandonar($semMoedas, $t['id']);
    rejeitarLote(fn() => $modelo->renovarEIniciar($semMoedas, 'tad'));
    conferirLote($carteira->saldo($semMoedas) === 0, 'Saldo insuficiente não cria dívida.');
    rejeitarLote(fn() => $modelo->renovarEIniciar($id, 'inexistente'));

    $geral = criarContaLote();
    $rGeral = concluirLote($modelo, $geral, $modelo->iniciar($geral, 'todos'));
    conferirLote(count($rGeral['perguntas']) === 12, 'Rodada geral inclui 12 perguntas.');
    $trocaGeral = $modelo->renovarEIniciar($geral, 'todos');
    conferirLote(count(array_intersect($rGeral['perguntas'], $trocaGeral['perguntas'])) === 0, 'Troca geral não repete perguntas.');
    conferirLote($carteira->saldo($geral) === 115, 'Troca geral desconta cinco moedas.');
    $modelo->abandonar($geral, $trocaGeral['id']);

    $concorrente = criarContaLote();
    concluirLote($modelo, $concorrente, $modelo->iniciar($concorrente, 'fila'));
    $arquivo = realpath(__DIR__ . '/../Model/Quiz/RodadaQuiz.php');
    $codigo = 'require ' . var_export($arquivo, true) . '; try { (new RodadaQuiz(null, new DateTimeImmutable("2026-10-10T15:00:00Z")))->renovarEIniciar('
        . $concorrente . ', "fila"); echo "trocou"; } catch (DomainException $e) { echo "rejeitada"; }';
    $processos = [];
    $pdo->beginTransaction();
    $carteira->bloquear($concorrente);
    try {
        for ($i = 0; $i < 2; $i++) {
            $processo = proc_open([PHP_BINARY, '-r', $codigo], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, null, null, ['bypass_shell' => true]);
            if (!is_resource($processo)) throw new RuntimeException('Falha ao iniciar teste concorrente.');
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
        $erro = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        conferirLote(proc_close($processo) === 0 && $erro === '', 'Processo concorrente sem erro PHP.');
    }
    sort($saidas);
    conferirLote($saidas === ['rejeitada', 'trocou'], 'Apenas uma troca simultânea aceita.');
    conferirLote($carteira->saldo($concorrente) === 55, 'Troca simultânea debita uma vez.');
    echo "$verificacoes verificacoes dos lotes diarios passaram.\n";
} finally {
    if ($pdo->inTransaction()) $pdo->rollBack();
    foreach ($contas as $id => $email) {
        $pdo->prepare('DELETE FROM usuarios WHERE id = ? AND email = ?')->execute([$id, $email]);
    }
}
