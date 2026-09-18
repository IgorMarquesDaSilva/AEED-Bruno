<?php
require_once __DIR__ . '/LoginController.php';
require_once __DIR__ . '/../Model/Quiz/Quiz.php';

class QuizController
{
    public function index()
    {
        LoginController::verificarLogin();
        header('Cache-Control: no-store');

        $quiz = new Quiz();
        $usuarioId = $_SESSION['usuario']['id'];
        if (isset($_SESSION['quiz']) && $_SESSION['quiz']['usuario_id'] !== $usuarioId) {
            unset($_SESSION['quiz']);
        }
        if (empty($_SESSION['quiz_csrf'])) {
            $_SESSION['quiz_csrf'] = bin2hex(random_bytes(32));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $csrf = $_POST['csrf'] ?? '';
                if (!is_string($csrf) || !hash_equals($_SESSION['quiz_csrf'], $csrf)) {
                    throw new DomainException('O formulário expirou. Tente novamente nesta página.');
                }
                $acao = $_POST['acao'] ?? '';
                if ($acao === 'iniciar') {
                    if (isset($_SESSION['quiz'])) {
                        throw new DomainException('Já existe uma rodada. Continue ou escolha um novo quiz ao terminar.');
                    }
                    $_SESSION['quiz'] = $quiz->criarTentativa($_POST['tema'] ?? '', $usuarioId);
                } elseif (in_array($acao, ['responder', 'avancar', 'novo', 'abandonar'], true)) {
                    if (!isset($_SESSION['quiz']) || ($_POST['tentativa'] ?? '') !== $_SESSION['quiz']['id']) {
                        throw new DomainException('Esta rodada não está mais ativa. Confira o quiz atual.');
                    }
                    if ($acao === 'responder') {
                        $quiz->responder($_SESSION['quiz'], $_POST['tentativa'], $_POST['pergunta'] ?? '', $_POST['alternativa'] ?? '');
                    } elseif ($acao === 'avancar') {
                        $quiz->avancar($_SESSION['quiz'], $_POST['tentativa'], $_POST['pergunta'] ?? '');
                    } elseif ($acao === 'novo' && !$_SESSION['quiz']['concluida']) {
                        throw new DomainException('Finalize a rodada ou use a opção de encerrar o quiz.');
                    } else {
                        unset($_SESSION['quiz']);
                    }
                } else {
                    throw new DomainException('Ação inválida. Utilize as opções do quiz.');
                }
            } catch (DomainException $exception) {
                $_SESSION['quiz_erro'] = $exception->getMessage();
            }
            // POST/Redirect/GET evita reenviar uma resposta ao atualizar a página.
            header('Location: index.php?pagina=quiz', true, 303);
            exit;
        }

        $temas = $quiz->listarTemas();
        $tentativa = $_SESSION['quiz'] ?? null;
        $csrf = $_SESSION['quiz_csrf'];
        $erro = $_SESSION['quiz_erro'] ?? '';
        unset($_SESSION['quiz_erro']);
        $resultado = $tentativa ? $quiz->obterResultado($tentativa) : null;
        $perguntaId = $tentativa && !$tentativa['concluida'] ? $tentativa['perguntas'][$tentativa['indice']] : null;
        $pergunta = $perguntaId ? $quiz->obterPergunta($perguntaId) : null;
        $respondida = $perguntaId && array_key_exists($perguntaId, $tentativa['respostas']);

        $titulo = 'Quiz de Estruturas de Dados';
        $bodyClass = 'pagina-quiz';
        $mainClass = 'container conteudo-quiz';
        $cssPagina = ['View/Assets/css/quiz.css'];
        require __DIR__ . '/../View/Quiz/index.php';
    }
}
