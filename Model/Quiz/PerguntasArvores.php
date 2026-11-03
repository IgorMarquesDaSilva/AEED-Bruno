<?php
class PerguntasArvores
{
    private static function teoria($tema, $enunciado, $alternativas, $correta, $explicacao)
    {
        return compact('tema', 'enunciado', 'alternativas', 'correta', 'explicacao') + ['tipo' => 'Teoria'];
    }

    private static function codigo($tema, $enunciado, $codigo, $alternativas, $correta, $explicacao)
    {
        return compact('tema', 'enunciado', 'codigo', 'alternativas', 'correta', 'explicacao') + ['tipo' => 'Código'];
    }

    public static function listar()
    {
        return self::arvoreBinaria() + self::trie() + self::patricia();
    }

    private static function arvoreBinaria()
    {
        $emOrdem = <<<'CODE'
public void emOrdem(NoArvore no)
{
    if (no != null)
    {
        emOrdem(no.esq);
        Console.WriteLine(no.valor);
        emOrdem(no.dir);
    }
}
CODE;
        $preOrdem = <<<'CODE'
public void preOrdem(NoArvore no)
{
    if (no != null)
    {
        Console.WriteLine(no.valor);
        preOrdem(no.esq);
        preOrdem(no.dir);
    }
}
CODE;
        $inserirRec = <<<'CODE'
private NoArvore inserirRec(NoArvore noAtual, int Valor)
{
    if (noAtual == null)
    {
        return (new NoArvore(Valor));
    }
    if (Valor < noAtual.valor)
    {
        noAtual.esq = inserirRec(noAtual.esq, Valor);
    }
    else if (Valor > noAtual.valor)
    {
        noAtual.dir = inserirRec(noAtual.dir, Valor);
    }
    return (noAtual);
}
CODE;
        $alturaRec = <<<'CODE'
private int alturaRec(NoArvore no)
{
    if (no == null)
    {
        return (0);
    }
    int alturaEsq = alturaRec(no.esq);
    int alturaDir = alturaRec(no.dir);

    if (alturaEsq > alturaDir)
    {
        return (1 + alturaEsq);
    }
    return (1 + alturaDir);
}
CODE;
        $removerRec = <<<'CODE'
private NoArvore removerRec(NoArvore noAtual, int Valor)
{
    if (noAtual == null)
    {
        return (null);
    }
    if (Valor < noAtual.valor)
    {
        noAtual.esq = removerRec(noAtual.esq, Valor);
    }
    else if (Valor > noAtual.valor)
    {
        noAtual.dir = removerRec(noAtual.dir, Valor);
    }
    else
    {
        if (noAtual.esq == null) return (noAtual.dir);
        if (noAtual.dir == null) return (noAtual.esq);

        NoArvore sucessor = noAtual.dir;
        while (sucessor.esq != null)
        {
            sucessor = sucessor.esq;
        }
        noAtual.valor = sucessor.valor;
        noAtual.dir = removerRec(noAtual.dir, sucessor.valor);
    }
    return (noAtual);
}
CODE;

        return [
            'arvorebinaria-1' => self::teoria('arvorebinaria',
                'Na árvore binária desta aula, um novo valor é menor que o valor da raiz. Onde ele será inserido?',
                ['Como nova raiz, deslocando a antiga para a direita.', 'Na sub-árvore esquerda, descendo até encontrar um ponteiro nulo.', 'Na sub-árvore direita, ao lado do maior valor.', 'No último nível da árvore, na posição livre mais à direita.'], 1,
                'Valores menores seguem para a esquerda. A comparação se repete em cada nó visitado até aparecer um ponteiro nulo, onde o novo nó é ligado como folha.'),
            'arvorebinaria-2' => self::teoria('arvorebinaria',
                'Os valores 20, 27, 10, 51, 21, 7 e 12 são inseridos, nessa ordem, em uma árvore binária vazia. Qual é a altura da árvore, contando a raiz como nível 1?',
                ['2', '3', '4', '7'], 1,
                'O 20 é a raiz (nível 1); 10 e 27 ficam no nível 2; 7, 12, 21 e 51 ficam no nível 3. A altura é 3.'),
            'arvorebinaria-3' => self::teoria('arvorebinaria',
                'Por que a árvore binária desta aula é chamada de não balanceada?',
                ['Porque cada nó pode ter mais de dois filhos.', 'Porque o formato depende da ordem de inserção e um lado pode ficar muito mais profundo que o outro.', 'Porque os valores maiores ficam sempre à esquerda.', 'Porque ela não permite remover nós.'], 1,
                'Nenhuma regra redistribui os nós durante a inserção. Dependendo da ordem dos valores, a árvore pode ficar desequilibrada, até se parecer com uma lista.'),
            'arvorebinaria-4' => self::teoria('arvorebinaria',
                'Qual percurso visita os valores de uma árvore binária de busca em ordem crescente?',
                ['Pré-ordem: nó, esquerda, direita.', 'Pós-ordem: esquerda, direita, nó.', 'Em-ordem: esquerda, nó, direita.', 'Do último nível para a raiz.'], 2,
                'No percurso em-ordem, todos os valores menores (sub-árvore esquerda) são visitados antes do nó, e os maiores (sub-árvore direita) depois dele.'),
            'arvorebinaria-5' => self::teoria('arvorebinaria',
                'Um nó com dois filhos será removido de uma árvore binária de busca. Qual estratégia preserva a regra de menores à esquerda e maiores à direita?',
                ['Ligar o ponteiro do pai a nulo, descartando as duas sub-árvores.', 'Copiar para o nó o menor valor da sub-árvore direita e remover esse valor de lá.', 'Trocar o nó pela raiz da árvore.', 'Promover o filho esquerdo e descartar o direito.'], 1,
                'O menor valor da sub-árvore direita (o sucessor) é maior que tudo à esquerda e menor que o restante da direita, então pode ocupar o lugar do nó removido.'),
            'arvorebinaria-6' => self::teoria('arvorebinaria',
                'Em qual situação a busca em uma árvore binária de busca chega ao pior caso, O(n)?',
                ['Quando a árvore está vazia.', 'Quando os valores foram inseridos em ordem crescente, formando uma estrutura em linha.', 'Quando o valor procurado é a raiz.', 'Quando a árvore tem exatamente três níveis.'], 1,
                'Inserir valores já ordenados leva todos para o mesmo lado. A altura passa a ser n e a busca precisa percorrer todos os nós no pior caso.'),
            'arvorebinaria-7' => self::codigo('arvorebinaria',
                'Em qual ordem os valores serão impressos?',
                $emOrdem . "\n\nArvoreBinaria arv = new ArvoreBinaria();\narv.inserir(20);\narv.inserir(27);\narv.inserir(10);\narv.inserir(51);\narv.inserir(21);\narv.emOrdem(arv.raiz);",
                ['20, 27, 10, 51, 21', '10, 20, 21, 27, 51', '20, 10, 27, 21, 51', '10, 21, 51, 27, 20'], 1,
                'O percurso em-ordem imprime os valores em ordem crescente: 10, 20, 21, 27, 51. A sequência 20, 10, 27, 21, 51 seria a pré-ordem.'),
            'arvorebinaria-8' => self::codigo('arvorebinaria',
                'Depois das inserções, em qual ordem o percurso em pré-ordem imprime os valores?',
                $preOrdem . "\n\nArvoreBinaria arv = new ArvoreBinaria();\nint[] valores = { 20, 27, 10, 51, 21, 7, 12 };\nforeach (int v in valores)\n{\n    arv.inserir(v);\n}\narv.preOrdem(arv.raiz);",
                ['20, 10, 7, 12, 27, 21, 51', '7, 10, 12, 20, 21, 27, 51', '7, 12, 10, 21, 51, 27, 20', '20, 27, 10, 51, 21, 7, 12'], 0,
                'A pré-ordem visita o nó antes das sub-árvores: raiz 20, sub-árvore esquerda (10, 7, 12) e sub-árvore direita (27, 21, 51).'),
            'arvorebinaria-9' => self::codigo('arvorebinaria',
                'O código conta os nós visitados ao procurar o valor 21. Que valor será impresso?',
                "// Árvore: 20 (esq 10, dir 27); 10 (esq 7, dir 12); 27 (esq 21, dir 51)\nint visitados = 0;\nNoArvore atual = arv.raiz;\n\nwhile (atual != null)\n{\n    visitados++;\n    if (21 == atual.valor) break;\n    atual = (21 < atual.valor) ? atual.esq : atual.dir;\n}\nConsole.WriteLine(visitados);",
                ['1', '3', '5', '7'], 1,
                'O caminho é 20 (21 > 20, vai à direita), 27 (21 < 27, vai à esquerda) e 21 (encontrado). Foram visitados 3 nós.'),
            'arvorebinaria-10' => self::codigo('arvorebinaria',
                'Os valores 1, 2, 3, 4 e 5 são inseridos nessa ordem. Que valor será impresso?',
                $alturaRec . "\n\nArvoreBinaria arv = new ArvoreBinaria();\nfor (int i = 1; i <= 5; i++)\n{\n    arv.inserir(i);\n}\nConsole.WriteLine(arv.altura());",
                ['3', '4', '5', '1'], 2,
                'Cada valor é maior que todos os anteriores e vai para a direita do último nó. A árvore vira uma linha de 5 níveis, então a altura é 5.'),
            'arvorebinaria-11' => self::codigo('arvorebinaria',
                'O que será impresso após as três inserções?',
                $inserirRec . "\n\nArvoreBinaria arv = new ArvoreBinaria();\narv.inserir(10);\narv.inserir(5);\narv.inserir(10);\narv.emOrdem(arv.raiz);",
                ['5, 10, 10', '5, 10', '10, 5', '10, 10, 5'], 1,
                'Quando o valor é igual ao do nó, nenhuma das condições (< ou >) é verdadeira e nenhum nó é criado. O segundo 10 é ignorado, e o percurso imprime 5 e 10.'),
            'arvorebinaria-12' => self::codigo('arvorebinaria',
                'A árvore foi montada com 20, 27, 10, 51, 21, 7 e 12. Que valor será impresso após remover o 27?',
                $removerRec . "\n\narv.remover(27);\nConsole.WriteLine(arv.raiz.dir.valor);",
                ['21', '27', '51', '10'], 2,
                'O nó 27 tem dois filhos (21 e 51). O sucessor é o menor valor da sub-árvore direita, que é 51. O nó recebe o valor 51, e o filho direito da raiz passa a ser 51.')
        ];
    }

    private static function trie()
    {
        $localizar = <<<'CODE'
private NoTrie localizarNo(string texto)
{
    NoTrie noAtual = this.raiz;
    for (int i = 0; i < texto.Length; i++)
    {
        int indice = texto[i] - 'a';
        if (noAtual.filhos[indice] == null)
        {
            return (null);
        }
        noAtual = noAtual.filhos[indice];
    }
    return (noAtual);
}

public Boolean buscar(string palavra)
{
    NoTrie no = localizarNo(palavra);
    return (no != null && no.fimPalavra == true);
}

public Boolean iniciaCom(string prefixo)
{
    return (localizarNo(prefixo) != null);
}
CODE;
        $inserir = <<<'CODE'
public void inserir(string palavra)
{
    NoTrie noAtual = this.raiz;
    for (int i = 0; i < palavra.Length; i++)
    {
        int indice = palavra[i] - 'a';
        if (noAtual.filhos[indice] == null)
        {
            noAtual.filhos[indice] = new NoTrie();
        }
        noAtual = noAtual.filhos[indice];
    }
    noAtual.fimPalavra = true;
}
CODE;
        $imprimir = <<<'CODE'
private void imprimirRec(NoTrie no, string prefixo)
{
    if (no.fimPalavra == true)
    {
        Console.WriteLine(prefixo);
    }
    for (int i = 0; i < 26; i++)
    {
        if (no.filhos[i] != null)
        {
            imprimirRec(no.filhos[i], prefixo + (char)('a' + i));
        }
    }
}
CODE;
        $remover = <<<'CODE'
private Boolean removerRec(NoTrie no, string palavra, int nivel)
{
    if (nivel == palavra.Length)
    {
        if (no.fimPalavra == false) return (false);
        no.fimPalavra = false;
        return (semFilhos(no));
    }
    int indice = palavra[nivel] - 'a';
    NoTrie filho = no.filhos[indice];
    if (filho == null) return (false);

    if (removerRec(filho, palavra, nivel + 1) == true)
    {
        no.filhos[indice] = null;
        return (no.fimPalavra == false && semFilhos(no));
    }
    return (false);
}
CODE;
        $inserirSemMarca = <<<'CODE'
public void inserir(string palavra)
{
    NoTrie noAtual = this.raiz;
    for (int i = 0; i < palavra.Length; i++)
    {
        int indice = palavra[i] - 'a';
        if (noAtual.filhos[indice] == null)
        {
            noAtual.filhos[indice] = new NoTrie();
        }
        noAtual = noAtual.filhos[indice];
    }
    // a linha noAtual.fimPalavra = true; foi esquecida
}
CODE;

        return [
            'trie-1' => self::teoria('trie',
                'O que cada nó (exceto a raiz) representa em uma Árvore Trie?',
                ['A palavra inteira, para facilitar a ordenação.', 'Uma letra; o caminho da raiz até o nó forma um prefixo.', 'Um número que indica a posição da palavra na lista.', 'Dois valores: o menor à esquerda e o maior à direita.'], 1,
                'Na Trie, cada nó guarda uma letra. Percorrer os nós da raiz até um ponto forma um prefixo, e palavras com o mesmo início compartilham esse caminho.'),
            'trie-2' => self::teoria('trie',
                'Em uma Trie com as palavras amor e amora, por que é necessário marcar o fim de palavra?',
                ['Para diferenciar uma palavra inserida de um simples prefixo: amor é palavra e também prefixo de amora.', 'Para impedir que o nó tenha filhos.', 'Para ordenar as palavras em ordem alfabética.', 'Para reduzir a quantidade de nós.'], 0,
                'O caminho de amor existe porque amora foi inserida. Sem a marcação, não seria possível saber se amor também foi inserida ou se é apenas parte do caminho.'),
            'trie-3' => self::teoria('trie',
                'Uma Trie armazena milhares de palavras. Qual é o custo de buscar uma palavra de m letras?',
                ['O(n), em que n é a quantidade de palavras.', 'O(m), proporcional ao tamanho da palavra.', 'O(log n), em que n é a quantidade de palavras.', 'O(n²).'], 1,
                'A busca segue uma letra por nó, no máximo m passos, não importa quantas palavras estejam armazenadas.'),
            'trie-4' => self::teoria('trie',
                'Por que a Trie é adequada para implementar o autocompletar?',
                ['Porque o caminho do prefixo digitado leva ao ponto a partir do qual estão todas as palavras com esse início.', 'Porque guarda as palavras ordenadas por frequência de uso.', 'Porque cada nó guarda uma palavra inteira.', 'Porque a busca é sempre O(1).'], 0,
                'Depois de percorrer as letras do prefixo, basta listar as palavras abaixo daquele nó. Esse tipo de consulta é a operação mais natural da Trie.'),
            'trie-5' => self::teoria('trie',
                'Qual é uma desvantagem da Trie implementada com vetor de 26 posições em cada nó?',
                ['Não permite remover palavras.', 'Muitos nós mantêm posições nulas no vetor, o que gasta memória.', 'Só aceita palavras com até cinco letras.', 'A busca exige comparar a palavra com todas as outras.'], 1,
                'Cada nó reserva espaço para todas as letras, mesmo que use poucas delas. Em árvores grandes, isso pode desperdiçar bastante memória.'),
            'trie-6' => self::teoria('trie',
                'Em uma Trie com dados, amora, dente, amor e dentista, o que acontece ao remover amor?',
                ['Todos os nós de amor e amora são apagados.', 'O nó r deixa de ser fim de palavra, mas permanece, pois ainda faz parte do caminho de amora.', 'A palavra amora também deixa de existir.', 'A raiz passa a ter um filho a menos.'], 1,
                'Remover amor apenas desmarca o fim de palavra do nó r. Como ele ainda tem o filho a, que leva a amora, nenhum nó pode ser descartado.'),
            'trie-7' => self::codigo('trie',
                'Qual valor será impresso?',
                "string palavra = \"bola\";\nint indice = palavra[0] - 'a';\nConsole.WriteLine(indice);",
                ['0', '1', '98', '2'], 1,
                'Os caracteres são números: b - a vale 1. É a posição da letra b no vetor de 26 filhos (a = 0, b = 1, ...).'),
            'trie-8' => self::codigo('trie',
                'Quantos nós a Trie possui, sem contar a raiz, após as inserções?',
                $inserir . "\n\nTrie t = new Trie();\nt.inserir(\"casa\");\nt.inserir(\"caso\");\nt.inserir(\"cama\");",
                ['3', '7', '12', '4'], 1,
                'casa cria 4 nós (c, a, s, a); caso reaproveita c, a e s e cria o; cama reaproveita c e a e cria m e a. Total: 4 + 1 + 2 = 7.'),
            'trie-9' => self::codigo('trie',
                'Depois de inserir apenas "amora", quais valores serão impressos?',
                $localizar . "\n\nt.inserir(\"amora\");\nConsole.WriteLine(t.buscar(\"amor\"));\nConsole.WriteLine(t.iniciaCom(\"amor\"));",
                ['True e True', 'False e True', 'True e False', 'False e False'], 1,
                'O caminho a-m-o-r existe, então iniciaCom retorna True. Mas o nó r não foi marcado como fim de palavra, então buscar("amor") retorna False.'),
            'trie-10' => self::codigo('trie',
                'Em que ordem as palavras serão impressas?',
                $imprimir . "\n\nt.inserir(\"dente\");\nt.inserir(\"dados\");\nt.inserir(\"amor\");\nt.imprimir(); // chama imprimirRec(raiz, \"\")",
                ['dente, dados, amor', 'amor, dados, dente', 'amor, dente, dados', 'dados, dente, amor'], 1,
                'Os filhos são visitados de a até z, então as palavras saem em ordem alfabética, independentemente da ordem de inserção: amor, dados, dente.'),
            'trie-11' => self::codigo('trie',
                'Considere que a Trie guarda amor e amora. Quais valores serão impressos?',
                $remover . "\n\nt.remover(\"amora\");\nConsole.WriteLine(t.buscar(\"amor\"));\nConsole.WriteLine(t.buscar(\"amora\"));",
                ['False e False', 'True e True', 'True e False', 'False e True'], 2,
                'A remoção desmarca o último a e o descarta. O nó r continua marcado como fim de palavra, então não é descartado: amor permanece e amora desaparece.'),
            'trie-12' => self::codigo('trie',
                'Considerando que buscar exige fimPalavra == true, qual será a saída?',
                $inserirSemMarca . "\n\nTrie t = new Trie();\nt.inserir(\"casa\");\nConsole.WriteLine(t.buscar(\"casa\"));",
                ['True', 'False', 'Uma exceção de índice', 'casa'], 1,
                'Todos os nós de casa foram criados, mas o último não foi marcado como fim de palavra. Para a busca, o caminho existe, mas a palavra não foi registrada.')
        ];
    }

    private static function patricia()
    {
        $prefixoComum = <<<'CODE'
private int prefixoComum(string a, string b)
{
    int i = 0;
    while (i < a.Length && i < b.Length && a[i] == b[i])
    {
        i++;
    }
    return (i);
}
CODE;
        $inserirRec = <<<'CODE'
private NoPatricia inserirRec(NoPatricia no, string palavra)
{
    if (no == null)
    {
        NoPatricia novo = new NoPatricia(palavra);
        novo.fimPalavra = true;
        return (novo);
    }

    int k = prefixoComum(no.fragmento, palavra);

    if (k == 0)
    {
        if (palavra[0] < no.fragmento[0])
        {
            NoPatricia novo = new NoPatricia(palavra);
            novo.fimPalavra = true;
            novo.prox = no;
            return (novo);
        }
        no.prox = inserirRec(no.prox, palavra);
        return (no);
    }

    if (k < no.fragmento.Length)
    {
        NoPatricia resto = new NoPatricia(no.fragmento.Substring(k));
        resto.fimPalavra = no.fimPalavra;
        resto.filho = no.filho;
        no.fragmento = no.fragmento.Substring(0, k);
        no.fimPalavra = false;
        no.filho = resto;
    }

    if (k == palavra.Length)
    {
        no.fimPalavra = true;
    }
    else
    {
        no.filho = inserirRec(no.filho, palavra.Substring(k));
    }
    return (no);
}
CODE;
        $buscar = <<<'CODE'
public Boolean buscar(string palavra)
{
    NoPatricia noAtual = this.raiz;
    while (noAtual != null)
    {
        int k = prefixoComum(noAtual.fragmento, palavra);

        if (k == 0)
        {
            noAtual = noAtual.prox;
        }
        else if (k < noAtual.fragmento.Length)
        {
            return (false);
        }
        else if (k == palavra.Length)
        {
            return (noAtual.fimPalavra);
        }
        else
        {
            palavra = palavra.Substring(k);
            noAtual = noAtual.filho;
        }
    }
    return (false);
}
CODE;
        $imprimir = <<<'CODE'
private void imprimirRec(NoPatricia no, string prefixo)
{
    while (no != null)
    {
        string atual = prefixo + no.fragmento;
        if (no.fimPalavra == true)
        {
            Console.WriteLine(atual);
        }
        imprimirRec(no.filho, atual);
        no = no.prox;
    }
}
CODE;

        return [
            'patricia-1' => self::teoria('patricia',
                'Qual é a principal diferença entre uma Árvore Trie e uma Árvore Patricia?',
                ['A Patricia só funciona com números.', 'A Trie guarda uma letra por nó; a Patricia guarda fragmentos da palavra.', 'A Patricia possui no máximo dois filhos por nó.', 'A Trie não permite buscar palavras.'], 1,
                'A Patricia atua como uma Trie compacta: em vez de uma letra por nó, cada nó guarda um trecho da palavra.'),
            'patricia-2' => self::teoria('patricia',
                'Por que a Patricia costuma usar menos nós do que a Trie para as mesmas palavras?',
                ['Porque descarta as letras repetidas das palavras.', 'Porque trechos sem ramificação são guardados juntos em um único nó.', 'Porque ordena as palavras por tamanho.', 'Porque não marca o fim das palavras.'], 1,
                'Na Trie, caminhos sem ramificação ocupam um nó por letra. Na Patricia, esses trechos viram um único fragmento, como ados ou ista.'),
            'patricia-3' => self::teoria('patricia',
                'Uma Patricia contém a palavra dados. Ao inserir dente, o que acontece com o nó dados?',
                ['Ele é apagado e substituído por dente.', 'Ele é dividido em d e ados, e ente passa a ser irmão de ados.', 'Ele passa a ser filho do nó dente.', 'Nada: dente vira o nó raiz da árvore.'], 1,
                'As palavras só compartilham o d. O nó é fragmentado em d (trecho comum) e ados (restante), e o restante de dente entra como novo nó no mesmo nível de ados.'),
            'patricia-4' => self::teoria('patricia',
                'Na Patricia desta aula, o que representa o ponteiro prox de um nó?',
                ['O nó que continua a palavra, um nível abaixo.', 'O próximo irmão, no mesmo nível, que começa com outra letra.', 'O nó pai.', 'O último nó da palavra.'], 1,
                'O ponteiro filho desce um nível, continuando a palavra. O ponteiro prox leva ao irmão do mesmo nível, uma alternativa que começa por outra letra.'),
            'patricia-5' => self::teoria('patricia',
                'Na remoção de uma palavra da Patricia, quando ocorre a fusão de nós?',
                ['Quando o nó removido era a raiz.', 'Quando um nó que não é fim de palavra fica com um único filho.', 'Quando duas palavras têm o mesmo tamanho.', 'Sempre que uma palavra é inserida.'], 1,
                'Um nó que não é fim de palavra e tem um só filho não precisa existir separado: os dois fragmentos são unidos, mantendo a árvore compacta.'),
            'patricia-6' => self::teoria('patricia',
                'Na Patricia com dente e dentista existe o caminho d → ent, mas a busca por dent retorna falso. Por quê?',
                ['Porque dent é maior que dente.', 'Porque o nó d tem dois filhos.', 'Porque o nó ent não está marcado como fim de palavra.', 'Porque a busca só aceita palavras com mais de cinco letras.'], 2,
                'O nó ent existe apenas como trecho em comum de dente e dentista. Como dent não foi inserida, o nó não é fim de palavra e a busca retorna falso.'),
            'patricia-7' => self::codigo('patricia',
                'Qual valor será impresso?',
                $prefixoComum . "\n\nConsole.WriteLine(prefixoComum(\"dentista\", \"dente\"));",
                ['5', '4', '3', '8'], 1,
                'As palavras coincidem em d, e, n e t. A quinta letra difere (i em dentista, e em dente), então o prefixo comum tem 4 letras.'),
            'patricia-8' => self::codigo('patricia',
                'Quais textos serão impressos, nesta ordem?',
                $inserirRec . "\n\nPatricia arv = new Patricia();\narv.inserir(\"dados\");\narv.inserir(\"dente\");\nConsole.WriteLine(arv.raiz.fragmento);\nConsole.WriteLine(arv.raiz.filho.fragmento);",
                ['dados e dente', 'd e ados', 'd e ente', 'dente e dados'], 1,
                'Ao inserir dente, o prefixo comum com dados é d (k = 1). O nó dados é dividido: a raiz passa a guardar d, e o restante, ados, vira seu filho.'),
            'patricia-9' => self::codigo('patricia',
                'A árvore tem o nó dent (não é fim de palavra), cujo filho é e (fim de palavra), e ista (fim de palavra) como próximo irmão de e. Quais valores serão impressos?',
                $buscar . "\n\nConsole.WriteLine(arv.buscar(\"dent\"));\nConsole.WriteLine(arv.buscar(\"dente\"));\nConsole.WriteLine(arv.buscar(\"dentista\"));",
                ['True, True, True', 'False, True, True', 'False, False, True', 'False, True, False'], 1,
                'dent termina em um nó que não é fim de palavra (False). dente passa por dent e termina em e (True). dentista passa por dent, não coincide com e, segue para o irmão ista e termina nele (True).'),
            'patricia-10' => self::codigo('patricia',
                'Quais textos serão impressos, nesta ordem?',
                $inserirRec . "\n\nPatricia arv = new Patricia();\narv.inserir(\"amora\");\narv.inserir(\"amor\");\nConsole.WriteLine(arv.raiz.fragmento);\nConsole.WriteLine(arv.raiz.fimPalavra);\nConsole.WriteLine(arv.raiz.filho.fragmento);",
                ['amora, True, a', 'amor, True, a', 'amor, False, a', 'amor, True, ra'], 1,
                'O prefixo comum de amora e amor é amor (k = 4, o tamanho de amor). O nó amora é dividido em amor e a, e como a palavra amor termina ali, o nó amor é marcado como fim de palavra.'),
            'patricia-11' => self::codigo('patricia',
                'Depois da execução, qual é o fragmento do nó e o valor de fimPalavra?',
                "NoPatricia no = new NoPatricia(\"ent\");\nNoPatricia ista = new NoPatricia(\"ista\");\nista.fimPalavra = true;\nno.filho = ista;\n\nif (no.fimPalavra == false && no.filho != null && no.filho.prox == null)\n{\n    no.fragmento = no.fragmento + no.filho.fragmento;\n    no.fimPalavra = no.filho.fimPalavra;\n    no.filho = no.filho.filho;\n}\nConsole.WriteLine(no.fragmento);\nConsole.WriteLine(no.fimPalavra);",
                ['ent e False', 'entista e True', 'entista e False', 'ista e True'], 1,
                'ent não é fim de palavra e tem um único filho, então ocorre a fusão: o fragmento vira entista e o nó herda o fimPalavra do filho, que é True.'),
            'patricia-12' => self::codigo('patricia',
                'Quais textos serão impressos, nesta ordem?',
                $imprimir . "\n\nNoPatricia amor = new NoPatricia(\"amor\");\namor.fimPalavra = true;\nNoPatricia a = new NoPatricia(\"a\");\na.fimPalavra = true;\namor.filho = a;\n\nNoPatricia d = new NoPatricia(\"d\");\nNoPatricia ados = new NoPatricia(\"ados\");\nados.fimPalavra = true;\nd.filho = ados;\namor.prox = d;\n\nimprimirRec(amor, \"\");",
                ['amor, a, ados', 'amor, amora, dados', 'a, amor, ados', 'amora, amor, dados'], 1,
                'O percurso concatena os fragmentos do caminho: amor (fim de palavra), amor + a = amora (fim de palavra) e, pelo irmão, d + ados = dados (fim de palavra). O nó d sozinho não é impresso.')
        ];
    }
}