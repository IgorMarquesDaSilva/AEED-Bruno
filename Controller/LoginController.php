<?php
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';

class LoginController
{
    private const COOKIE_LEMBRAR = 'aeed_login';

    private static function iniciarSessao()
    {
        if (session_status() === PHP_SESSION_NONE) {
            $caminhoSessao = __DIR__ . '/../storage/sessions';

            if (!is_dir($caminhoSessao)) {
                mkdir($caminhoSessao, 0777, true);
            }

            if (is_dir($caminhoSessao) && is_writable($caminhoSessao)) {
                session_save_path($caminhoSessao);
            }

            ini_set('session.cookie_httponly', '1');
            session_start();
        }
    }

    private static function salvarUsuarioNaSessao($usuario)
    {
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email']
        ];
    }

    private static function opcoesCookie($expira)
    {
        return [
            'expires' => $expira,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax'
        ];
    }

    private static function criarCookieLogin($usuarioId)
    {
        $token = bin2hex(random_bytes(32));
        $expira = time() + (60 * 60 * 24 * 7);
        $expiraBanco = date('Y-m-d H:i:s', $expira);

        $usuarioModel = new Usuario();
        $usuarioModel->salvarTokenLogin($usuarioId, $token, $expiraBanco);

        setcookie(
            self::COOKIE_LEMBRAR,
            $usuarioId . ':' . $token,
            self::opcoesCookie($expira)
        );
    }

    private static function limparCookieLogin()
    {
        setcookie(self::COOKIE_LEMBRAR, '', self::opcoesCookie(time() - 3600));
    }

    private static function recuperarLoginPorCookie()
    {
        if (isset($_SESSION['usuario']) || empty($_COOKIE[self::COOKIE_LEMBRAR])) {
            return;
        }

        $partes = explode(':', $_COOKIE[self::COOKIE_LEMBRAR], 2);

        if (count($partes) !== 2 || !ctype_digit($partes[0])) {
            self::limparCookieLogin();
            return;
        }

        try {
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorTokenLogin((int) $partes[0], $partes[1]);

            if ($usuario) {
                self::salvarUsuarioNaSessao($usuario);
                self::criarCookieLogin($usuario['id']);
                return;
            }
        } catch (Exception $exception) {
            return;
        }

        self::limparCookieLogin();
    }

    public static function verificarLogin()
    {
        self::iniciarSessao();
        self::recuperarLoginPorCookie();

        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?pagina=login');
            exit;
        }
    }

    public function login()
    {
        self::iniciarSessao();

        if (isset($_SESSION['usuario'])) {
            header('Location: index.php');
            exit;
        }

        $erro = '';
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
           $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

            if ($email === '' || $senha === '') {
                $erro = 'Informe o e-mail e a senha.';
            } else {
                try {
                    $usuarioModel = new Usuario();
                    $usuario = $usuarioModel->buscarPorEmail($email);

                    if ($usuario && password_verify($senha, $usuario['senha'])) {
                        self::salvarUsuarioNaSessao($usuario);
                        self::criarCookieLogin($usuario['id']);

                        header('Location: index.php');
                        exit;
                    }

                    $erro = 'E-mail ou senha incorretos.';
                } catch (Exception $exception) {
                    $erro = 'Nao foi possivel conectar ao banco. Importe o arquivo database/aeed_bruno.sql no MySQL.';
                }
            }
        }

        require __DIR__ . '/../View/Login/index.php';
    }

    public function logout()
    {
        self::iniciarSessao();

        if (isset($_SESSION['usuario']['id'])) {
            try {
                $usuarioModel = new Usuario();
                $usuarioModel->limparTokenLogin($_SESSION['usuario']['id']);
            } catch (Exception $exception) {
            }
        }

        self::limparCookieLogin();

        $_SESSION = [];
        session_destroy();

        header('Location: index.php?pagina=login');
        exit;
    }
}

?>
