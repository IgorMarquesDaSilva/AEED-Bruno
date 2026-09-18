<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/../Model/Quiz/Quiz.php';

$verificacoes = 0;
function verificar($condicao, $mensagem)
{
    global $verificacoes;
    $verificacoes++;
    if (!$condicao) throw new RuntimeException($mensagem);
}

function rejeitar($operacao, $mensagem)
{
    try {
        $operacao();
    } catch (DomainException $exception) {
        verificar(true, $mensagem);
        return;
    }
    verificar(false, $mensagem);
}

$quiz = new Quiz();
$banco = Perguntas::listar();
verificar(count($banco) === 25, 'O banco deve conter 25 perguntas.');
foreach ($banco as $id => $pergunta) {
    verificar(isset($quiz->listarTemas()[$pergunta['tema']]), "Tema valido: $id");
    verificar(count($pergunta['alternativas']) === 4, "Quatro alternativas: $id");
    verificar(count(array_unique($pergunta['alternativas'])) === 4, "Alternativas distintas: $id");
    verificar(isset($pergunta['alternativas'][$pergunta['correta']]), "Gabarito valido: $id");
    verificar($pergunta['explicacao'] !== '', "Explicacao presente: $id");
    verificar($pergunta['tipo'] !== 'Código' || !empty($pergunta['codigo']), "Codigo presente: $id");
}

foreach (array_keys($quiz->listarTemas()) as $tema) {
    $tentativa = $quiz->criarTentativa($tema, 42);
    $total = $tema === 'todos' ? 10 : 5;
    verificar(count($tentativa['perguntas']) === $total, "Total por tema: $tema");
    verificar(count(array_unique($tentativa['perguntas'])) === $total, 'Sem repeticao de perguntas.');
    $tipos = [];
    foreach ($tentativa['perguntas'] as $id) {
        $pergunta = $quiz->obterPergunta($id);
        verificar($tema === 'todos' || $pergunta['tema'] === $tema, 'Filtro de materia.');
        $tipos[$pergunta['tema']][$pergunta['tipo']] = true;
        $quiz->responder($tentativa, $tentativa['id'], $id, (string) $pergunta['correta']);
        $quiz->avancar($tentativa, $tentativa['id'], $id);
    }
    foreach ($tipos as $tiposDoTema) {
        verificar(isset($tiposDoTema['Teoria'], $tiposDoTema['Código']), 'Teoria e codigo em cada materia.');
    }
    $resultado = $quiz->obterResultado($tentativa);
    verificar($tentativa['concluida'], 'Rodada finalizada.');
    verificar($resultado['acertos'] === $total && $resultado['percentual'] === 100, 'Pontuacao maxima.');
    verificar(count($resultado['revisao']) === $total, 'Revisao completa.');
    rejeitar(function () use ($quiz, &$tentativa, $id) { $quiz->responder($tentativa, $tentativa['id'], $id, '0'); }, 'Nao responder apos concluir.');
}

$tentativa = $quiz->criarTentativa('todos', 42);
$id = $tentativa['perguntas'][0];
$vazia = $tentativa;
rejeitar(function () use ($quiz, &$tentativa, $id) { $quiz->avancar($tentativa, $tentativa['id'], $id); }, 'Nao pular pergunta.');
foreach (['', '-1', '4', '0.5', '00', [], null] as $invalida) {
    rejeitar(function () use ($quiz, &$tentativa, $id, $invalida) { $quiz->responder($tentativa, $tentativa['id'], $id, $invalida); }, 'Rejeitar alternativa invalida.');
}
rejeitar(function () use ($quiz, &$tentativa, $id) { $quiz->responder($tentativa, 'antiga', $id, '0'); }, 'Rejeitar rodada antiga.');
rejeitar(function () use ($quiz, &$tentativa) { $quiz->responder($tentativa, $tentativa['id'], $tentativa['perguntas'][1], '0'); }, 'Rejeitar outra pergunta.');
verificar($tentativa === $vazia, 'Entradas invalidas nao alteram a rodada.');

$correta = $quiz->obterPergunta($id)['correta'];
$quiz->responder($tentativa, $tentativa['id'], $id, (string) $correta);
$respondida = $tentativa;
rejeitar(function () use ($quiz, &$tentativa, $id, $correta) { $quiz->responder($tentativa, $tentativa['id'], $id, (string) (($correta + 1) % 4)); }, 'Nao alterar resposta enviada.');
verificar($tentativa === $respondida, 'Envio duplicado nao altera resposta.');
$quiz->avancar($tentativa, $tentativa['id'], $id);
rejeitar(function () use ($quiz, &$tentativa, $id) { $quiz->avancar($tentativa, $tentativa['id'], $id); }, 'Avanco duplicado nao pula questao.');
verificar($tentativa['indice'] === 1, 'Continua na segunda pergunta.');

while (!$tentativa['concluida']) {
    $id = $tentativa['perguntas'][$tentativa['indice']];
    $errada = ($quiz->obterPergunta($id)['correta'] + 1) % 4;
    $quiz->responder($tentativa, $tentativa['id'], $id, (string) $errada);
    $quiz->avancar($tentativa, $tentativa['id'], $id);
}
$resultado = $quiz->obterResultado($tentativa);
verificar($resultado['acertos'] === 1 && $resultado['percentual'] === 10, 'Contagem mista de acertos e erros.');
rejeitar(function () use ($quiz) { $quiz->criarTentativa('inexistente', 42); }, 'Tema inexistente.');
rejeitar(function () use ($quiz) { $quiz->criarTentativa([], 42); }, 'Tema malformado.');
echo "$verificacoes verificacoes passaram.\n";
