<?php require_once "View/Shared/header.php"; ?>

<section class="home-hero">
    <div>
        <span class="home-tag">Estruturas de Dados</span>
        <h1><?php echo htmlspecialchars($titulo); ?></h1>
        <p><?php echo htmlspecialchars($descricao); ?></p>

        <div class="hero-acoes">
            <a class="botao-principal" href="#conteudos">Começar estudo</a>
            <a class="botao-secundario" href="index.php?pagina=tad">Ver TAD</a>
        </div>
    </div>

    <div class="hero-card">
        <span>📘</span>
        <h3>Aprenda com exemplos em C#</h3>
        <p>Conceitos diretos, códigos e exercícios.</p>
    </div>
</section>

<section class="atalhos">
    <a href="#conteudos">Conteúdos</a>
    <a href="#resumo">Resumo</a>
    <a href="index.php?pagina=tad">TAD</a>
</section>

<section id="conteudos" class="cards-conteudos">
    <a class="card-conteudo destaque" href="index.php?pagina=tad">
        <span class="icone">📦</span>
        <small>Conceito base</small>
        <h3>TAD</h3>
        <p>Dados + operações em uma estrutura.</p>
        <strong>Estudar agora →</strong>
    </a>

    <a class="card-conteudo" href="index.php?pagina=lisimples">
        <span class="icone">🔗</span>
        <small>Estrutura linear</small>
        <h3>Lista Simples</h3>
        <p>Nós conectados em uma direção.</p>
        <strong>Acessar →</strong>
    </a>

    <a class="card-conteudo" href="index.php?pagina=lisdupla">
        <span class="icone">↔️</span>
        <small>Navegação dupla</small>
        <h3>Lista Dupla</h3>
        <p>Anterior e próximo em cada nó.</p>
        <strong>Acessar →</strong>
    </a>
</section>

<section id="resumo" class="painel-resumo">
    <div>
        <span class="home-tag escura">Mapa do conteúdo</span>
        <h2>O que você vai estudar</h2>
    </div>

    <ul class="lista-estruturas">
        <?php foreach ($estruturas as $estrutura) { ?>
            <li><?php echo htmlspecialchars($estrutura); ?></li>
        <?php } ?>
    </ul>
</section>

<?php require_once "View/Shared/footer.php"; ?>