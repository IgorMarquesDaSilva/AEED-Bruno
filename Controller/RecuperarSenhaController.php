<?php
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';

class RecuperarSenhaController
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

    public function esqueciSenha()
    {
        self::iniciarSessao();

        if (isset($_SESSION['usuario'])) {
            header('Location: index.php');
            exit;
        }

        $erro = '';
        $sucesso = '';
        $linkTeste = '';
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim(isset($_POST['email']) ? $_POST['email'] : '');

            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro = 'Informe um e-mail valido.';
            } else {
                try {
                    $usuarioModel = new Usuario();

                    $token = bin2hex(random_bytes(32));
                    $expira = date('Y-m-d H:i:s', time() + (60 * 60));

                    $salvou = $usuarioModel->salvarTokenReset($email, $token, $expira);

                    // NAO revelamos se o e-mail existe ou nao, por seguranca.
                    $sucesso = 'Se o e-mail informado estiver cadastrado, voce recebera as instrucoes de redefinicao de senha em instantes.';

                    if ($salvou) {
                        // Este projeto academico nao possui servidor de e-mail configurado.
                        // Em producao, o link abaixo seria enviado por e-mail (ex.: via PHPMailer/SMTP)
                        // em vez de ser exibido na propria tela.
                        $linkTeste = 'index.php?pagina=redefinirSenha&token=' . $token;
                    }
                } catch (Exception $exception) {
                    $erro = 'Nao foi possivel conectar ao banco. Importe o arquivo database/aeed_bruno.sql no MySQL.';
                }
            }
        }

        require __DIR__ . '/../View/RecuperarSenha/esqueci.php';
    }

    public function redefinirSenha()
    {
        self::iniciarSessao();

        if (isset($_SESSION['usuario'])) {
            header('Location: index.php');
            exit;
        }

        $erro = '';
        $sucesso = '';
        $tokenValido = false;
        $token = isset($_GET['token']) ? $_GET['token'] : (isset($_POST['token']) ? $_POST['token'] : '');

        if ($token === '') {
            $erro = 'Link de redefinicao invalido.';
        } else {
            try {
                $usuarioModel = new Usuario();
                $usuario = $usuarioModel->buscarPorTokenReset($token);

                if (!$usuario) {
                    $erro = 'Este link de redefinicao e invalido ou ja expirou. Solicite um novo.';
                } else {
                    $tokenValido = true;

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $novaSenha = isset($_POST['nova_senha']) ? $_POST['nova_senha'] : '';
                        $confirmarSenha = isset($_POST['confirmar_senha']) ? $_POST['confirmar_senha'] : '';

                        if (strlen($novaSenha) < 6) {
                            $erro = 'A nova senha deve ter no minimo 6 caracteres.';
                        } elseif ($novaSenha !== $confirmarSenha) {
                            $erro = 'As senhas nao coincidem.';
                        } else {
                            $usuarioModel->redefinirSenhaPorToken($usuario['id'], $novaSenha);
                            $sucesso = 'Senha redefinida com sucesso! Faca login com sua nova senha.';
                            $tokenValido = false;
                        }
                    }
                }
            } catch (Exception $exception) {
                $erro = 'Nao foi possivel conectar ao banco. Importe o arquivo database/aeed_bruno.sql no MySQL.';
            }
        }

        require __DIR__ . '/../View/RecuperarSenha/redefinir.php';
    }
}

?>