/* Simulador de Árvore Binária (inserir, buscar, remover e percursos).
   Regra: menores à esquerda, maiores à direita. Valores repetidos são ignorados.
   Remoção com dois filhos usa o sucessor (menor valor da sub-árvore direita). */
(function () {
    'use strict';

    var raiz = document.getElementById('sim-svg');
    if (!raiz) { return; }

    var NS = 'http://www.w3.org/2000/svg';
    var svg = raiz;
    var campo = document.getElementById('sim-valor');
    var lista = document.getElementById('sim-passos');
    var msg = document.getElementById('sim-msg');
    var info = document.getElementById('sim-info');
    var velocidade = document.getElementById('sim-velocidade');
    var botoes = document.querySelectorAll('.sim-controles button');

    var arvore = null;
    var proximoId = 1;
    var ocupado = false;
    var timer = null;

    function novoNo(v) { return { id: proximoId++, v: v, esq: null, dir: null }; }

    function clonar(n) {
        return n ? { id: n.id, v: n.v, esq: clonar(n.esq), dir: clonar(n.dir) } : null;
    }

    /* cada passo guarda uma cópia da árvore naquele instante */
    function criarPassos() {
        var a = [];
        a.push = function (p) {
            p.estado.arv = clonar(arvore);
            return Array.prototype.push.call(a, p);
        };
        return a;
    }

    function altura(n) { return n ? 1 + Math.max(altura(n.esq), altura(n.dir)) : 0; }
    function contar(n) { return n ? 1 + contar(n.esq) + contar(n.dir) : 0; }

    /* ---------- desenho ---------- */
    function el(nome, attrs) {
        var e = document.createElementNS(NS, nome);
        for (var k in attrs) { e.setAttribute(k, attrs[k]); }
        return e;
    }

    function layout(n, nivel, ctx) {
        if (!n) { return; }
        layout(n.esq, nivel + 1, ctx);
        n.x = ctx.i++;
        n.y = nivel;
        layout(n.dir, nivel + 1, ctx);
    }

    function desenhar(estado) {
        estado = estado || {};
        var arv = estado.arv !== undefined ? estado.arv : arvore;
        while (svg.firstChild) { svg.removeChild(svg.firstChild); }

        var ctx = { i: 0 };
        layout(arv, 0, ctx);
        var h = altura(arv);
        var largura = Math.max(ctx.i * 64 + 40, 320);
        var alturaSvg = Math.max(h * 76 + 40, 140);
        svg.setAttribute('viewBox', '0 0 ' + largura + ' ' + alturaSvg);
        svg.style.minWidth = Math.min(largura, 1100) + 'px';

        if (!arv) {
            var t = el('text', { x: largura / 2, y: alturaSvg / 2, 'text-anchor': 'middle', 'class': 'sim-vazia' });
            t.textContent = 'Árvore vazia';
            svg.appendChild(t);
            atualizarInfo(arv);
            return;
        }

        function px(n) { return 32 + n.x * 64; }
        function py(n) { return 30 + n.y * 76; }

        var arestas = el('g', { 'class': 'sim-arestas' });
        var nos = el('g', {});
        (function percorrer(n) {
            if (!n) { return; }
            [n.esq, n.dir].forEach(function (f) {
                if (f) {
                    var ativa = estado.caminho && estado.caminho.indexOf(n.id) > -1 && estado.caminho.indexOf(f.id) > -1;
                    arestas.appendChild(el('line', { x1: px(n), y1: py(n), x2: px(f), y2: py(f), 'class': ativa ? 'ativa' : '' }));
                }
            });
            var cls = 'sim-no';
            if (estado.caminho && estado.caminho.indexOf(n.id) > -1) { cls += ' visitado'; }
            if (estado.atual === n.id) { cls += ' atual'; }
            if (estado.achado === n.id) { cls += ' achado'; }
            if (estado.novo === n.id) { cls += ' novo'; }
            if (estado.removido === n.id) { cls += ' removido'; }
            var g = el('g', { 'class': cls });
            g.appendChild(el('circle', { cx: px(n), cy: py(n), r: 22 }));
            var txt = el('text', { x: px(n), y: py(n) + 6, 'text-anchor': 'middle' });
            txt.textContent = n.v;
            g.appendChild(txt);
            nos.appendChild(g);
            percorrer(n.esq);
            percorrer(n.dir);
        })(arv);
        svg.appendChild(arestas);
        svg.appendChild(nos);
        atualizarInfo(arv);
    }

    function atualizarInfo(arv) {
        info.textContent = 'Nós: ' + contar(arv) + ' | Altura: ' + altura(arv);
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
        var i = 0;
        var pulado = false;

        function mostrar(p) {
            var li = document.createElement('li');
            li.textContent = p.texto;
            lista.appendChild(li);
            li.scrollIntoView({ block: 'nearest' });
            desenhar(p.estado);
        }

        function terminar() {
            travar(false);
            if (final) { final(); }
        }

        function proximo() {
            if (i >= passos.length) { terminar(); return; }
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

    /* ---------- operações (geram passos, sem animar) ---------- */
    function passosInserir(v) {
        var passos = criarPassos();
        if (!arvore) {
            arvore = novoNo(v);
            passos.push({ texto: 'Árvore vazia, então ' + v + ' se torna a raiz.', estado: { novo: arvore.id, caminho: [arvore.id] } });
            return { passos: passos, ok: true };
        }
        var atual = arvore, caminho = [];
        while (true) {
            caminho.push(atual.id);
            if (v === atual.v) {
                passos.push({ texto: v + ' = ' + atual.v + ': o valor já existe e não é inserido novamente.', estado: { caminho: caminho.slice(), achado: atual.id } });
                return { passos: passos, ok: false };
            }
            var lado = v < atual.v ? 'esq' : 'dir';
            var sinal = v < atual.v ? ' < ' : ' > ';
            var nome = v < atual.v ? 'esquerdo' : 'direito';
            if (!atual[lado]) {
                var no = novoNo(v);
                atual[lado] = no;
                caminho.push(no.id);
                passos.push({ texto: v + sinal + atual.v + ' e não há filho ' + nome + ': insere ' + v + ' como filho ' + nome + ' de ' + atual.v + '.', estado: { caminho: caminho.slice(), novo: no.id } });
                return { passos: passos, ok: true };
            }
            passos.push({ texto: v + sinal + atual.v + ', então desce para o filho ' + nome + '.', estado: { caminho: caminho.slice(), atual: atual.id } });
            atual = atual[lado];
        }
    }

    function passosBuscar(v) {
        var passos = criarPassos(), atual = arvore, caminho = [];
        if (!atual) { return { passos: [{ texto: 'A árvore está vazia: ' + v + ' não existe.', estado: {} }], ok: false }; }
        while (atual) {
            caminho.push(atual.id);
            if (v === atual.v) {
                passos.push({ texto: v + ' = ' + atual.v + ': valor encontrado após ' + caminho.length + ' comparação(ões).', estado: { caminho: caminho.slice(), achado: atual.id } });
                return { passos: passos, ok: true };
            }
            var esq = v < atual.v;
            passos.push({ texto: v + (esq ? ' < ' : ' > ') + atual.v + ', então segue para o filho ' + (esq ? 'esquerdo' : 'direito') + '.', estado: { caminho: caminho.slice(), atual: atual.id } });
            atual = esq ? atual.esq : atual.dir;
        }
        passos.push({ texto: 'Chegou a um ponteiro nulo: ' + v + ' não existe na árvore (' + caminho.length + ' comparação(ões)).', estado: { caminho: caminho.slice() } });
        return { passos: passos, ok: false };
    }

    function passosRemover(v) {
        var passos = criarPassos(), pai = null, lado = null, atual = arvore, caminho = [];
        while (atual && atual.v !== v) {
            caminho.push(atual.id);
            var esq = v < atual.v;
            passos.push({ texto: v + (esq ? ' < ' : ' > ') + atual.v + ', então procura no filho ' + (esq ? 'esquerdo' : 'direito') + '.', estado: { caminho: caminho.slice(), atual: atual.id } });
            pai = atual; lado = esq ? 'esq' : 'dir';
            atual = atual[lado];
        }
        if (!atual) {
            passos.push({ texto: v + ' não foi encontrado: nada a remover.', estado: { caminho: caminho.slice() } });
            return { passos: passos, ok: false };
        }
        caminho.push(atual.id);
        passos.push({ texto: 'Encontrou ' + v + '. Verificando quantos filhos o nó possui.', estado: { caminho: caminho.slice(), removido: atual.id } });

        function trocar(filho) { if (!pai) { arvore = filho; } else { pai[lado] = filho; } }

        if (!atual.esq && !atual.dir) {
            passos.push({ texto: 'Caso 1, folha: o nó é simplesmente removido.', estado: { caminho: caminho.slice(), removido: atual.id } });
            trocar(null);
            passos.push({ texto: 'Folha removida.', estado: {} });
        } else if (!atual.esq || !atual.dir) {
            var filho = atual.esq || atual.dir;
            passos.push({ texto: 'Caso 2, um filho: o filho ' + filho.v + ' ocupa o lugar de ' + v + '.', estado: { caminho: caminho.slice(), removido: atual.id, atual: filho.id } });
            trocar(filho);
            passos.push({ texto: 'Nó removido; o filho foi ligado ao pai.', estado: {} });
        } else {
            var sp = atual, suc = atual.dir;
            caminho.push(suc.id);
            passos.push({ texto: 'Caso 3, dois filhos: procura o sucessor (menor da sub-árvore direita). Começa em ' + suc.v + '.', estado: { caminho: caminho.slice(), removido: atual.id, atual: suc.id } });
            while (suc.esq) {
                sp = suc; suc = suc.esq;
                caminho.push(suc.id);
                passos.push({ texto: 'Desce à esquerda até ' + suc.v + '.', estado: { caminho: caminho.slice(), removido: atual.id, atual: suc.id } });
            }
            passos.push({ texto: 'O sucessor é ' + suc.v + '. Seu valor é copiado para o nó de ' + v + '.', estado: { caminho: caminho.slice(), removido: atual.id, achado: suc.id } });
            atual.v = suc.v;
            if (sp === atual) { sp.dir = suc.dir; } else { sp.esq = suc.dir; }
            passos.push({ texto: 'O nó original do sucessor é removido (tinha no máximo um filho).', estado: {} });
        }
        return { passos: passos, ok: true };
    }

    function passosPercurso(tipo) {
        var seq = [], passos = [];
        (function p(n) {
            if (!n) { return; }
            if (tipo === 'pre') { seq.push(n); }
            p(n.esq);
            if (tipo === 'em') { seq.push(n); }
            p(n.dir);
            if (tipo === 'pos') { seq.push(n); }
        })(arvore);
        var nome = { em: 'Em-ordem (esquerda, raiz, direita)', pre: 'Pré-ordem (raiz, esquerda, direita)', pos: 'Pós-ordem (esquerda, direita, raiz)' }[tipo];
        if (!seq.length) { return { passos: [{ texto: 'A árvore está vazia.', estado: {} }], ok: false }; }
        var vis = [], saida = [];
        seq.forEach(function (n) {
            vis.push(n.id); saida.push(n.v);
            passos.push({ texto: nome + ': visita ' + n.v + '. Sequência: ' + saida.join(', '), estado: { caminho: vis.slice(), atual: n.id } });
        });
        return { passos: passos, ok: true, resumo: nome + ' -> ' + saida.join(', ') };
    }

    /* ---------- entrada ---------- */
    function lerValor() {
        var t = campo.value.trim();
        if (!/^-?\d+$/.test(t)) { mensagem('Digite um número inteiro.', 'erro'); campo.focus(); return null; }
        return parseInt(t, 10);
    }

    function acao(fn, aoTerminar) {
        if (ocupado) { return; }
        var v = lerValor();
        if (v === null) { return; }
        var r = fn(v);
        executar(r.passos, function () {
            mensagem(r.passos[r.passos.length - 1].texto, r.ok ? 'ok' : 'aviso');
            if (aoTerminar) { aoTerminar(); }
            desenhar({});
            campo.value = ''; campo.focus();
        });
    }

    document.getElementById('sim-inserir').onclick = function () { acao(passosInserir); };
    document.getElementById('sim-buscar').onclick = function () { acao(passosBuscar); };
    document.getElementById('sim-remover').onclick = function () { acao(passosRemover); };

    campo.addEventListener('keydown', function (e) { if (e.key === 'Enter') { document.getElementById('sim-inserir').click(); } });

    ['em', 'pre', 'pos'].forEach(function (tipo) {
        document.getElementById('sim-' + tipo).onclick = function () {
            if (ocupado) { return; }
            var r = passosPercurso(tipo);
            executar(r.passos, function () { mensagem(r.resumo || r.passos[0].texto, r.ok ? 'ok' : 'aviso'); desenhar({}); });
        };
    });

    document.getElementById('sim-exemplo').onclick = function () {
        if (ocupado) { return; }
        arvore = null; proximoId = 1;
        var valores = (svg.getAttribute('data-exemplo') || '').split(',').map(Number);
        var todos = [];
        valores.forEach(function (v) { todos = todos.concat(passosInserir(v).passos); });
        executar(todos, function () { mensagem('Exemplo da aula montado: ' + valores.join(', ') + '. Agora experimente buscar, remover ou percorrer.', 'ok'); desenhar({}); });
    };

    document.getElementById('sim-limpar').onclick = function () {
        if (ocupado) { return; }
        arvore = null; proximoId = 1;
        lista.innerHTML = '';
        mensagem('Árvore vazia. Insira um valor para começar.', '');
        desenhar({});
    };

    desenhar({});
})();