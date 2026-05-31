<?php
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';

class LoginController
{
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

    public static function verificarLogin()
    {
        self::iniciarSessao();

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
                        $_SESSION['usuario'] = [
                            'id' => $usuario['id'],
                            'nome' => $usuario['nome'],
                            'email' => $usuario['email']
                        ];

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

        $_SESSION = [];
        session_destroy();

        header('Location: index.php?pagina=login');
        exit;
    }
}

?>
