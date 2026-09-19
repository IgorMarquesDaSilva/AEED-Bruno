<?php require __DIR__ . '/../Shared/header.php'; ?>

<header class="loja-cabecalho">
    <div>
        <span class="loja-rotulo">Personalização</span>
        <h1><?php echo htmlspecialchars($titulo); ?></h1>
    </div>
    <a class="loja-saldo" href="index.php?pagina=perfil#moedas"><span>Seu saldo</span><strong><?php echo number_format($saldo, 0, ',', '.'); ?> moedas</strong></a>
</header>

<?php if ($aviso) { ?>
    <p class="loja-aviso loja-aviso-<?php echo htmlspecialchars($aviso[0]); ?>" role="status"><?php echo htmlspecialchars($aviso[1]); ?></p>
<?php } ?>
<?php if ($erroLoja !== '') { ?>
    <p class="loja-aviso loja-aviso-erro" role="alert"><?php echo htmlspecialchars($erroLoja); ?></p>
<?php } else { ?>
    <nav class="loja-abas" aria-label="Loja e armário">
        <a href="index.php?pagina=loja&vista=loja"<?php if ($vista === 'loja') echo ' aria-current="page"'; ?>>Loja</a>
        <a href="index.php?pagina=loja&vista=armario"<?php if ($vista === 'armario') echo ' aria-current="page"'; ?>>Meu armário</a>
    </nav>
    <div class="loja-corpo">
        <aside class="loja-avatar" aria-label="Prévia do avatar">
            <h2>Meu avatar</h2>
            <div class="loja-avatar-palco"><?php echo desenharAvatar($equipado); ?></div>
            <p><?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?></p>
            <?php if (isset($equipado['acessorio'])) { ?>
                <form method="post" action="index.php?pagina=loja&<?php echo htmlspecialchars(http_build_query(['vista' => $vista, 'categoria' => $categoria])); ?>">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                    <input type="hidden" name="acao" value="remover_acessorio">
                    <button class="loja-link" type="submit">Remover acessório</button>
                </form>
            <?php } ?>
        </aside>
        <section class="loja-listagem" aria-label="Itens do avatar">
            <nav class="loja-filtros" aria-label="Categorias">
                <a href="index.php?pagina=loja&<?php echo htmlspecialchars(http_build_query(['vista' => $vista, 'categoria' => 'todos'])); ?>"<?php if ($categoria === 'todos') echo ' aria-current="page"'; ?>>Tudo</a>
                <?php foreach ($categorias as $chave => $nomeCategoria) { ?>
                    <a href="index.php?pagina=loja&<?php echo htmlspecialchars(http_build_query(['vista' => $vista, 'categoria' => $chave])); ?>"<?php if ($categoria === $chave) echo ' aria-current="page"'; ?>><?php echo htmlspecialchars($nomeCategoria); ?></a>
                <?php } ?>
            </nav>
            <?php if (!$itensVisiveis) { ?>
                <p class="loja-vazio">Você ainda não tem itens desta categoria. <a href="index.php?pagina=loja">Ver loja</a></p>
            <?php } else { ?>
                <div class="loja-grade">
                    <?php foreach ($itensVisiveis as $id => $item) {
                        $possui = $item['preco'] === 0 || isset($inventario[$id]);
                        $emUso = ($equipado[$item['categoria']] ?? null) === $id;
                        $preview = $equipado;
                        $preview[$item['categoria']] = $id;
                    ?>
                        <article class="loja-item">
                            <div class="loja-item-imagem"><?php echo desenharAvatar($preview, 'Prévia de ' . $item['nome']); ?></div>
                            <div class="loja-item-conteudo">
                                <span class="loja-item-categoria"><?php echo htmlspecialchars($categorias[$item['categoria']]); ?></span>
                                <h3><?php echo htmlspecialchars($item['nome']); ?></h3>
                                <p><?php echo htmlspecialchars($item['descricao']); ?></p>
                                <div class="loja-item-rodape">
                                    <strong><?php echo $item['preco'] === 0 ? 'Inicial' : number_format($item['preco'], 0, ',', '.') . ' moedas'; ?></strong>
                                    <?php if ($emUso) { ?>
                                        <span class="loja-em-uso">Em uso</span>
                                    <?php } else { ?>
                                        <form method="post" action="index.php?pagina=loja&<?php echo htmlspecialchars(http_build_query(['vista' => $vista, 'categoria' => $categoria])); ?>">
                                            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                                            <input type="hidden" name="item" value="<?php echo htmlspecialchars($id); ?>">
                                            <input type="hidden" name="acao" value="<?php echo $possui ? 'equipar' : 'comprar'; ?>">
                                            <button type="submit"<?php if (!$possui && $saldo < $item['preco']) echo ' disabled'; ?>><?php echo $possui ? 'Equipar' : ($saldo < $item['preco'] ? 'Saldo insuficiente' : 'Comprar'); ?></button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            <?php } ?>
        </section>
    </div>
<?php } ?>

<?php require __DIR__ . '/../Shared/footer.php'; ?>
