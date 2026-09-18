<?php
require_once __DIR__ . '/../Model/Usuarios/RecuperacaoSenha.php';

class RecuperarSenhaController
{
    private static function iniciarSessao()
    {
        if (session_status() === PHP_SESSION_NONE) {
            $caminho = __DIR__ . '/../storage/sessions';
            if (!is_dir($caminho)) mkdir($caminho, 0777, true);
            session_save_path($caminho);
            ini_set('session.cookie_httponly', '1');
            ini_set('session.cookie_samesite', 'Lax');
            session_start();
        }
        header('Cache-Control: no-store');
        header('Referrer-Policy: no-referrer');
        if (empty($_SESSION['recuperacao_csrf'])) {
            $_SESSION['recuperacao_csrf'] = bin2hex(random_bytes(32));
        }
    }

    private static function csrfValido()
    {
        $token = $_POST['csrf'] ?? '';
        return is_string($token) && hash_equals($_SESSION['recuperacao_csrf'], $token);
    }

    private static function redirecionar($pagina)
    {
        header('Location: index.php?pagina=' . $pagina, true, 303);
        exit;
    }

    public function esqueciSenha()
    {
        self::iniciarSessao();
        $servico = new RecuperacaoSenha();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
            $erro = '';
            $sucesso = '';
            if (!self::csrfValido()) {
                $erro = 'O formulário expirou. Tente novamente.';
            } elseif (strlen($email) > 150 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro = 'Informe um e-mail válido.';
            } else {
                try {
                    $servico->solicitar($email, $_SERVER['REMOTE_ADDR'] ?? 'desconhecido');
                    $sucesso = 'Se o e-mail estiver cadastrado e o limite de solicitações não tiver sido atingido, você receberá um link de recuperação. Confira também a pasta de spam.';
                } catch (Throwable $exception) {
                    error_log('AEED: recuperacao indisponivel; confira SMTP, dependencias e migracao do banco.');
                    $erro = 'A recuperação por e-mail está temporariamente indisponível. Tente novamente mais tarde ou avise o responsável pelo site.';
                }
            }
            $_SESSION['recuperacao_aviso'] = compact('erro', 'sucesso', 'email');
            self::redirecionar('esqueciSenha');
        }
        $aviso = $_SESSION['recuperacao_aviso'] ?? [];
        unset($_SESSION['recuperacao_aviso']);
        $erro = $aviso['erro'] ?? '';
        $sucesso = $aviso['sucesso'] ?? '';
        $email = $aviso['email'] ?? '';
        $csrf = $_SESSION['recuperacao_csrf'];
        require __DIR__ . '/../View/RecuperarSenha/esqueci.php';
    }

    public function redefinirSenha()
    {
        self::iniciarSessao();
        $servico = new RecuperacaoSenha();
        $invalido = 'Este link é inválido, já foi utilizado ou expirou. Solicite um novo.';

        // Retira a credencial da URL antes de carregar a tela e seus recursos externos.
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && array_key_exists('token', $_GET)) {
            unset($_SESSION['recuperacao_token'], $_SESSION['redefinicao_aviso']);
            try {
                if ($servico->tokenValido($_GET['token'])) {
                    $_SESSION['recuperacao_token'] = $_GET['token'];
                    $_SESSION['recuperacao_csrf'] = bin2hex(random_bytes(32));
                } else {
                    $_SESSION['redefinicao_aviso'] = ['erro' => $invalido];
                }
            } catch (Throwable $exception) {
                $_SESSION['redefinicao_aviso'] = ['erro' => 'Não foi possível verificar o link agora. Tente abrir o e-mail novamente mais tarde.'];
            }
            self::redirecionar('redefinirSenha');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $erro = '';
            $sucesso = '';
            try {
                if (!self::csrfValido()) {
                    $erro = 'O formulário expirou. Tente novamente.';
                } elseif ($servico->redefinir($_SESSION['recuperacao_token'] ?? '', $_POST['nova_senha'] ?? '', $_POST['confirmar_senha'] ?? '')) {
                    $sucesso = 'Senha redefinida com sucesso! Faça login com sua nova senha.';
                    unset($_SESSION['recuperacao_token']);
                    $_SESSION['recuperacao_csrf'] = bin2hex(random_bytes(32));
                } else {
                    $erro = $invalido;
                    unset($_SESSION['recuperacao_token']);
                }
            } catch (DomainException $exception) {
                $erro = $exception->getMessage();
            } catch (Throwable $exception) {
                $erro = 'Não foi possível redefinir sua senha agora. Tente novamente mais tarde.';
            }
            $_SESSION['redefinicao_aviso'] = compact('erro', 'sucesso');
            self::redirecionar('redefinirSenha');
        }

        $aviso = $_SESSION['redefinicao_aviso'] ?? [];
        unset($_SESSION['redefinicao_aviso']);
        $erro = $aviso['erro'] ?? '';
        $sucesso = $aviso['sucesso'] ?? '';
        $tokenValido = false;
        try {
            $tokenValido = (bool) $servico->tokenValido($_SESSION['recuperacao_token'] ?? '');
            if (!$tokenValido && $erro === '' && $sucesso === '') $erro = $invalido;
        } catch (Throwable $exception) {
            $erro = 'Não foi possível verificar o link agora. Tente novamente mais tarde.';
        }
        $csrf = $_SESSION['recuperacao_csrf'];
        require __DIR__ . '/../View/RecuperarSenha/redefinir.php';
    }
}
