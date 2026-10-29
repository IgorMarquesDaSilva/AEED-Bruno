<?php require_once "View/Shared/header.php"; ?>

        <section class="aula-hero">
            <div>
                <span class="rotulo">Menores à esquerda, maiores à direita</span>
                <h1><?php echo htmlspecialchars($conteudo["titulo"]); ?></h1>
                <p class="introducao">
                    <?php echo htmlspecialchars($conteudo["introducao"]); ?>
                </p>
            </div>

            <div class="aula-resumo">
                <strong>Árvore Binária</strong>
                <span>No máximo dois filhos por nó</span>
                <a href="#codigo">Ver exemplos em C#</a>
            </div>
        </section>

        <div class="aula-layout">
            <nav class="indice">
            <h2>Nesta aula</h2>

            <a href="#objetivos">Objetivos</a>
            <a href="#conceito">Conceito</a>
            <a href="#anatomia">Nó, raiz e sub-árvores</a>
            <a href="#operacoes">Operações principais</a>
            <a href="#insercoes">Inserção</a>
            <a href="#remocoes">Remoção</a>
            <a href="#percurso">Busca e percurso</a>
            <a href="#comparacao">Comparação</a>
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
            <h2>O que é uma Árvore Binária?</h2>

            <p><?php echo htmlspecialchars($conteudo["definicao"]); ?></p>

            <div class="bloco-contexto">
                <h3>Do cotidiano para a Estrutura de Dados</h3>

                <?php foreach ($conteudo["contexto"] as $paragrafo) { ?>
                    <p><?php echo htmlspecialchars($paragrafo); ?></p>
                <?php } ?>
            </div>

            <figure class="arvore-diagrama">
                <?php echo $conteudo["representacao"]; ?>
                <figcaption><?php echo htmlspecialchars($conteudo["legendaRepresentacao"]); ?></figcaption>
            </figure>

            <h3>Como funciona</h3>

            <ul class="lista-topicos">
                <?php foreach ($conteudo["comoFunciona"] as $explicacao) { ?>
                    <li><?php echo htmlspecialchars($explicacao); ?></li>
                <?php } ?>
            </ul>

            <h3>Por que ela é importante?</h3>
            <p><?php echo htmlspecialchars($conteudo["importancia"]); ?></p>

            <div class="bloco-contexto">
                <h3>Árvore não balanceada</h3>
                <p><?php echo htmlspecialchars($conteudo["naoBalanceada"]); ?></p>
            </div>

            <h3>Aplicações práticas</h3>

            <ul class="lista-topicos">
                <?php foreach ($conteudo["aplicacoes"] as $aplicacao) { ?>
                    <li><?php echo htmlspecialchars($aplicacao); ?></li>
                <?php } ?>
            </ul>
        </section>

        <section id="anatomia" class="secao">
            <h2>Nó, raiz e sub-árvores</h2>
            <p>
                Uma árvore binária é formada por nós ligados em hierarquia. Cada nó
                guarda um valor e dois ponteiros, um para a sub-árvore da
                esquerda e outro para a da direita; quando não há filho, o
                ponteiro é nulo.
            </p>

            <div class="grade-anatomia">
                <?php foreach ($conteudo["anatomia"] as $item) { ?>
                    <article class="anatomia">
                        <h3><?php echo htmlspecialchars($item["termo"]); ?></h3>
                        <p><?php echo htmlspecialchars($item["explicacao"]); ?></p>
                    </article>
                <?php } ?>
            </div>
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

            <p class="nota-complexidade"><?php echo htmlspecialchars($conteudo["complexidadeNota"]); ?></p>
        </section>

        <section id="insercoes" class="secao">
            <h2>Inserção passo a passo</h2>
            <p>
                Inserir um valor significa descer pela árvore comparando-o com cada
                nó (menor à esquerda, maior à direita) até encontrar um lugar
                vazio, onde o novo nó é ligado como folha.
            </p>

            <div class="etapas">
                <?php foreach ($conteudo["insercoes"] as $insercao) { ?>
                    <article class="etapa">
                        <div class="operacao-topo">
                            <h3><?php echo htmlspecialchars($insercao["titulo"]); ?></h3>
                            <span><?php echo htmlspecialchars($insercao["complexidade"]); ?></span>
                        </div>

                        <ol class="lista-passos">
                            <?php foreach ($insercao["passos"] as $passo) { ?>
                                <li><?php echo htmlspecialchars($passo); ?></li>
                            <?php } ?>
                        </ol>
                    </article>
                <?php } ?>
            </div>
        </section>

        <section id="remocoes" class="secao">
            <h2>Remoção passo a passo</h2>
            <p>
                A remoção depende de quantos filhos o nó possui. É preciso manter a
                regra de ordenação: menores à esquerda e maiores à direita.
            </p>

            <div class="etapas">
                <?php foreach ($conteudo["remocoes"] as $remocao) { ?>
                    <article class="etapa">
                        <h3><?php echo htmlspecialchars($remocao["titulo"]); ?></h3>

                        <ol class="lista-passos">
                            <?php foreach ($remocao["passos"] as $passo) { ?>
                                <li><?php echo htmlspecialchars($passo); ?></li>
                            <?php } ?>
                        </ol>
                    </article>
                <?php } ?>
            </div>
        </section>

        <section id="percurso" class="secao">
            <h2>Busca e percurso</h2>

            <div class="grade-operacoes">
                <?php foreach ($conteudo["buscaPercurso"] as $operacao) { ?>
                    <article class="operacao">
                        <div class="operacao-topo">
                            <h3><?php echo htmlspecialchars($operacao["titulo"]); ?></h3>
                            <span><?php echo htmlspecialchars($operacao["complexidade"]); ?></span>
                        </div>

                        <p><?php echo htmlspecialchars($operacao["descricao"]); ?></p>
                    </article>
                <?php } ?>
            </div>
        </section>

        <section id="comparacao" class="secao">
            <h2>Árvore genérica x Árvore binária</h2>

            <div class="tabela-container">
                <table>
                    <thead>
                        <tr>
                            <th>Critério</th>
                            <th>Árvore genérica</th>
                            <th>Árvore binária</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($conteudo["comparacao"] as $linha) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha["criterio"]); ?></td>
                                <td><?php echo htmlspecialchars($linha["simples"]); ?></td>
                                <td><?php echo htmlspecialchars($linha["dupla"]); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
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
            </div>

<?php require_once "View/Shared/footer.php"; ?>