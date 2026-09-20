<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';
require_once __DIR__ . '/../Model/Quiz/RodadaQuiz.php';
require_once __DIR__ . '/../Model/Avatar/AvatarLoja.php';

$pdo = Conexao::conectar();
$modelo = new AvatarLoja($pdo);
$carteira = new Carteira($pdo);
$contas = [];
$checks = 0;
function conferirAvatar($condicao, $mensagem)
{
    global $checks;
    $checks++;
    if (!$condicao) throw new RuntimeException($mensagem);
}
function rejeitarAvatar($acao)
{
    try { $acao(); } catch (DomainException $exception) { return; }
    throw new RuntimeException('A ação deveria ter sido rejeitada.');
}
function contaAvatar()
{
    global $contas;
    $email = 'avatar-test-' . bin2hex(random_bytes(8)) . '@example.invalid';
    $id = (new Usuario())->cadastrar('Teste de avatar', $email, 'Teste123!');
    $contas[$id] = $email;
    return $id;
}
try {
    $id = contaAvatar();
    $outro = contaAvatar();
    conferirAvatar($modelo->equipado($id) === CatalogoAvatar::iniciais(), 'Peças iniciais equipadas.');
    conferirAvatar($modelo->inventario($id) === [], 'Inventário inicial vazio.');
    rejeitarAvatar(fn() => $modelo->comprar($id, 'bone'));
    rejeitarAvatar(fn() => $modelo->comprar($id, 'roupa_basica'));
    rejeitarAvatar(fn() => $modelo->comprar($id, 'nao_existe'));
    rejeitarAvatar(fn() => $modelo->equipar($id, 'oculos'));
    conferirAvatar($carteira->saldo($id) === 0, 'Tentativas inválidas não descontam saldo.');

    $rodadas = new RodadaQuiz($pdo);
    $quiz = new Quiz();
    $tentativa = $rodadas->iniciar($id, 'tad');
    while (!$tentativa['concluida']) {
        $pergunta = $tentativa['perguntas'][$tentativa['indice']];
        $tentativa = $rodadas->responder($id, $tentativa['id'], $pergunta, (string) $quiz->obterPergunta($pergunta)['correta']);
        $tentativa = $rodadas->avancar($id, $tentativa['id'], $pergunta);
    }
    conferirAvatar($carteira->saldo($id) === 60, 'Quiz credita 60 moedas.');
    conferirAvatar($modelo->comprar($id, 'bone') === 35, 'Compra debita o preço exato.');
    conferirAvatar(isset($modelo->inventario($id)['bone']), 'Item comprado consta no armário.');
    conferirAvatar($modelo->equipado($id)['cabelo'] === 'bone', 'Compra equipa a peça.');
    rejeitarAvatar(fn() => $modelo->comprar($id, 'bone'));
    conferirAvatar($carteira->saldo($id) === 35, 'Compra repetida não desconta de novo.');
    $modelo->equipar($id, 'cabelo_curto');
    conferirAvatar($modelo->equipado($id)['cabelo'] === 'cabelo_curto', 'Peça inicial pode ser reequipada.');
    $modelo->equipar($id, 'bone');
    conferirAvatar((new AvatarLoja($pdo))->equipado($id)['cabelo'] === 'bone', 'Equipamento persiste no banco.');
    conferirAvatar($modelo->comprar($id, 'rosto_serio') === 15, 'Outra categoria pode ser comprada.');
    rejeitarAvatar(fn() => $modelo->comprar($id, 'oculos'));
    conferirAvatar($carteira->saldo($id) === 15, 'Saldo insuficiente não desconta.');
    rejeitarAvatar(fn() => $modelo->equipar($outro, 'bone'));
    conferirAvatar($modelo->inventario($outro) === [], 'Inventário não vaza entre contas.');
    $modelo->removerAcessorio($id);
    conferirAvatar(!isset($modelo->equipado($id)['acessorio']), 'Remover acessório vazio é seguro.');

    $concorrente = contaAvatar();
    $pdo->prepare('INSERT INTO moedas_carteiras (usuario_id, saldo) VALUES (?, 50)')->execute([$concorrente]);
    $arquivo = realpath(__DIR__ . '/../Model/Avatar/AvatarLoja.php');
    $codigo = 'require ' . var_export($arquivo, true) . '; try { (new AvatarLoja())->comprar(' . $concorrente . ', "chapeu"); echo "comprou"; } catch (DomainException $e) { echo "repetida"; }';
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
        conferirAvatar(proc_close($processo) === 0 && $erro === '', 'Processo concorrente sem erro PHP.');
    }
    sort($saidas);
    conferirAvatar($saidas === ['comprou', 'repetida'], 'Uma única compra concorrente.');
    conferirAvatar($carteira->saldo($concorrente) === 5, 'Saldo debitado uma vez.');
    conferirAvatar(count($modelo->inventario($concorrente)) === 1, 'Uma peça no armário após concorrência.');
    echo "$checks verificacoes de avatar e loja passaram.\n";
} finally {
    if ($pdo->inTransaction()) $pdo->rollBack();
    foreach ($contas as $id => $email) {
        $pdo->prepare('DELETE FROM usuarios WHERE id = ? AND email = ?')->execute([$id, $email]);
    }
}
