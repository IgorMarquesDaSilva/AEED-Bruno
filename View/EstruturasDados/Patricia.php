<?php require_once "View/Shared/header.php"; ?>

        <section class="aula-hero">
            <div>
                <span class="rotulo">Trie compacta: fragmentos em vez de letras</span>
                <h1><?php echo htmlspecialchars($conteudo["titulo"]); ?></h1>
                <p class="introducao">
                    <?php echo htmlspecialchars($conteudo["introducao"]); ?>
                </p>
            </div>

            <div class="aula-resumo">
                <strong>Árvore Patricia</strong>
                <span>Mesmas palavras, bem menos nós que a Trie</span>
                <a href="#codigo">Ver exemplos em C#</a>
            </div>
        </section>

        <div class="aula-layout">
            <nav class="indice">
            <h2>Nesta aula</h2>

            <a href="#objetivos">Objetivos</a>
            <a href="#conceito">Conceito</a>
            <a href="#anatomia">Fragmento, filho e irmão</a>
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
            <h2>O que é uma Árvore Patricia?</h2>

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
                <h3><?php echo htmlspecialchars($conteudo["diferencaTitulo"]); ?></h3>
                <p><?php echo htmlspecialchars($conteudo["diferencaTrie"]); ?></p>
            </div>

            <h3>Aplicações práticas</h3>

            <ul class="lista-topicos">
                <?php foreach ($conteudo["aplicacoes"] as $aplicacao) { ?>
                    <li><?php echo htmlspecialchars($aplicacao); ?></li>
                <?php } ?>
            </ul>
        </section>

        <section id="anatomia" class="secao">
            <h2>Fragmento, filho e irmão</h2>
            <p>
                Cada nó da Patricia guarda um fragmento da palavra e um indicador de
                fim de palavra, além de dois ponteiros: filho, que desce um
                nível continuando a palavra, e próximo, que leva ao irmão do
                mesmo nível. Os irmãos ficam em ordem alfabética.
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
                Inserir uma palavra significa procurar, nível a nível, o ponto de
                encaixe. Quando a palavra coincide só com o começo de um
                fragmento, o nó é dividido em dois.
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
                Depois de remover uma palavra, a árvore precisa continuar compacta:
                nós sem utilidade são descartados e um nó que sobra com um único
                filho é fundido com ele.
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
                    <button type="button" id="sim-buscar">Buscar</button>
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
                    <svg id="sim-svg" role="img" aria-label="Árvore Patricia do simulador" data-exemplo="<?php echo htmlspecialchars(str_replace(' ', '', $conteudo["simulador"]["palavrasExemplo"])); ?>" xmlns="http://www.w3.org/2000/svg"></svg>
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
            <h2>Trie x Patricia</h2>

            <div class="tabela-container">
                <table>
                    <thead>
                        <tr>
                            <th>Critério</th>
                            <th>Trie</th>
                            <th>Patricia</th>
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
/* Simulador de Árvore Patricia (versão em caracteres estudada em aula).
   Cada nó: fragmento, fim de palavra, filho (desce um nível) e prox (próximo irmão).
   Irmãos em ordem alfabética. Inserção divide nós; remoção descarta ou funde nós. */
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
    var T = { raiz: null };
    var ocupado = false;
    var timer = null;

    function novoNo(frag, fim) { return { id: proximoId++, frag: frag, fim: !!fim, filho: null, prox: null }; }

    function clonar(n) {
        if (!n) { return null; }
        return { id: n.id, frag: n.frag, fim: n.fim, filho: clonar(n.filho), prox: clonar(n.prox) };
    }

    function criarPassos() {
        var a = [];
        a.push = function (p) {
            p.estado.arv = { raiz: clonar(T.raiz) };
            return Array.prototype.push.call(a, p);
        };
        return a;
    }

    function prefixoComum(a, b) {
        var i = 0;
        while (i < a.length && i < b.length && a[i] === b[i]) { i++; }
        return i;
    }

    function contarNos(n) { return n ? 1 + contarNos(n.filho) + contarNos(n.prox) : 0; }

    function coletar(n, pref, saida) {
        while (n) {
            var atual = pref + n.frag;
            if (n.fim) { saida.push(atual); }
            coletar(n.filho, atual, saida);
            n = n.prox;
        }
        return saida;
    }

    /* quantos nós uma Trie teria para as mesmas palavras (um por prefixo distinto) */
    function nosDaTrie(palavras) {
        var s = {};
        palavras.forEach(function (w) { for (var i = 1; i <= w.length; i++) { s[w.slice(0, i)] = 1; } });
        return Object.keys(s).length;
    }

    /* ---------- desenho ---------- */
    function el(nome, attrs) {
        var e = document.createElementNS(NS, nome);
        for (var k in attrs) { e.setAttribute(k, attrs[k]); }
        return e;
    }

    var ALT = 36, ESP_Y = 84, GAP = 44, MARGEM = 30, TOPO = 58;

    function larg(n) { return Math.max(40, n.frag.length * 12 + 24); }

    function layout(n, nivel, x0, ctx) {
        var x = x0, fim = x0;
        while (n) {
            n.w = larg(n); n.nivel = nivel; n.x = x;
            ctx.max = Math.max(ctx.max, nivel);
            var wf = n.filho ? layout(n.filho, nivel + 1, x, ctx) : 0;
            fim = x + Math.max(n.w, wf);
            x = fim + GAP;
            n = n.prox;
        }
        return fim - x0;
    }

    function desenhar(estado) {
        estado = estado || {};
        var arv = estado.arv ? estado.arv.raiz : T.raiz;
        while (svg.firstChild) { svg.removeChild(svg.firstChild); }

        var defs = el('defs', {});
        [['sim-seta-filho', '#b42318'], ['sim-seta-irmao', '#2563eb']].forEach(function (m) {
            var mk = el('marker', { id: m[0], viewBox: '0 0 10 10', refX: 9, refY: 5, markerWidth: 7, markerHeight: 7, orient: 'auto-start-reverse' });
            mk.appendChild(el('path', { d: 'M0,0 L10,5 L0,10 z', fill: m[1] }));
            defs.appendChild(mk);
        });
        svg.appendChild(defs);

        var ctx = { max: 0 };
        var total = layout(arv, 0, MARGEM, ctx);
        var largura = Math.max(total + MARGEM * 2, 320);
        var alturaSvg = TOPO + ctx.max * ESP_Y + ALT + MARGEM;
        svg.setAttribute('viewBox', '0 0 ' + largura + ' ' + alturaSvg);
        svg.style.minWidth = Math.min(largura, 1100) + 'px';

        if (!arv) {
            var t = el('text', { x: largura / 2, y: alturaSvg / 2, 'text-anchor': 'middle', 'class': 'sim-vazia' });
            t.textContent = 'Árvore vazia';
            svg.appendChild(t);
            atualizarInfo(arv);
            return;
        }

        function py(n) { return TOPO + n.nivel * ESP_Y; }
        var cam = estado.caminho || [];
        var setas = el('g', { fill: 'none', 'stroke-width': 3 });
        var nos = el('g', {});

        var rt = el('text', { x: arv.x + arv.w / 2, y: 18, 'text-anchor': 'middle', 'class': 'sim-rotulo' });
        rt.textContent = 'raiz';
        nos.appendChild(rt);
        setas.appendChild(el('line', { x1: arv.x + arv.w / 2, y1: 24, x2: arv.x + arv.w / 2, y2: py(arv) - 3, stroke: '#b42318', 'marker-end': 'url(#sim-seta-filho)' }));

        (function percorrer(n) {
            for (; n; n = n.prox) {
                if (n.prox) {
                    setas.appendChild(el('line', { x1: n.x + n.w, y1: py(n) + ALT / 2, x2: n.prox.x - 2, y2: py(n) + ALT / 2, stroke: '#2563eb', 'marker-end': 'url(#sim-seta-irmao)' }));
                }
                if (n.filho) {
                    var cx = n.x + n.w / 2, fx = n.filho.x + n.filho.w / 2, meio = py(n) + ALT + (ESP_Y - ALT) / 2;
                    setas.appendChild(el('path', { d: 'M' + cx + ',' + (py(n) + ALT) + ' V' + meio + ' H' + fx + ' V' + (py(n.filho) - 3), stroke: '#b42318', 'marker-end': 'url(#sim-seta-filho)' }));
                }
                var cls = 'sim-pat';
                if (n.fim) { cls += ' fim'; }
                if (cam.indexOf(n.id) > -1) { cls += ' visitado'; }
                if (estado.atual === n.id) { cls += ' atual'; }
                if (estado.achado === n.id) { cls += ' achado'; }
                if (estado.novo === n.id) { cls += ' novo'; }
                if (estado.removido === n.id) { cls += ' removido'; }
                var g = el('g', { 'class': cls });
                g.appendChild(el('rect', { x: n.x, y: py(n), width: n.w, height: ALT, rx: 7 }));
                var tx = el('text', { x: n.x + n.w / 2, y: py(n) + 24, 'text-anchor': 'middle' });
                tx.textContent = n.frag;
                g.appendChild(tx);
                nos.appendChild(g);
                percorrer(n.filho);
            }
        })(arv);

        svg.appendChild(setas);
        svg.appendChild(nos);
        atualizarInfo(arv);
    }

    function atualizarInfo(arv) {
        var ps = coletar(arv, '', []);
        info.textContent = 'Nós: ' + contarNos(arv) + ' | Palavras: ' + ps.length + (ps.length ? ' | Uma Trie com as mesmas palavras teria ' + nosDaTrie(ps) + ' nós' : '');
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

    /* ---------- operações (seguem o código C# do módulo) ---------- */
    function inserir(palavra) {
        var passos = criarPassos(), cam = [], slot = { o: T, c: 'raiz' }, original = palavra;
        while (true) {
            var no = slot.o[slot.c];
            if (!no) {
                var novo = novoNo(palavra, true);
                slot.o[slot.c] = novo;
                cam.push(novo.id);
                var t = slot.c === 'raiz' ? 'Árvore vazia: "' + palavra + '" se torna o primeiro nó e é fim de palavra.'
                    : slot.c === 'prox' ? 'Acabaram os irmãos deste nível: "' + palavra + '" entra como último irmão (fim de palavra).'
                    : 'O nível abaixo está vazio: o restante "' + palavra + '" vira o filho (fim de palavra).';
                passos.push({ texto: t, estado: { caminho: cam.slice(), novo: novo.id } });
                return { passos: passos, ok: true };
            }
            cam.push(no.id);
            var k = prefixoComum(no.frag, palavra);

            if (k === 0) {
                if (palavra[0] < no.frag[0]) {
                    var ant = novoNo(palavra, true);
                    ant.prox = no;
                    slot.o[slot.c] = ant;
                    cam.push(ant.id);
                    passos.push({ texto: 'Nenhuma letra em comum com "' + no.frag + '", e "' + palavra[0] + '" vem antes de "' + no.frag[0] + '": "' + palavra + '" entra antes deste irmão.', estado: { caminho: cam.slice(), novo: ant.id } });
                    return { passos: passos, ok: true };
                }
                passos.push({ texto: 'Nenhuma letra em comum com "' + no.frag + '": passa para o próximo irmão.', estado: { caminho: cam.slice(), atual: no.id } });
                slot = { o: no, c: 'prox' };
                continue;
            }

            var dividiu = false;
            if (k < no.frag.length) {
                var resto = novoNo(no.frag.slice(k), no.fim);
                resto.filho = no.filho;
                var antigo = no.frag;
                no.frag = antigo.slice(0, k);
                no.fim = false;
                no.filho = resto;
                dividiu = true;
                passos.push({ texto: '"' + palavra + '" coincide só com o início de "' + antigo + '" (trecho em comum: "' + no.frag + '"): divide o nó em "' + no.frag + '" e "' + resto.frag + '".', estado: { caminho: cam.slice(), atual: no.id, novo: resto.id } });
            }

            if (k === palavra.length) {
                if (!dividiu && no.fim) {
                    passos.push({ texto: '"' + original + '" já existe: o nó "' + no.frag + '" já era fim de palavra.', estado: { caminho: cam.slice(), achado: no.id } });
                    return { passos: passos, ok: false };
                }
                no.fim = true;
                passos.push({ texto: 'A palavra termina neste nó: marca "' + no.frag + '" como fim de palavra.', estado: { caminho: cam.slice(), achado: no.id } });
                return { passos: passos, ok: true };
            }
            palavra = palavra.slice(k);
            passos.push({ texto: 'Coincide em "' + no.frag + '". Sobrou "' + palavra + '": desce para o nível abaixo.', estado: { caminho: cam.slice(), atual: no.id } });
            slot = { o: no, c: 'filho' };
        }
    }

    function buscar(palavra) {
        var passos = criarPassos(), no = T.raiz, cam = [], original = palavra;
        if (!no) { return { passos: [{ texto: 'A árvore está vazia: "' + original + '" não existe.', estado: {} }], ok: false }; }
        while (no) {
            cam.push(no.id);
            var k = prefixoComum(no.frag, palavra);
            if (k === 0) {
                passos.push({ texto: '"' + no.frag + '" não coincide com "' + palavra + '": tenta o próximo irmão.', estado: { caminho: cam.slice(), atual: no.id } });
                no = no.prox;
            } else if (k < no.frag.length) {
                passos.push({ texto: 'O nó "' + no.frag + '" coincide só em parte com "' + palavra + '": "' + original + '" não existe.', estado: { caminho: cam.slice(), atual: no.id } });
                return { passos: passos, ok: false };
            } else if (k === palavra.length) {
                if (no.fim) {
                    passos.push({ texto: 'Chegou ao fim da palavra em "' + no.frag + '", que é fim de palavra: "' + original + '" existe.', estado: { caminho: cam.slice(), achado: no.id } });
                    return { passos: passos, ok: true };
                }
                passos.push({ texto: 'Chegou ao fim da palavra em "' + no.frag + '", mas ele não é fim de palavra: "' + original + '" é só prefixo de outra palavra.', estado: { caminho: cam.slice(), atual: no.id } });
                return { passos: passos, ok: false };
            } else {
                palavra = palavra.slice(k);
                passos.push({ texto: 'Coincide em "' + no.frag + '". Sobrou "' + palavra + '": desce para o nível abaixo.', estado: { caminho: cam.slice(), atual: no.id } });
                no = no.filho;
            }
        }
        passos.push({ texto: 'Acabaram os nós deste nível sem coincidência: "' + original + '" não existe.', estado: { caminho: cam.slice() } });
        return { passos: passos, ok: false };
    }

    function remover(palavra) {
        var passos = criarPassos(), cam = [], res = { ok: true }, original = palavra;

        function rec(no, p) {
            if (!no) {
                passos.push({ texto: 'Acabaram os nós deste nível sem coincidência: "' + original + '" não existe.', estado: { caminho: cam.slice() } });
                res.ok = false;
                return null;
            }
            cam.push(no.id);
            var k = prefixoComum(no.frag, p);
            if (k === 0) {
                passos.push({ texto: 'Nenhuma letra em comum com "' + no.frag + '": passa para o próximo irmão.', estado: { caminho: cam.slice(), atual: no.id } });
                no.prox = rec(no.prox, p);
                return no;
            }
            if (k < no.frag.length) {
                passos.push({ texto: 'O nó "' + no.frag + '" coincide só em parte: "' + original + '" não existe.', estado: { caminho: cam.slice(), atual: no.id } });
                res.ok = false;
                return no;
            }
            if (k === p.length) {
                if (!no.fim) {
                    passos.push({ texto: 'O nó "' + no.frag + '" não é fim de palavra: "' + original + '" era só prefixo de outra palavra, nada a remover.', estado: { caminho: cam.slice(), atual: no.id } });
                    res.ok = false;
                    return no;
                }
                no.fim = false;
                passos.push({ texto: 'Encontrou "' + original + '": desmarca "' + no.frag + '" como fim de palavra.', estado: { caminho: cam.slice(), removido: no.id } });
            } else {
                var rest = p.slice(k);
                passos.push({ texto: 'Coincide em "' + no.frag + '". Sobrou "' + rest + '": desce para o nível abaixo.', estado: { caminho: cam.slice(), atual: no.id } });
                no.filho = rec(no.filho, rest);
            }
            if (!no.fim && res.ok) {
                if (!no.filho) {
                    passos.push({ texto: 'O nó "' + no.frag + '" não é fim de palavra e ficou sem filhos: é descartado (os irmãos são preservados).', estado: { caminho: cam.slice(), removido: no.id } });
                    return no.prox;
                }
                if (!no.filho.prox) {
                    var a = no.frag, b = no.filho.frag;
                    no.frag = a + b;
                    no.fim = no.filho.fim;
                    no.filho = no.filho.filho;
                    passos.push({ texto: '"' + a + '" não é fim de palavra e ficou com um único filho: funde "' + a + '" e "' + b + '" em "' + no.frag + '".', estado: { caminho: cam.slice(), achado: no.id } });
                }
            }
            return no;
        }

        T.raiz = rec(T.raiz, palavra);
        if (res.ok) { passos.push({ texto: 'Remoção concluída: "' + original + '" foi removida.', estado: {} }); }
        return { passos: passos, ok: res.ok };
    }

    function listar() {
        var passos = criarPassos(), saida = [];
        if (!T.raiz) { return { passos: [{ texto: 'A árvore está vazia.', estado: {} }], ok: false }; }
        (function dfs(no, pref, cam) {
            while (no) {
                var atual = pref + no.frag, c = cam.concat(no.id);
                if (no.fim) {
                    saida.push(atual);
                    passos.push({ texto: 'Fim de palavra: "' + atual + '". Até agora: ' + saida.join(', '), estado: { caminho: c.slice(), achado: no.id } });
                }
                dfs(no.filho, atual, c);
                no = no.prox;
            }
        })(T.raiz, '', []);
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
    document.getElementById('sim-buscar').onclick = function () { acao(buscar); };
    document.getElementById('sim-remover').onclick = function () { acao(remover); };
    campo.addEventListener('keydown', function (e) { if (e.key === 'Enter') { document.getElementById('sim-inserir').click(); } });

    document.getElementById('sim-listar').onclick = function () {
        if (ocupado) { return; }
        var r = listar();
        executar(r.passos, function () { mensagem(r.resumo || r.passos[0].texto, r.ok ? 'ok' : 'aviso'); desenhar({}); });
    };

    document.getElementById('sim-exemplo').onclick = function () {
        if (ocupado) { return; }
        proximoId = 1; T.raiz = null;
        var palavras = (svg.getAttribute('data-exemplo') || '').split(',');
        var todos = [];
        palavras.forEach(function (w) { todos = todos.concat(inserir(w).passos); });
        executar(todos, function () { mensagem('Exemplo da aula montado: ' + palavras.join(', ') + '. Compare com a Trie: mesmas palavras, bem menos nós.', 'ok'); desenhar({}); });
    };

    document.getElementById('sim-limpar').onclick = function () {
        if (ocupado) { return; }
        proximoId = 1; T.raiz = null;
        lista.innerHTML = '';
        mensagem('Árvore vazia. Insira uma palavra para começar.', '');
        desenhar({});
    };

    desenhar({});
})();

</script>

<?php require_once "View/Shared/footer.php"; ?>