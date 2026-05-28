<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($conteudo["titulo"]); ?></title>

    <link rel="stylesheet" href="View/Assets/css/style.css">
    <link rel="stylesheet" href="View/Assets/css/Tad.css">
</head>
<body class="pagina-tad">
    <header class="cabecalho-aula">
        <div class="cabecalho-conteudo">
            <a class="voltar" href="index.php">Voltar para o início</a>

            <p class="rotulo">Estruturas de Dados</p>
            <h1><?php echo htmlspecialchars($conteudo["titulo"]); ?></h1>
            <p class="introducao">
                <?php echo htmlspecialchars($conteudo["introducao"]); ?>
            </p>
        </div>
    </header>

    <main class="conteudo-tad">
        <nav class="indice">
            <h2>Nesta aula</h2>

            <a href="#objetivos">Objetivos</a>
            <a href="#conceito">Conceito</a>
            <a href="#componentes">Dados e operações</a>
            <a href="#funcionamento">Como funciona</a>
            <a href="#operacoes">Operações principais</a>
            <a href="#etapas">Criação de um TAD</a>
            <a href="#memoria">Struct, Stack e Heap</a>
            <a href="#comparacao">TAD x Struct</a>
            <a href="#videoaula">Videoaula</a>
            <a href="#codigo">Exemplos em C#</a>
            <a href="#exercicios">Exercícios</a>
        </nav>

        <section id="objetivos" class="secao">
            <h2>Objetivos da aula</h2>

            <ul class="lista-topicos">
                <?php foreach ($conteudo["objetivos"] as $objetivo) { ?>
                    <li><?php echo htmlspecialchars($objetivo); ?></li>
                <?php } ?>
            </ul>
        </section>

        <section id="conceito" class="secao">
            <h2>O que é um TAD?</h2>

            <p><?php echo htmlspecialchars($conteudo["definicao"]); ?></p>

            <div class="bloco-contexto">
                <h3>Ideia principal</h3>

                <?php foreach ($conteudo["contexto"] as $paragrafo) { ?>
                    <p><?php echo htmlspecialchars($paragrafo); ?></p>
                <?php } ?>
            </div>

            <div class="representacao">
                <?php echo htmlspecialchars($conteudo["representacao"]); ?>
            </div>

            <h3>Por que ele é importante?</h3>
            <p><?php echo htmlspecialchars($conteudo["importancia"]); ?></p>

            <h3>Aplicações práticas</h3>

            <ul class="lista-topicos">
                <?php foreach ($conteudo["aplicacoes"] as $aplicacao) { ?>
                    <li><?php echo htmlspecialchars($aplicacao); ?></li>
                <?php } ?>
            </ul>
        </section>

        <section id="componentes" class="secao">
            <h2>Dados e operações</h2>
            <p>
                Um TAD une as informações armazenadas com as ações que podem ser realizadas sobre elas.
            </p>

            <div class="grade-anatomia">
                <?php foreach ($conteudo["componentes"] as $item) { ?>
                    <article class="anatomia">
                        <h3><?php echo htmlspecialchars($item["termo"]); ?></h3>
                        <p><?php echo htmlspecialchars($item["explicacao"]); ?></p>
                    </article>
                <?php } ?>
            </div>
        </section>

        <section id="funcionamento" class="secao">
            <h2>Como funciona</h2>

            <ul class="lista-topicos">
                <?php foreach ($conteudo["comoFunciona"] as $explicacao) { ?>
                    <li><?php echo htmlspecialchars($explicacao); ?></li>
                <?php } ?>
            </ul>
        </section>

        <section id="operacoes" class="secao">
            <h2>Operações principais</h2>

            <div class="grade-operacoes">
                <?php foreach ($conteudo["operacoes"] as $operacao) { ?>
                    <article class="operacao">
                        <div class="operacao-topo">
                            <h3><?php echo htmlspecialchars($operacao["nome"]); ?></h3>
                            <span><?php echo htmlspecialchars($operacao["complexidade"]); ?></span>
                        </div>

                        <p><?php echo htmlspecialchars($operacao["descricao"]); ?></p>
                    </article>
                <?php } ?>
            </div>
        </section>

        <section id="etapas" class="secao">
            <h2>Criação de um TAD passo a passo</h2>
            <p>
                Para criar um TAD, pense primeiro na entidade representada, depois nos dados e nas operações.
            </p>

            <div class="etapas">
                <?php foreach ($conteudo["etapas"] as $etapa) { ?>
                    <article class="etapa">
                        <h3><?php echo htmlspecialchars($etapa["titulo"]); ?></h3>

                        <ol class="lista-passos">
                            <?php foreach ($etapa["passos"] as $passo) { ?>
                                <li><?php echo htmlspecialchars($passo); ?></li>
                            <?php } ?>
                        </ol>
                    </article>
                <?php } ?>
            </div>
        </section>

        <section id="memoria" class="secao">
            <h2>Struct, Stack e Heap</h2>

            <div class="grade-operacoes">
                <?php foreach ($conteudo["memoria"] as $item) { ?>
                    <article class="operacao">
                        <h3><?php echo htmlspecialchars($item["titulo"]); ?></h3>
                        <p><?php echo htmlspecialchars($item["descricao"]); ?></p>
                    </article>
                <?php } ?>
            </div>
        </section>

        <section id="comparacao" class="secao">
            <h2>TAD x Struct</h2>

            <div class="tabela-container">
                <table>
                    <thead>
                        <tr>
                            <th>Critério</th>
                            <th>TAD</th>
                            <th>Struct em C#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($conteudo["comparacao"] as $linha) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha["criterio"]); ?></td>
                                <td><?php echo htmlspecialchars($linha["tad"]); ?></td>
                                <td><?php echo htmlspecialchars($linha["struct"]); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="videoaula" class="secao">
            <h2>Videoaula complementar</h2>

            <?php foreach ($conteudo["videos"] as $video) { ?>
                <article class="video">
                    <h3><?php echo htmlspecialchars($video["titulo"]); ?></h3>
                    <p><?php echo htmlspecialchars($video["descricao"]); ?></p>

                    <div class="video-container">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/zqIadL5EjuE?si=xwsV2xct-67RooWU"
                         title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write;
                          encrypted-media; gyroscope; picture-in-picture; web-share"
                           referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>

                    <p class="fonte-video">
                        <?php echo htmlspecialchars($video["fonte"]); ?>
                        <a href="<?php echo htmlspecialchars($video["link"]); ?>" target="_blank" rel="noopener noreferrer">
                            Abrir no YouTube
                        </a>
                    </p>
                </article>
            <?php } ?>
        </section>

        <section id="codigo" class="secao">
            <h2>Exemplos em C#</h2>

            <p class="nota-codigo"><?php echo htmlspecialchars($conteudo["orientacaoCodigo"]); ?></p>

            <?php foreach ($conteudo["exemplos"] as $exemplo) { ?>
                <article class="exemplo-codigo">
                    <h3><?php echo htmlspecialchars($exemplo["titulo"]); ?></h3>
                    <p><?php echo htmlspecialchars($exemplo["descricao"]); ?></p>

                    <pre><code><?php echo htmlspecialchars($exemplo["codigo"]); ?></code></pre>
                </article>
            <?php } ?>
        </section>

        <section id="exercicios" class="secao">
            <h2>Pratique o que aprendeu</h2>

            <ol class="lista-exercicios">
                <?php foreach ($conteudo["exercicios"] as $exercicio) { ?>
                    <li><?php echo htmlspecialchars($exercicio); ?></li>
                <?php } ?>
            </ol>
        </section>
    </main>

    <footer class="rodape-aula">
        <p>Ambiente de Ensino de Estruturas de Dados</p>
    </footer>
</body>
</html>
