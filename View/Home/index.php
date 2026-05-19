<?php require __DIR__ . '/../Shared/header.php'; ?>

<section class="intro">
    <h2><?php echo htmlspecialchars($titulo); ?></h2>
    <p><?php echo htmlspecialchars($descricao); ?></p>
</section>

<section class="secao">
    <h2>Primeiros conteudos</h2>

    <div class="cards">
        <?php foreach ($estruturas as $estrutura): ?>
            <article class="card">
                <h3><?php echo htmlspecialchars($estrutura['nome']); ?></h3>
                <p><?php echo htmlspecialchars($estrutura['descricao']); ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php require __DIR__ . '/../Shared/footer.php'; ?>
