<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';
require_once __DIR__ . '/../Model/Quiz/RodadaQuiz.php';

$pdo = Conexao::conectar();
$quiz = new Quiz();
$modelo = new RodadaQuiz($pdo);
$carteira = new Carteira($pdo);
$contas = [];
$checks = 0;

function conferirDica($condicao, $mensagem)
{
    global $checks;
    $checks++;
    if (!$condicao) throw new RuntimeException($mensagem);
}

function rejeitarDica($acao)
{
    try { $acao(); } catch (DomainException $exception) { return; }
    throw new RuntimeException('A compra deveria ter sido rejeitada.');
}

function criarContaDica()
{
    global $contas;
    $email = 'dicas-test-' . bin2hex(random_bytes(8)) . '@example.invalid';
    $id = (new Usuario())->cadastrar('Teste de dicas', $email, 'Teste123!');
    $contas[$id] = $email;
    return $id;
}

try {
    $perguntas = Perguntas::listar();
    $dicas = DicasQuiz::listar();
    conferirDica(count($perguntas) === count($dicas) && !array_diff(array_keys($perguntas), array_keys($dicas)), 'Toda pergunta possui dica.');
    foreach ($dicas as $id => $texto) conferirDica(is_string($texto) && trim($texto) !== '', 'Dica vazia: ' . $id);
    rejeitarDica(fn() => DicasQuiz::obter('inexistente'));

    $id = criarContaDica();
    $rodada = $modelo->iniciar($id, 'pilha');
    $pergunta = $rodada['perguntas'][0];
    conferirDica(!$modelo->dicaComprada($id, $pergunta), 'Dica inicialmente bloqueada.');
    rejeitarDica(fn() => $modelo->comprarDica($id, $rodada['id'], $pergunta));
    conferirDica($carteira->saldo($id) === 0, 'Saldo insuficiente nao cria divida.');
    rejeitarDica(fn() => $modelo->comprarDica($id, $rodada['id'], $rodada['perguntas'][1]));

    $pdo->prepare('UPDATE moedas_carteiras SET saldo = 10 WHERE usuario_id = ?')->execute([$id]);
    $falha = new class($pdo) {
        private $pdo;
        public function __construct($pdo) { $this->pdo = $pdo; }
        public function __call($metodo, $args) {
            if ($metodo === 'prepare' && strpos($args[0], 'INSERT INTO quiz_dicas') === 0) {
                throw new RuntimeException('Falha simulada depois do debito.');
            }
            return $this->pdo->$metodo(...$args);
        }
    };
    try {
        (new RodadaQuiz($falha))->comprarDica($id, $rodada['id'], $pergunta);
        throw new RuntimeException('A falha simulada nao ocorreu.');
    } catch (RuntimeException $exception) {
        conferirDica($exception->getMessage() === 'Falha simulada depois do debito.', 'Falha simulada ocorreu.');
    }
    conferirDica($carteira->saldo($id) === 10 && !$modelo->dicaComprada($id, $pergunta), 'Debito revertido na falha.');

    conferirDica($modelo->comprarDica($id, $rodada['id'], $pergunta) === 7, 'Compra custa tres moedas.');
    conferirDica($modelo->dicaComprada($id, $pergunta), 'Dica persiste para a conta.');
    conferirDica((new RodadaQuiz($pdo))->dicaComprada($id, $pergunta), 'Dica sobrevive a nova instancia e F5.');
    conferirDica($modelo->comprarDica($id, $rodada['id'], $pergunta) === 7, 'Compra repetida nao cobra de novo.');
    $stmt = $pdo->prepare('SELECT custo_moedas FROM quiz_dicas WHERE usuario_id = ? AND pergunta_id = ?');
    $stmt->execute([$id, $pergunta]);
    conferirDica((int) $stmt->fetchColumn() === RodadaQuiz::PRECO_DICA, 'Custo registrado no banco.');

    $outro = criarContaDica();
    conferirDica(!$modelo->dicaComprada($outro, $pergunta), 'Dica nao vaza para outra conta.');
    rejeitarDica(fn() => $modelo->comprarDica($outro, $rodada['id'], $pergunta));
    $modelo->responder($id, $rodada['id'], $pergunta, (string) $quiz->obterPergunta($pergunta)['correta']);
    rejeitarDica(fn() => $modelo->comprarDica($id, $rodada['id'], $pergunta));
    $modelo->abandonar($id, $rodada['id']);
    conferirDica($modelo->dicaComprada($id, $pergunta), 'Dica continua desbloqueada apos abandono.');

    $concorrente = criarContaDica();
    $nova = $modelo->iniciar($concorrente, 'tad');
    $qConcorrente = $nova['perguntas'][0];
    $pdo->prepare('UPDATE moedas_carteiras SET saldo = 10 WHERE usuario_id = ?')->execute([$concorrente]);
    $arquivo = realpath(__DIR__ . '/../Model/Quiz/RodadaQuiz.php');
    $codigo = 'require ' . var_export($arquivo, true) . '; echo (new RodadaQuiz())->comprarDica('
        . $concorrente . ', ' . var_export($nova['id'], true) . ', ' . var_export($qConcorrente, true) . ');';
    $processos = [];
    $pdo->beginTransaction();
    $carteira->bloquear($concorrente);
    try {
        for ($i = 0; $i < 2; $i++) {
            $processo = proc_open([PHP_BINARY, '-r', $codigo], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, null, null, ['bypass_shell' => true]);
            if (!is_resource($processo)) throw new RuntimeException('Falha ao iniciar processo concorrente.');
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
        conferirDica(proc_close($processo) === 0 && $erro === '', 'Processo concorrente sem erro.');
    }
    conferirDica($saidas === ['7', '7'], 'Pedidos simultaneos recebem a mesma dica.');
    conferirDica($carteira->saldo($concorrente) === 7, 'Somente um debito simultaneo.');
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM quiz_dicas WHERE usuario_id = ? AND pergunta_id = ?');
    $stmt->execute([$concorrente, $qConcorrente]);
    conferirDica((int) $stmt->fetchColumn() === 1, 'Uma unica compra simultanea registrada.');
    $modelo->abandonar($concorrente, $nova['id']);
    echo "$checks verificacoes de dicas passaram.\n";
} finally {
    if ($pdo->inTransaction()) $pdo->rollBack();
    foreach ($contas as $id => $email) {
        $pdo->prepare('DELETE FROM usuarios WHERE id = ? AND email = ?')->execute([$id, $email]);
    }
}
