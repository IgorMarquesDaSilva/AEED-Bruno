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

        <span class="hero-card-label">Neste ambiente</span>

        <h3>Aprenda com exemplos em C#</h3>

        <p>Conceitos diretos, código comentado e exercícios.</p>

        <div class="hero-card-items">
            <div class="hero-card-item">
                <span class="hero-card-item-dot"></span>
                Tipo Abstrato de Dados
            </div>
            <div class="hero-card-item">
                <span class="hero-card-item-dot"></span>
                Listas encadeadas simples
            </div>
            <div class="hero-card-item">
                <span class="hero-card-item-dot"></span>
                Listas duplamente encadeadas
            </div>
        </div>

    </div>

</section>

<nav class="atalhos">
    <a href="#conteudos">Conteúdos</a>
    <a href="#resumo">Mapa</a>
    <a href="index.php?pagina=tad">TAD</a>
</nav>

<section id="conteudos">

    <p class="secao-titulo">Módulos disponíveis</p>

    <div class="cards-conteudos">

        <a class="card-conteudo destaque" href="index.php?pagina=tad">

            <div class="card-icone">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="3"/>
                    <path d="M3 9h18M9 21V9"/>
                </svg>
            </div>

            <small>Conceito base</small>
            <h3>TAD</h3>
            <p>Definição formal de dados e operações em uma estrutura abstrata.</p>
            <span class="card-link">
                Estudar agora
                <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>

        </a>

        <a class="card-conteudo" href="index.php?pagina=lisimples">

            <div class="card-icone">
                <svg viewBox="0 0 24 24">
                    <circle cx="5" cy="12" r="2"/>
                    <circle cx="12" cy="12" r="2"/>
                    <circle cx="19" cy="12" r="2"/>
                    <path d="M7 12h3M14 12h3"/>
                </svg>
            </div>

            <small>Estrutura linear</small>
            <h3>Lista Simples</h3>
            <p>Nós conectados em uma única direção, com ponteiro para o próximo.</p>
            <span class="card-link">
                Acessar
                <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>

        </a>

        <a class="card-conteudo" href="index.php?pagina=lisdupla">

            <div class="card-icone">
                <svg viewBox="0 0 24 24">
                    <circle cx="5" cy="12" r="2"/>
                    <circle cx="12" cy="12" r="2"/>
                    <circle cx="19" cy="12" r="2"/>
                    <path d="M7 12h3M14 12h3"/>
                    <path d="M7 9l-2 3 2 3M17 9l2 3-2 3" stroke-width="1.5"/>
                </svg>
            </div>

            <small>Navegação dupla</small>
            <h3>Lista Dupla</h3>
            <p>Cada nó mantém referência ao anterior e ao próximo elemento.</p>
            <span class="card-link">
                Acessar
                <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>

        </a>

    </div>

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