<?php
require_once __DIR__ . '/LoginController.php';
require_once __DIR__ . '/../Model/Avatar/AvatarLoja.php';
require_once __DIR__ . '/../View/Avatar/desenho.php';

class LojaController
{
    public function index()
    {
        LoginController::verificarLogin();
        header('Cache-Control: no-store');
        $usuarioId = (int) $_SESSION['usuario']['id'];
        $categorias = CatalogoAvatar::categorias();
        $catalogo = CatalogoAvatar::itens();
        $vista = ($_GET['vista'] ?? '') === 'armario' ? 'armario' : 'loja';
        $categoria = $_GET['categoria'] ?? 'todos';
        if (!is_string($categoria) || ($categoria !== 'todos' && !isset($categorias[$categoria]))) $categoria = 'todos';
        if (empty($_SESSION['loja_csrf'])) $_SESSION['loja_csrf'] = bin2hex(random_bytes(32));
        $csrf = $_SESSION['loja_csrf'];
        $loja = new AvatarLoja();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (!is_string($_POST['csrf'] ?? null) || !hash_equals($csrf, $_POST['csrf'])) {
                    throw new DomainException('O formulário expirou. Atualize a página e tente novamente.');
                }
                $acao = $_POST['acao'] ?? '';
                $itemId = $_POST['item'] ?? null;
                if ($acao === 'comprar') {
                    $_SESSION['usuario']['moedas'] = $loja->comprar($usuarioId, $itemId);
                    $_SESSION['loja_aviso'] = ['sucesso', 'Compra realizada. O item já está equipado no avatar.'];
                } elseif ($acao === 'equipar') {
                    $loja->equipar($usuarioId, $itemId);
                    $_SESSION['loja_aviso'] = ['sucesso', 'Avatar atualizado.'];
                } elseif ($acao === 'remover_acessorio') {
                    $loja->removerAcessorio($usuarioId);
                    $_SESSION['loja_aviso'] = ['sucesso', 'Acessório removido do avatar.'];
                } else {
                    throw new DomainException('Ação inválida.');
                }
            } catch (DomainException $exception) {
                $_SESSION['loja_aviso'] = ['erro', $exception->getMessage()];
            } catch (Throwable $exception) {
                error_log('AEED: falha ao comprar ou equipar item do avatar.');
                $_SESSION['loja_aviso'] = ['erro', 'Não foi possível concluir a operação agora. Tente novamente.'];
            }
            header('Location: index.php?pagina=loja&' . http_build_query(['vista' => $vista, 'categoria' => $categoria]), true, 303);
            exit;
        }

        $aviso = $_SESSION['loja_aviso'] ?? null;
        unset($_SESSION['loja_aviso']);
        $inventario = [];
        $equipado = CatalogoAvatar::iniciais();
        $erroLoja = '';
        try {
            $inventario = $loja->inventario($usuarioId);
            $equipado = $loja->equipado($usuarioId);
        } catch (Throwable $exception) {
            http_response_code(503);
            $erroLoja = 'A loja está indisponível. Confira a migração do avatar e tente novamente.';
            error_log('AEED: falha ao carregar avatar e inventario.');
        }
        $saldo = (int) $_SESSION['usuario']['moedas'];
        $itensVisiveis = [];
        foreach ($catalogo as $id => $item) {
            if ($categoria !== 'todos' && $item['categoria'] !== $categoria) continue;
            if ($vista === 'armario' && $item['preco'] > 0 && !isset($inventario[$id])) continue;
            $itensVisiveis[$id] = $item;
        }
        $titulo = $vista === 'armario' ? 'Meu armário' : 'Loja do avatar';
        $bodyClass = 'pagina-loja';
        $mainClass = 'container conteudo-loja';
        $cssPagina = ['View/Assets/css/loja.css'];
        require __DIR__ . '/../View/Loja/index.php';
    }
}
