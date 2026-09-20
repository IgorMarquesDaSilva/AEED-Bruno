<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';
require_once __DIR__ . '/../Model/Quiz/RodadaQuiz.php';

$pdo = Conexao::conectar();
$quiz = new Quiz();
$loja = new AvatarLoja($pdo);
$rodadas = new RodadaQuiz($pdo);
$carteira = new Carteira($pdo);
$email = 'habilidades-test-' . bin2hex(random_bytes(8)) . '@example.invalid';
$usuarioId = (new Usuario())->cadastrar('Teste de habilidades', $email, 'Teste123!');
$checks = 0;

function conferirHabilidade($condicao, $mensagem)
{
    global $checks;
    $checks++;
    if (!$condicao) throw new RuntimeException($mensagem);
}

function rejeitarHabilidade($acao)
{
    try { $acao(); } catch (DomainException $exception) { return; }
    throw new RuntimeException('A operacao deveria ter sido rejeitada.');
}

try {
    foreach (CatalogoAvatar::itens() as $itemId => $item) {
        if ($item['preco'] > 0) conferirHabilidade(isset(CatalogoAvatar::habilidades()[$itemId]), 'Item pago sem habilidade: ' . $itemId);
    }
    $pdo->prepare('INSERT INTO moedas_carteiras (usuario_id, saldo) VALUES (?, 200)')->execute([$usuarioId]);
    $loja->comprar($usuarioId, 'bone');
    $loja->comprar($usuarioId, 'roupa_azul');
    $loja->comprar($usuarioId, 'oculos');
    conferirHabilidade(count($loja->habilidadesEquipadas($usuarioId)) === 3, 'Tres habilidades equipadas.');
    conferirHabilidade($carteira->saldo($usuarioId) === 105, 'Compras descontadas.');

    $tentativa = $rodadas->iniciar($usuarioId, 'pilha');
    conferirHabilidade(count($tentativa['habilidades']) === 3, 'Habilidades copiadas para a rodada.');
    $loja->equipar($usuarioId, 'cabelo_curto');
    conferirHabilidade(!in_array('bone', $loja->habilidadesEquipadas($usuarioId), true), 'Bone nao esta mais equipado.');
    $id = $tentativa['perguntas'][0];
    $correta = $quiz->obterPergunta($id)['correta'];
    $tentativa = $rodadas->usarHabilidade($usuarioId, $tentativa['id'], $id, 'bone');
    $ocultas = $tentativa['ajudas'][$id]['ocultas'];
    conferirHabilidade(count($ocultas) === 1 && $ocultas[0] !== $correta, 'Bone elimina uma errada mesmo apos sair do avatar.');
    rejeitarHabilidade(fn() => $rodadas->usarHabilidade($usuarioId, $tentativa['id'], $id, 'oculos'));
    rejeitarHabilidade(fn() => $rodadas->responder($usuarioId, $tentativa['id'], $id, (string) $ocultas[0]));
    conferirHabilidade($tentativa['habilidades']['bone'] === true, 'Uso do bone persistido.');
    $tentativa = $rodadas->responder($usuarioId, $tentativa['id'], $id, (string) $correta);
    $tentativa = $rodadas->avancar($usuarioId, $tentativa['id'], $id);

    $id = $tentativa['perguntas'][1];
    $correta = $quiz->obterPergunta($id)['correta'];
    $errada = (string) (($correta + 1) % 4);
    $tentativa = $rodadas->usarHabilidade($usuarioId, $tentativa['id'], $id, 'roupa_azul');
    $tentativa = $rodadas->responder($usuarioId, $tentativa['id'], $id, $errada);
    conferirHabilidade(!isset($tentativa['respostas'][$id]) && $tentativa['ajudas'][$id]['erro'] === (int) $errada, 'Escudo concede segunda tentativa.');
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM quiz_respostas WHERE rodada_id = ? AND pergunta_id = ?');
    $stmt->execute([$tentativa['id'], $id]);
    conferirHabilidade((int) $stmt->fetchColumn() === 0, 'Primeira resposta protegida nao e registrada.');
    rejeitarHabilidade(fn() => $rodadas->responder($usuarioId, $tentativa['id'], $id, $errada));
    $tentativa = $rodadas->responder($usuarioId, $tentativa['id'], $id, (string) $correta);
    conferirHabilidade($tentativa['respostas'][$id] === $correta, 'Segunda resposta correta e aceita.');
    $tentativa = $rodadas->avancar($usuarioId, $tentativa['id'], $id);

    $id = $tentativa['perguntas'][2];
    $correta = $quiz->obterPergunta($id)['correta'];
    $tentativa = $rodadas->usarHabilidade($usuarioId, $tentativa['id'], $id, 'oculos');
    $ocultas = $tentativa['ajudas'][$id]['ocultas'];
    conferirHabilidade(count(array_unique($ocultas)) === 2 && !in_array($correta, $ocultas, true), 'Oculos eliminam duas erradas distintas.');
    $tentativa = $rodadas->responder($usuarioId, $tentativa['id'], $id, (string) $correta);
    $tentativa = $rodadas->avancar($usuarioId, $tentativa['id'], $id);
    rejeitarHabilidade(fn() => $rodadas->usarHabilidade($usuarioId, $tentativa['id'], $tentativa['perguntas'][3], 'bone'));

    while (!$tentativa['concluida']) {
        $id = $tentativa['perguntas'][$tentativa['indice']];
        $tentativa = $rodadas->responder($usuarioId, $tentativa['id'], $id, (string) $quiz->obterPergunta($id)['correta']);
        $tentativa = $rodadas->avancar($usuarioId, $tentativa['id'], $id);
    }
    conferirHabilidade($rodadas->recompensas($usuarioId, $tentativa['id'])['ganhas'] === 60, 'Escudo nao reduz recompensa de acerto.');
    conferirHabilidade($carteira->saldo($usuarioId) === 165, 'Saldo final confere.');
    $nova = $rodadas->iniciar($usuarioId, 'pilha');
    conferirHabilidade(!isset($nova['habilidades']['bone']) && isset($nova['habilidades']['roupa_azul']), 'Rodada seguinte usa equipamentos atuais.');
    rejeitarHabilidade(fn() => $rodadas->usarHabilidade($usuarioId, $nova['id'], $nova['perguntas'][0], 'bone'));
    $id = $nova['perguntas'][0];
    $correta = $quiz->obterPergunta($id)['correta'];
    $nova = $rodadas->usarHabilidade($usuarioId, $nova['id'], $id, 'roupa_azul');
    $nova = $rodadas->responder($usuarioId, $nova['id'], $id, (string) (($correta + 1) % 4));
    $nova = $rodadas->responder($usuarioId, $nova['id'], $id, (string) (($correta + 2) % 4));
    conferirHabilidade($nova['respostas'][$id] === ($correta + 2) % 4, 'Segundo erro encerra a questao normalmente.');
    $stmt = $pdo->prepare('SELECT erros FROM moedas_questoes_dia WHERE usuario_id = ? AND pergunta_id = ?');
    $stmt->execute([$usuarioId, $id]);
    conferirHabilidade((int) $stmt->fetchColumn() === 1, 'Segundo erro entra no controle diario.');
    $rodadas->abandonar($usuarioId, $nova['id']);
    echo "$checks verificacoes de habilidades passaram.\n";
} finally {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $pdo->prepare('DELETE FROM usuarios WHERE id = ? AND email = ?')->execute([$usuarioId, $email]);
}
