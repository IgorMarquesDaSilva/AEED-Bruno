<?php
require_once __DIR__ . '/LoginController.php';
require_once __DIR__ . '/../Model/Quiz/Quiz.php';
require_once __DIR__ . '/../Model/Quiz/RodadaQuiz.php';

class QuizController
{
    public function index()
    {
        LoginController::verificarLogin();
        header('Cache-Control: no-store');

        $quiz = new Quiz();
        $usuarioId = (int) $_SESSION['usuario']['id'];
        $rodadas = new RodadaQuiz();
        if (empty($_SESSION['quiz_csrf'])) {
            $_SESSION['quiz_csrf'] = bin2hex(random_bytes(32));
        }

        $erro = $_SESSION['quiz_erro'] ?? '';
        unset($_SESSION['quiz_erro']);
        $tentativa = null;
        $recompensas = null;
        $dicaComprada = false;
        $podeRenovar = false;
        $indisponivel = false;
        try {
            if (isset($_SESSION['quiz'])) {
                $rodadas->importarLegada($usuarioId, $_SESSION['quiz']);
                $_SESSION['quiz_id'] = $_SESSION['quiz']['id'];
                unset($_SESSION['quiz']);
            }
            $tentativa = $rodadas->buscarAtual($usuarioId, $_SESSION['quiz_id'] ?? null);
            if ($tentativa) {
                $_SESSION['quiz_id'] = $tentativa['id'];
                if ($tentativa['concluida']) {
                    $recompensas = $rodadas->recompensas($usuarioId, $tentativa['id']);
                    $podeRenovar = $rodadas->podeRenovar($usuarioId, $tentativa['tema']);
                } else {
                    $perguntaAtualId = $tentativa['perguntas'][$tentativa['indice']];
                    $dicaComprada = $rodadas->dicaComprada($usuarioId, $perguntaAtualId);
                }
            }
        } catch (Throwable $exception) {
            http_response_code(503);
            $indisponivel = true;
            $erro = 'O quiz está temporariamente indisponível. Tente novamente em instantes.';
            error_log('AEED: falha ao consultar as rodadas; confira as migracoes de moedas, lotes e dicas.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$indisponivel) {
            try {
                $csrf = $_POST['csrf'] ?? '';
                if (!is_string($csrf) || !hash_equals($_SESSION['quiz_csrf'], $csrf)) {
                    throw new DomainException('O formulário expirou. Tente novamente nesta página.');
                }
                $acao = $_POST['acao'] ?? '';
                if ($acao === 'iniciar') {
                    if ($tentativa) {
                        throw new DomainException('Já existe uma rodada. Continue ou escolha um novo quiz ao terminar.');
                    }
                    $tentativa = $rodadas->iniciar($usuarioId, $_POST['tema'] ?? '');
                    $_SESSION['quiz_id'] = $tentativa['id'];
                } elseif (in_array($acao, ['responder', 'avancar', 'habilidade', 'comprar_dica', 'novo', 'abandonar', 'renovar'], true)) {
                    if (!$tentativa || ($_POST['tentativa'] ?? '') !== $tentativa['id']) {
                        throw new DomainException('Esta rodada não está mais ativa. Confira o quiz atual.');
                    }
                    if ($acao === 'responder') {
                        $rodadas->responder($usuarioId, $tentativa['id'], $_POST['pergunta'] ?? '', $_POST['alternativa'] ?? '');
                    } elseif ($acao === 'habilidade') {
                        $rodadas->usarHabilidade($usuarioId, $tentativa['id'], $_POST['pergunta'] ?? '', $_POST['item'] ?? '');
                    } elseif ($acao === 'comprar_dica') {
                        $rodadas->comprarDica($usuarioId, $tentativa['id'], $_POST['pergunta'] ?? '');
                    } elseif ($acao === 'avancar') {
                        $rodadas->avancar($usuarioId, $tentativa['id'], $_POST['pergunta'] ?? '');
                    } elseif ($acao === 'renovar') {
                        if (!$tentativa['concluida']) throw new DomainException('Finalize a rodada antes de trocar as perguntas.');
                        $nova = $rodadas->renovarEIniciar($usuarioId, $tentativa['tema']);
                        $_SESSION['quiz_id'] = $nova['id'];
                    } elseif ($acao === 'novo' && !$tentativa['concluida']) {
                        throw new DomainException('Finalize a rodada ou use a opção de encerrar o quiz.');
                    } else {
                        if ($acao === 'abandonar') $rodadas->abandonar($usuarioId, $tentativa['id']);
                        unset($_SESSION['quiz_id']);
                    }
                } else {
                    throw new DomainException('Ação inválida. Utilize as opções do quiz.');
                }
            } catch (DomainException $exception) {
                $_SESSION['quiz_erro'] = $exception->getMessage();
            } catch (Throwable $exception) {
                $_SESSION['quiz_erro'] = 'Não foi possível confirmar a operação. Atualize a página antes de tentar novamente.';
                error_log('AEED: falha ao salvar a rodada ou sua recompensa.');
            }
            // POST/Redirect/GET evita reenviar uma resposta ao atualizar a página.
            header('Location: index.php?pagina=quiz', true, 303);
            exit;
        }

        $temas = $quiz->listarTemas();
        $csrf = $_SESSION['quiz_csrf'];
        $saldoMoedas = $_SESSION['usuario']['moedas'];
        $resultado = $tentativa ? $quiz->obterResultado($tentativa) : null;
        $perguntaId = $tentativa && !$tentativa['concluida'] ? $tentativa['perguntas'][$tentativa['indice']] : null;
        $pergunta = $perguntaId ? $quiz->obterPergunta($perguntaId) : null;
        $dicaTexto = $dicaComprada ? DicasQuiz::obter($perguntaId) : null;
        $respondida = $perguntaId && array_key_exists($perguntaId, $tentativa['respostas']);
        $ajudaAtual = $perguntaId ? ($tentativa['ajudas'][$perguntaId] ?? []) : [];
        $itensCatalogo = CatalogoAvatar::itens();
        $habilidadesCatalogo = CatalogoAvatar::habilidades();

        $titulo = 'Quiz de Estruturas de Dados';
        $bodyClass = 'pagina-quiz';
        $mainClass = 'container conteudo-quiz';
        $cssPagina = ['View/Assets/css/quiz.css'];
        require __DIR__ . '/../View/Quiz/index.php';
    }
}
