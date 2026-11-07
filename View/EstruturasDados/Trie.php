<?php require_once "View/Shared/header.php"; ?>

        <section class="aula-hero">
            <div>
                <span class="rotulo">Uma letra por nó, um prefixo por caminho</span>
                <h1><?php echo htmlspecialchars($conteudo["titulo"]); ?></h1>
                <p class="introducao">
                    <?php echo htmlspecialchars($conteudo["introducao"]); ?>
                </p>
            </div>

            <div class="aula-resumo">
                <strong>Árvore Trie</strong>
                <span>Busca por palavra e por prefixo em O(m)</span>
                <a href="#codigo">Ver exemplos em C#</a>
            </div>
        </section>

        <div class="aula-layout">
            <nav class="indice">
            <h2>Nesta aula</h2>

            <a href="#objetivos">Objetivos</a>
            <a href="#conceito">Conceito</a>
            <a href="#anatomia">Raiz, nós e fim de palavra</a>
            <a href="#operacoes">Operações principais</a>
            <a href="#insercoes">Inserção</a>
            <a href="#remocoes">Remoção</a>
            <a href="#percurso">Busca e percurso</a>
            <a href="#video">Vídeo de apoio</a>
            <a href="#simulador">Simulador interativo</a>
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
            <h2>O que é uma Trie?</h2>

            <p><?php echo htmlspecialchars($conteudo["definicao"]); ?></p>

            <div class="bloco-contexto">
                <h3>Do cotidiano para a Estrutura de Dados</h3>

                <?php foreach ($conteudo["contexto"] as $paragrafo) { ?>
                    <p><?php echo htmlspecialchars($paragrafo); ?></p>
                <?php } ?>
            </div>

            <figure class="trie-diagrama">
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

            <h3>Aplicações práticas</h3>

            <ul class="lista-topicos">
                <?php foreach ($conteudo["aplicacoes"] as $aplicacao) { ?>
                    <li><?php echo htmlspecialchars($aplicacao); ?></li>
                <?php } ?>
            </ul>
        </section>

        <section id="anatomia" class="secao">
            <h2>Raiz, nós e fim de palavra</h2>
            <p>
                A Trie é formada por nós ligados em hierarquia, como qualquer
                árvore. O que muda é o significado de cada ramo: ele representa
                uma letra, e o caminho percorrido desde a raiz forma o prefixo
                de uma ou mais palavras.
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
                Inserir uma palavra significa percorrer suas letras a partir da
                raiz, reaproveitando os nós que já existem e criando apenas os
                que faltam.
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
                A remoção precisa ter cuidado: apagar nós demais pode destruir
                outras palavras que compartilham o mesmo prefixo.
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

        <section id="video" class="secao">
            <h2>Vídeo de apoio</h2>
            <p><?php echo htmlspecialchars($conteudo["video"]["descricao"]); ?></p>

            <div class="video-aula">
                <div class="video-quadro">
                    <iframe src="https://www.youtube-nocookie.com/embed/<?php echo rawurlencode($conteudo["video"]["id"]); ?>" title="<?php echo htmlspecialchars($conteudo["video"]["titulo"]); ?>" loading="lazy" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <p class="video-canal"><?php echo htmlspecialchars($conteudo["video"]["titulo"]); ?> | <?php echo htmlspecialchars($conteudo["video"]["canal"]); ?>. Se o vídeo não carregar, <a href="https://www.youtube.com/watch?v=<?php echo rawurlencode($conteudo["video"]["id"]); ?>" target="_blank" rel="noopener noreferrer">abra no YouTube</a>.</p>
            </div>
        </section>

        <section id="simulador" class="secao">
            <h2>Simulador interativo</h2>
            <p><?php echo htmlspecialchars($conteudo["simulador"]["introducao"]); ?></p>

            <div class="simulador">
                <div class="sim-controles">
                    <input type="text" id="sim-valor" autocomplete="off" autocapitalize="none" spellcheck="false" placeholder="Palavra (a-z)" aria-label="Palavra">
                    <button type="button" id="sim-inserir" class="sim-principal">Inserir</button>
                    <button type="button" id="sim-buscar">Buscar palavra</button>
                    <button type="button" id="sim-prefixo">Buscar prefixo</button>
                    <button type="button" id="sim-remover">Remover</button>
                    <button type="button" id="sim-listar">Listar palavras</button>
                    <button type="button" id="sim-exemplo">Exemplo da aula</button>
                    <button type="button" id="sim-limpar">Limpar</button>
                    <label class="sim-vel">Velocidade
                        <select id="sim-velocidade">
                            <option value="1300">Lenta</option>
                            <option value="800" selected>Normal</option>
                            <option value="350">Rápida</option>
                        </select>
                    </label>
                    <button type="button" id="sim-pular" hidden>Pular animação</button>
                </div>

                <p id="sim-msg" class="sim-msg" role="status" aria-live="polite">Estrutura vazia. Insira uma palavra para começar.</p>

                <div class="sim-area">
                    <svg id="sim-svg" role="img" aria-label="Trie do simulador" data-exemplo="<?php echo htmlspecialchars(str_replace(' ', '', $conteudo["simulador"]["palavrasExemplo"])); ?>" xmlns="http://www.w3.org/2000/svg"></svg>
                </div>
                <p id="sim-info" class="sim-info"></p>

                <h3>Passo a passo</h3>
                <ol id="sim-passos" class="sim-passos"></ol>
            </div>

            <h3>Para experimentar</h3>
            <ul class="lista-topicos">
                <?php foreach ($conteudo["simulador"]["dicas"] as $dica) { ?>
                    <li><?php echo htmlspecialchars($dica); ?></li>
                <?php } ?>
            </ul>
        </section>

        <section id="comparacao" class="secao">
            <h2>Árvore Binária x Trie</h2>

            <div class="tabela-container">
                <table>
                    <thead>
                        <tr>
                            <th>Critério</th>
                            <th>Árvore Binária</th>
                            <th>Trie</th>
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

<script>
/* Simulador de Trie: inserir, buscar palavra, buscar prefixo, remover e listar.
   Cada nó representa uma letra (a-z); o nó raiz não guarda letra.
   Fim de palavra: contorno verde. Remoção desmarca o fim e descarta nós inúteis. */
(function () {
    'use strict';

    var svg = document.getElementById('sim-svg');
    if (!svg) { return; }

    var NS = 'http://www.w3.org/2000/svg';
    var campo = document.getElementById('sim-valor');
    var lista = document.getElementById('sim-passos');
    var msg = document.getElementById('sim-msg');
    var info = document.getElementById('sim-info');
    var velocidade = document.getElementById('sim-velocidade');
    var botoes = document.querySelectorAll('.sim-controles button');

    var proximoId = 1;
    var raiz = novoNo('');
    var ocupado = false;
    var timer = null;

    function novoNo(c) { return { id: proximoId++, c: c, fim: false, f: {} }; }

    function clonar(n) {
        var o = { id: n.id, c: n.c, fim: n.fim, f: {} };
        Object.keys(n.f).forEach(function (k) { o.f[k] = clonar(n.f[k]); });
        return o;
    }

    function filhos(n) { return Object.keys(n.f).sort(); }

    function criarPassos() {
        var a = [];
        a.push = function (p) {
            p.estado.arv = clonar(raiz);
            return Array.prototype.push.call(a, p);
        };
        return a;
    }

    function contarNos(n) {
        var t = 0;
        filhos(n).forEach(function (k) { t += 1 + contarNos(n.f[k]); });
        return t;
    }

    function coletar(n, prefixo, saida) {
        if (n.fim) { saida.push(prefixo); }
        filhos(n).forEach(function (k) { coletar(n.f[k], prefixo + k, saida); });
        return saida;
    }

    /* ---------- desenho ---------- */
    function el(nome, attrs) {
        var e = document.createElementNS(NS, nome);
        for (var k in attrs) { e.setAttribute(k, attrs[k]); }
        return e;
    }

    var ESP_X = 52, ESP_Y = 66, MARGEM = 36;

    function layout(n, d, ctx) {
        n.y = d;
        var ks = filhos(n);
        if (!ks.length) { n.x = ctx.i++; ctx.max = Math.max(ctx.max, d); return; }
        ks.forEach(function (k) { layout(n.f[k], d + 1, ctx); });
        n.x = (n.f[ks[0]].x + n.f[ks[ks.length - 1]].x) / 2;
        ctx.max = Math.max(ctx.max, d);
    }

    function desenhar(estado) {
        estado = estado || {};
        var arv = estado.arv || raiz;
        while (svg.firstChild) { svg.removeChild(svg.firstChild); }

        var ctx = { i: 0, max: 0 };
        layout(arv, 0, ctx);
        var largura = Math.max(ctx.i * ESP_X + MARGEM * 2, 320);
        var alturaSvg = ctx.max * ESP_Y + MARGEM * 2 + 8;
        svg.setAttribute('viewBox', '0 0 ' + largura + ' ' + alturaSvg);
        svg.style.minWidth = Math.min(largura, 1100) + 'px';

        function px(n) { return MARGEM + n.x * ESP_X; }
        function py(n) { return MARGEM + n.y * ESP_Y; }

        var arestas = el('g', { 'class': 'sim-arestas' });
        var nos = el('g', {});
        var cam = estado.caminho || [];

        (function percorrer(n) {
            filhos(n).forEach(function (k) {
                var f = n.f[k];
                var ativa = cam.indexOf(n.id) > -1 && cam.indexOf(f.id) > -1;
                arestas.appendChild(el('line', { x1: px(n), y1: py(n), x2: px(f), y2: py(f), 'class': ativa ? 'ativa' : '' }));
            });
            var cls = 'sim-no';
            if (n.fim) { cls += ' fim'; }
            if (cam.indexOf(n.id) > -1) { cls += ' visitado'; }
            if (estado.atual === n.id) { cls += ' atual'; }
            if (estado.achado === n.id) { cls += ' achado'; }
            if (estado.novo === n.id) { cls += ' novo'; }
            if (estado.removido === n.id) { cls += ' removido'; }
            var g = el('g', { 'class': cls });
            g.appendChild(el('circle', { cx: px(n), cy: py(n), r: 20 }));
            var t = el('text', { x: px(n), y: py(n) + (n.c ? 6 : 4), 'text-anchor': 'middle' });
            if (!n.c) { t.setAttribute('class', 'sim-raiz'); }
            t.textContent = n.c || 'raiz';
            g.appendChild(t);
            nos.appendChild(g);
            filhos(n).forEach(function (k) { percorrer(n.f[k]); });
        })(arv);

        svg.appendChild(arestas);
        svg.appendChild(nos);
        atualizarInfo(arv);
    }

    function atualizarInfo(arv) {
        info.textContent = 'Nós (sem a raiz): ' + contarNos(arv) + ' | Palavras: ' + coletar(arv, '', []).length;
    }

    /* ---------- passos e animação ---------- */
    function mensagem(texto, tipo) {
        msg.textContent = texto;
        msg.className = 'sim-msg ' + (tipo || '');
    }

    function travar(sim) {
        ocupado = sim;
        botoes.forEach(function (b) { if (b.id !== 'sim-pular') { b.disabled = sim; } });
        document.getElementById('sim-pular').hidden = !sim;
    }

    function executar(passos, final) {
        lista.innerHTML = '';
        travar(true);
        var i = 0, pulado = false;

        function mostrar(p) {
            var li = document.createElement('li');
            li.textContent = p.texto;
            lista.appendChild(li);
            li.scrollIntoView({ block: 'nearest' });
            desenhar(p.estado);
        }

        function proximo() {
            if (i >= passos.length) { travar(false); if (final) { final(); } return; }
            mostrar(passos[i++]);
            if (pulado) { proximo(); } else { timer = setTimeout(proximo, Number(velocidade.value)); }
        }

        document.getElementById('sim-pular').onclick = function () {
            pulado = true;
            clearTimeout(timer);
            proximo();
        };
        proximo();
    }

    /* ---------- operações ---------- */
    function inserir(p) {
        var passos = criarPassos(), n = raiz, cam = [raiz.id];
        passos.push({ texto: 'Começa na raiz da Trie, que não guarda letra.', estado: { caminho: cam.slice(), atual: n.id } });
        for (var i = 0; i < p.length; i++) {
            var ch = p[i];
            if (n.f[ch]) {
                n = n.f[ch]; cam.push(n.id);
                passos.push({ texto: 'A letra "' + ch + '" já tem ramo: reaproveita o nó e desce.', estado: { caminho: cam.slice(), atual: n.id } });
            } else {
                var novo = novoNo(ch);
                n.f[ch] = novo; n = novo; cam.push(n.id);
                passos.push({ texto: 'Não há ramo para "' + ch + '": cria o nó "' + ch + '".', estado: { caminho: cam.slice(), novo: n.id } });
            }
        }
        if (n.fim) {
            passos.push({ texto: 'Fim das letras: "' + p + '" já estava na Trie (o último nó já era fim de palavra).', estado: { caminho: cam.slice(), achado: n.id } });
            return { passos: passos, ok: false };
        }
        n.fim = true;
        passos.push({ texto: 'Fim das letras: marca o último nó como fim de palavra. "' + p + '" foi inserida.', estado: { caminho: cam.slice(), achado: n.id } });
        return { passos: passos, ok: true };
    }

    function buscar(p, prefixo) {
        var passos = criarPassos(), n = raiz, cam = [raiz.id];
        passos.push({ texto: 'Começa na raiz.', estado: { caminho: cam.slice(), atual: n.id } });
        for (var i = 0; i < p.length; i++) {
            var ch = p[i];
            if (!n.f[ch]) {
                passos.push({ texto: 'Não há ramo para "' + ch + '": ' + (prefixo ? 'nenhuma palavra começa com "' + p + '".' : '"' + p + '" não existe na Trie.'), estado: { caminho: cam.slice() } });
                return { passos: passos, ok: false };
            }
            n = n.f[ch]; cam.push(n.id);
            passos.push({ texto: 'Segue o ramo da letra "' + ch + '".', estado: { caminho: cam.slice(), atual: n.id } });
        }
        if (prefixo) {
            var ps = coletar(n, p, []);
            passos.push({ texto: 'O caminho "' + p + '" existe. Palavras com esse prefixo (' + ps.length + '): ' + ps.join(', ') + '.', estado: { caminho: cam.slice(), achado: n.id } });
            return { passos: passos, ok: true };
        }
        if (n.fim) {
            passos.push({ texto: 'O caminho existe e o último nó é fim de palavra: "' + p + '" existe na Trie.', estado: { caminho: cam.slice(), achado: n.id } });
            return { passos: passos, ok: true };
        }
        passos.push({ texto: 'O caminho existe, mas o último nó não é fim de palavra: "' + p + '" é apenas prefixo de outra palavra.', estado: { caminho: cam.slice(), atual: n.id } });
        return { passos: passos, ok: false };
    }

    function remover(p) {
        var passos = criarPassos(), n = raiz, cam = [raiz.id], pilha = [raiz];
        passos.push({ texto: 'Começa na raiz e percorre o caminho de "' + p + '".', estado: { caminho: cam.slice(), atual: n.id } });
        for (var i = 0; i < p.length; i++) {
            var ch = p[i];
            if (!n.f[ch]) {
                passos.push({ texto: 'Não há ramo para "' + ch + '": "' + p + '" não existe, nada a remover.', estado: { caminho: cam.slice() } });
                return { passos: passos, ok: false };
            }
            n = n.f[ch]; cam.push(n.id); pilha.push(n);
            passos.push({ texto: 'Segue o ramo da letra "' + ch + '".', estado: { caminho: cam.slice(), atual: n.id } });
        }
        if (!n.fim) {
            passos.push({ texto: 'O último nó não é fim de palavra: "' + p + '" era só prefixo de outra palavra, nada a remover.', estado: { caminho: cam.slice(), atual: n.id } });
            return { passos: passos, ok: false };
        }
        n.fim = false;
        passos.push({ texto: 'Desmarca o último nó como fim de palavra.', estado: { caminho: cam.slice(), removido: n.id } });

        var descartou = false;
        for (var j = pilha.length - 1; j >= 1; j--) {
            var no = pilha[j];
            if (no.fim || filhos(no).length) {
                passos.push({ texto: 'O nó "' + no.c + '" ' + (no.fim ? 'é fim de outra palavra' : 'ainda tem filhos') + ', então permanece. Fim da remoção.', estado: { caminho: cam.slice(), atual: no.id } });
                return { passos: passos, ok: true };
            }
            passos.push({ texto: 'O nó "' + no.c + '" ficou sem filhos e não é fim de palavra: é descartado.', estado: { caminho: cam.slice(), removido: no.id } });
            delete pilha[j - 1].f[no.c];
            descartou = true;
        }
        passos.push({ texto: 'Remoção concluída' + (descartou ? ': os nós sem utilidade foram descartados de baixo para cima.' : '.'), estado: {} });
        return { passos: passos, ok: true };
    }

    function listar() {
        var passos = criarPassos(), saida = [];
        if (!filhos(raiz).length) { return { passos: [{ texto: 'A Trie está vazia.', estado: {} }], ok: false }; }
        (function dfs(n, pref, cam) {
            if (n.fim) {
                saida.push(pref);
                passos.push({ texto: 'Fim de palavra: "' + pref + '". Até agora: ' + saida.join(', '), estado: { caminho: cam.slice(), achado: n.id } });
            }
            filhos(n).forEach(function (k) { dfs(n.f[k], pref + k, cam.concat(n.f[k].id)); });
        })(raiz, '', [raiz.id]);
        return { passos: passos, ok: true, resumo: 'Palavras em ordem alfabética: ' + saida.join(', ') + '.' };
    }

    /* ---------- entrada ---------- */
    function lerPalavra() {
        var t = campo.value.trim().toLowerCase();
        if (!/^[a-z]+$/.test(t)) { mensagem('Use apenas letras de a até z, sem espaços, números ou acentos.', 'erro'); campo.focus(); return null; }
        return t;
    }

    function acao(fn) {
        if (ocupado) { return; }
        var p = lerPalavra();
        if (p === null) { return; }
        var r = fn(p);
        executar(r.passos, function () {
            mensagem(r.passos[r.passos.length - 1].texto, r.ok ? 'ok' : 'aviso');
            desenhar({});
            campo.value = ''; campo.focus();
        });
    }

    document.getElementById('sim-inserir').onclick = function () { acao(inserir); };
    document.getElementById('sim-buscar').onclick = function () { acao(function (p) { return buscar(p, false); }); };
    document.getElementById('sim-prefixo').onclick = function () { acao(function (p) { return buscar(p, true); }); };
    document.getElementById('sim-remover').onclick = function () { acao(remover); };
    campo.addEventListener('keydown', function (e) { if (e.key === 'Enter') { document.getElementById('sim-inserir').click(); } });

    document.getElementById('sim-listar').onclick = function () {
        if (ocupado) { return; }
        var r = listar();
        executar(r.passos, function () { mensagem(r.resumo || r.passos[0].texto, r.ok ? 'ok' : 'aviso'); desenhar({}); });
    };

    document.getElementById('sim-exemplo').onclick = function () {
        if (ocupado) { return; }
        proximoId = 1; raiz = novoNo('');
        var palavras = (svg.getAttribute('data-exemplo') || '').split(',');
        var todos = [];
        palavras.forEach(function (w) { todos = todos.concat(inserir(w).passos); });
        executar(todos, function () { mensagem('Exemplo da aula montado: ' + palavras.join(', ') + '. Note o caminho c → a compartilhado.', 'ok'); desenhar({}); });
    };

    document.getElementById('sim-limpar').onclick = function () {
        if (ocupado) { return; }
        proximoId = 1; raiz = novoNo('');
        lista.innerHTML = '';
        mensagem('Trie vazia. Insira uma palavra para começar.', '');
        desenhar({});
    };

    desenhar({});
})();

</script>

<?php require_once "View/Shared/footer.php"; ?>