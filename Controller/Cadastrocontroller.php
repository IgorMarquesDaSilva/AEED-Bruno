<?php
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';

class CadastroController
{
    public function cadastro()
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

        if (isset($_SESSION['usuario'])) {
            header('Location: index.php');
            exit;
        }

        $erro   = '';
        $sucesso = '';
        $nome   = '';
        $email  = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim(isset($_POST['nome'])      ? $_POST['nome']      : '');
            $email = trim(isset($_POST['email'])     ? $_POST['email']     : '');
            $senha = isset($_POST['senha'])     ? $_POST['senha']     : '';
            $confirmar = isset($_POST['confirmar']) ? $_POST['confirmar'] : '';

            if ($nome === '' || $email === '' || $senha === '' || $confirmar === '') {
                $erro = 'Preencha todos os campos.';

            } elseif (strlen($nome) > 100) {
                $erro = 'O nome deve ter no maximo 100 caracteres.';

            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro = 'Informe um e-mail valido.';

            } elseif (strlen($email) > 150) {
                $erro = 'O e-mail deve ter no maximo 150 caracteres.';

            } elseif (strlen($senha) < 6) {
                $erro = 'A senha deve ter no minimo 6 caracteres.';

            } elseif ($senha !== $confirmar) {
                $erro = 'As senhas nao coincidem.';

            } else {
                try {
                    $usuarioModel = new Usuario();

                    if ($usuarioModel->emailExiste($email)) {
                        $erro = 'Este e-mail ja esta cadastrado.';
                    } else {
                        $usuarioModel->cadastrar($nome, $email, $senha);
                        $sucesso = 'Cadastro realizado com sucesso! Faca o login para entrar.';
                        $nome  = '';
                        $email = '';
                    }
                } catch (Exception $exception) {
                    $erro = 'Nao foi possivel conectar ao banco. Importe o arquivo database/aeed_bruno.sql no MySQL.';
                }
            }
        }

        require __DIR__ . '/../View/Cadastro/index.php';
    }
}

?>