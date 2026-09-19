<?php
require_once __DIR__ . '/../Model/Usuarios/Usuario.php';
require_once __DIR__ . '/LoginController.php';
require_once __DIR__ . '/../Model/Moedas/Carteira.php';
require_once __DIR__ . '/../Model/Quiz/Quiz.php';
require_once __DIR__ . '/../Model/Avatar/AvatarLoja.php';
require_once __DIR__ . '/../View/Avatar/desenho.php';

class PerfilController
{
    public function perfil()
    {
        LoginController::verificarLogin();

        $usuarioModel = new Usuario();
        $usuarioSessao = $_SESSION['usuario'];

        $erro = '';
        $sucesso = '';

        $nome = $usuarioSessao['nome'];
        $email = $usuarioSessao['email'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim(isset($_POST['nome']) ? $_POST['nome'] : '');
            $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
            $senhaAtual = isset($_POST['senha_atual']) ? $_POST['senha_atual'] : '';
            $novaSenha = isset($_POST['nova_senha']) ? $_POST['nova_senha'] : '';
            $confirmarSenha = isset($_POST['confirmar_senha']) ? $_POST['confirmar_senha'] : '';

            $querTrocarSenha = ($senhaAtual !== '' || $novaSenha !== '' || $confirmarSenha !== '');

            if ($nome === '' || $email === '') {
                $erro = 'Preencha nome e e-mail.';

            } elseif (strlen($nome) > 100) {
                $erro = 'O nome deve ter no maximo 100 caracteres.';

            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro = 'Informe um e-mail valido.';

            } elseif (strlen($email) > 150) {
                $erro = 'O e-mail deve ter no maximo 150 caracteres.';

            } elseif ($usuarioModel->emailExisteParaOutro($email, $usuarioSessao['id'])) {
                $erro = 'Este e-mail ja esta em uso por outro usuario.';

            } elseif ($querTrocarSenha && $senhaAtual === '') {
                $erro = 'Informe a senha atual para definir uma nova senha.';

            } elseif ($querTrocarSenha && strlen($novaSenha) < 6) {
                $erro = 'A nova senha deve ter no minimo 6 caracteres.';

            } elseif ($querTrocarSenha && $novaSenha !== $confirmarSenha) {
                $erro = 'A nova senha e a confirmacao nao coincidem.';

            } else {
                try {
                    if ($querTrocarSenha) {
                        $hashAtual = $usuarioModel->buscarSenhaPorId($usuarioSessao['id']);

                        if (!$hashAtual || !password_verify($senhaAtual, $hashAtual)) {
                            $erro = 'Senha atual incorreta.';
                        }
                    }

                    if ($erro === '') {
                        $usuarioModel->atualizarPerfil($usuarioSessao['id'], $nome, $email);

                        if ($querTrocarSenha) {
                            $usuarioModel->atualizarSenha($usuarioSessao['id'], $novaSenha);
                            $_SESSION['usuario']['sessao_versao'] = (int) ($usuarioSessao['sessao_versao'] ?? 0) + 1;
                        }

                        $_SESSION['usuario']['nome'] = $nome;
                        $_SESSION['usuario']['email'] = $email;

                        $sucesso = $querTrocarSenha
                            ? 'Perfil e senha atualizados com sucesso.'
                            : 'Perfil atualizado com sucesso.';
                    }
                } catch (Exception $exception) {
                    $erro = 'Nao foi possivel conectar ao banco. Importe o arquivo database/aeed_bruno.sql no MySQL.';
                }
            }
        }

        $saldoMoedas = $_SESSION['usuario']['moedas'];
        $avatarEquipado = CatalogoAvatar::iniciais();
        $erroAvatar = '';
        try {
            $avatarEquipado = (new AvatarLoja())->equipado($usuarioSessao['id']);
        } catch (Throwable $exception) {
            $erroAvatar = 'Não foi possível carregar o avatar agora.';
        }
        $historicoMoedas = [];
        $erroMoedas = '';
        $temasQuiz = (new Quiz())->listarTemas();
        try {
            $historicoMoedas = (new Carteira())->historico($usuarioSessao['id']);
            foreach ($historicoMoedas as &$registro) {
                $data = new DateTimeImmutable($registro['concluido_em'], new DateTimeZone('UTC'));
                $registro['data_local'] = $data->setTimezone(new DateTimeZone('America/Sao_Paulo'))->format('d/m/Y H:i');
            }
            unset($registro);
        } catch (Throwable $exception) {
            $erroMoedas = 'Não foi possível carregar o histórico de moedas agora.';
        }

        $titulo = 'Meu Perfil';
        $bodyClass = 'pagina-perfil';
        $mainClass = 'conteudo-perfil';
        $cssPagina = ['View/Assets/css/perfil.css'];

        require __DIR__ . '/../View/Perfil/index.php';
    }
}

?>
