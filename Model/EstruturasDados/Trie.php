<?php

class Trie
{
    public function obterConteudo()
    {
        return [
            "titulo" => "Árvore Trie (Árvore de Prefixos)",

            "introducao" => "Uma Trie é uma árvore não balanceada especializada em armazenar palavras. Em vez de guardar a palavra inteira em um nó, cada nó representa uma letra, e o caminho da raiz até um nó forma um prefixo. Por isso, palavras que começam igual compartilham o mesmo caminho.",

            "objetivos" => [
                "Entender o que é uma Trie e por que ela também é chamada de árvore de prefixos.",
                "Reconhecer a estrutura de um nó da Trie: filhos por letra e marcador de fim de palavra.",
                "Acompanhar passo a passo a inserção, a busca e a remoção de palavras.",
                "Compreender por que o custo das operações depende do tamanho da palavra e não da quantidade de palavras armazenadas.",
                "Comparar a Trie com a Árvore Binária de Busca.",
                "Visualizar exemplos implementados em C#."
            ],

            "definicao" => "Uma Trie (do inglês retrieval, recuperação) é uma Estrutura de Dados em árvore, não linear e não balanceada, usada para armazenar um conjunto de palavras (chaves). O nó raiz não guarda letra alguma. Cada ramo que sai de um nó corresponde a uma letra, e percorrer os ramos da raiz até um nó forma um prefixo. Um nó especial, marcado como fim de palavra, indica que o caminho percorrido até ali forma uma palavra completa que foi inserida. Diferente da Árvore Binária, em que cada nó tem no máximo dois filhos e é comparado por valor, na Trie cada nó pode ter um filho para cada letra do alfabeto, e a posição é definida pela própria letra.",

            "contexto" => [
                "Quando você digita as primeiras letras de uma palavra no celular e o teclado sugere o restante, ele precisa encontrar rapidamente todas as palavras que começam com aquele prefixo. A Trie foi pensada exatamente para esse tipo de consulta.",
                "Considere as palavras casa, caso, cama e bola. As três primeiras começam com \"ca\". Na Trie, o caminho c → a é armazenado uma única vez e só depois se ramifica em s e m. Já bola segue por um caminho totalmente separado, a partir da raiz.",
                "Essa economia de caminhos repetidos é a ideia central: quanto mais prefixos em comum as palavras tiverem, mais a estrutura reaproveita nós."
            ],

            "representacao" => '<svg viewBox="0 0 760 334" role="img" aria-labelledby="trie-svg-titulo" class="trie-svg" xmlns="http://www.w3.org/2000/svg">'
                . '<title id="trie-svg-titulo">Trie com as palavras casa, caso, cama e bola</title>'
                . '<g stroke="#b9ccd3" stroke-width="2" fill="none">'
                . '<line x1="380" y1="48" x2="240" y2="92"/><line x1="380" y1="48" x2="580" y2="92"/>'
                . '<line x1="240" y1="116" x2="240" y2="152"/><line x1="580" y1="116" x2="580" y2="152"/>'
                . '<line x1="240" y1="176" x2="180" y2="212"/><line x1="240" y1="176" x2="300" y2="212"/><line x1="580" y1="176" x2="580" y2="212"/>'
                . '<line x1="180" y1="236" x2="140" y2="270"/><line x1="180" y1="236" x2="220" y2="270"/><line x1="300" y1="236" x2="300" y2="270"/><line x1="580" y1="236" x2="580" y2="270"/>'
                . '</g>'
                . '<g font-family="Segoe UI, Arial, sans-serif" font-size="20" font-weight="700" text-anchor="middle">'
                . '<circle cx="380" cy="30" r="20" fill="#f7fafc" stroke="#b9ccd3" stroke-width="2"/><text x="380" y="37" fill="#526779" font-size="14">raiz</text>'
                . '<circle cx="240" cy="104" r="18" fill="#fff" stroke="#123554" stroke-width="2"/><text x="240" y="111" fill="#123554">c</text>'
                . '<circle cx="580" cy="104" r="18" fill="#fff" stroke="#123554" stroke-width="2"/><text x="580" y="111" fill="#123554">b</text>'
                . '<circle cx="240" cy="164" r="18" fill="#fff" stroke="#123554" stroke-width="2"/><text x="240" y="171" fill="#123554">a</text>'
                . '<circle cx="580" cy="164" r="18" fill="#fff" stroke="#123554" stroke-width="2"/><text x="580" y="171" fill="#123554">o</text>'
                . '<circle cx="180" cy="224" r="18" fill="#fff" stroke="#123554" stroke-width="2"/><text x="180" y="231" fill="#123554">s</text>'
                . '<circle cx="300" cy="224" r="18" fill="#fff" stroke="#123554" stroke-width="2"/><text x="300" y="231" fill="#123554">m</text>'
                . '<circle cx="580" cy="224" r="18" fill="#fff" stroke="#123554" stroke-width="2"/><text x="580" y="231" fill="#123554">l</text>'
                . '<circle cx="140" cy="284" r="18" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="140" y="291" fill="#0f766e">a</text>'
                . '<circle cx="220" cy="284" r="18" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="220" y="291" fill="#0f766e">o</text>'
                . '<circle cx="300" cy="284" r="18" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="300" y="291" fill="#0f766e">a</text>'
                . '<circle cx="580" cy="284" r="18" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="580" y="291" fill="#0f766e">a</text>'
                . '</g>'
                . '<g font-family="Segoe UI, Arial, sans-serif" font-size="14" fill="#526779" text-anchor="middle">'
                . '<text x="140" y="322">casa</text><text x="220" y="322">caso</text><text x="300" y="322">cama</text><text x="580" y="322">bola</text>'
                . '</g>'
                . '</svg>',

            "legendaRepresentacao" => "Trie com as palavras casa, caso, cama e bola. Os nós com contorno verde são fins de palavra; o caminho c → a é compartilhado.",

            "anatomia" => [
                [
                    "termo" => "Raiz",
                    "explicacao" => "Nó inicial da Trie. Ele não guarda nenhuma letra: serve apenas como ponto de partida para todas as palavras."
                ],
                [
                    "termo" => "Nó",
                    "explicacao" => "Cada nó representa uma letra do caminho. Ele guarda um conjunto de referências para os filhos (uma posição para cada letra do alfabeto) e um indicador de fim de palavra."
                ],
                [
                    "termo" => "Filhos",
                    "explicacao" => "Vetor de referências, uma por letra. Para o alfabeto de a até z, o vetor tem 26 posições: a posição 0 é a letra a, a posição 1 é a letra b, e assim por diante. Posição nula significa que aquela letra não segue a partir do prefixo atual."
                ],
                [
                    "termo" => "Fim de palavra",
                    "explicacao" => "Indicador booleano que marca os nós onde uma palavra inserida termina. Sem ele não seria possível diferenciar a palavra \"cas\" de apenas o prefixo de \"casa\"."
                ],
                [
                    "termo" => "Prefixo",
                    "explicacao" => "Sequência de letras percorrida desde a raiz até um nó. Todas as palavras abaixo desse nó começam por aquele prefixo."
                ],
                [
                    "termo" => "Folha",
                    "explicacao" => "Nó sem nenhum filho. Em uma Trie sem remoções incompletas, toda folha é um fim de palavra."
                ]
            ],

            "comoFunciona" => [
                "A Trie começa apenas com a raiz, sem nenhum filho.",
                "Para inserir uma palavra, percorre-se suas letras uma a uma, descendo pelos ramos correspondentes e criando os nós que ainda não existirem.",
                "Ao terminar as letras, o último nó é marcado como fim de palavra.",
                "Para buscar, percorre-se o mesmo caminho: se alguma letra não tiver ramo, a palavra não existe; se o caminho existir inteiro, a palavra só existe de fato se o último nó estiver marcado como fim de palavra.",
                "Para buscar por prefixo, basta percorrer o caminho do prefixo: se ele existir, há palavras com esse início, mesmo que o último nó não seja um fim de palavra."
            ],

            "importancia" => "A Trie é importante porque o tempo das operações depende apenas do tamanho da palavra, e não de quantas palavras já foram armazenadas. Além disso, ela resolve de forma natural consultas por prefixo e entrega as palavras em ordem alfabética quando percorrida em profundidade.",

            "aplicacoes" => [
                "Autocompletar em teclados de celular, barras de busca e editores de código.",
                "Corretores ortográficos e dicionários, que precisam verificar rapidamente se uma palavra existe.",
                "Roteamento de redes, em que prefixos de endereços IP são comparados.",
                "Listas de contatos e sistemas de busca por nomes que começam com certas letras."
            ],

            "operacoes" => [
                [
                    "nome" => "Inserção",
                    "descricao" => "Percorre as letras da palavra criando os nós que faltam e marca o último como fim de palavra.",
                    "complexidade" => "O(m)"
                ],
                [
                    "nome" => "Busca de palavra",
                    "descricao" => "Segue o caminho das letras a partir da raiz e confere se o último nó é um fim de palavra.",
                    "complexidade" => "O(m)"
                ],
                [
                    "nome" => "Busca por prefixo",
                    "descricao" => "Segue o caminho das letras do prefixo; se ele existir por completo, há palavras com esse início.",
                    "complexidade" => "O(m)"
                ],
                [
                    "nome" => "Remoção",
                    "descricao" => "Desmarca o fim de palavra e descarta, de baixo para cima, os nós que deixaram de ser necessários.",
                    "complexidade" => "O(m)"
                ],
                [
                    "nome" => "Percurso",
                    "descricao" => "Visita todos os nós em profundidade, de forma recursiva, listando as palavras em ordem alfabética.",
                    "complexidade" => "O(n)"
                ]
            ],

            "complexidadeNota" => "Na tabela, m é o número de letras da palavra (ou do prefixo) e n é o número total de nós da Trie.",

            "insercoes" => [
                [
                    "titulo" => "Inserção de uma palavra",
                    "complexidade" => "O(m)",
                    "passos" => [
                        "Começar pela raiz, que será o nó atual.",
                        "Para cada letra da palavra, calcular a posição correspondente no vetor de filhos (letra a = 0, b = 1, ..., z = 25).",
                        "Se o filho daquela posição for nulo, criar um novo nó e ligá-lo ao nó atual.",
                        "Passar para o filho, que se torna o novo nó atual.",
                        "Após a última letra, marcar o nó atual como fim de palavra."
                    ]
                ],
                [
                    "titulo" => "Exemplo: inserir casa, caso e cama",
                    "complexidade" => "Visualização",
                    "passos" => [
                        "Inserir casa: a Trie está vazia, então são criados os nós c, a, s e a, e o último a é marcado como fim de palavra.",
                        "Inserir caso: os nós c, a e s já existem e são reaproveitados; apenas o nó o é criado e marcado como fim de palavra.",
                        "Inserir cama: os nós c e a já existem; é criado o nó m, que ramifica a partir do a, e depois o último a, marcado como fim de palavra.",
                        "Resultado: as três palavras compartilham o prefixo \"ca\", armazenado uma única vez."
                    ]
                ]
            ],

            "remocoes" => [
                [
                    "titulo" => "Remoção de uma palavra",
                    "passos" => [
                        "Percorrer o caminho da palavra a partir da raiz; se alguma letra não existir, a palavra não está na Trie e não há o que remover.",
                        "Se o último nó não for fim de palavra, a palavra também não existe (era apenas um prefixo de outra) e nada é removido.",
                        "Desmarcar o último nó como fim de palavra.",
                        "Voltando de baixo para cima, descartar cada nó que ficou sem filhos e que não seja fim de outra palavra.",
                        "Parar de descartar assim que encontrar um nó que ainda é útil, ou seja, que tem outros filhos ou é fim de outra palavra."
                    ]
                ]
            ],

            "buscaPercurso" => [
                [
                    "titulo" => "Busca de palavra e de prefixo",
                    "descricao" => "As duas começam pela raiz e seguem as letras uma a uma. A busca de palavra exige que o último nó seja fim de palavra; a busca por prefixo só exige que o caminho exista.",
                    "complexidade" => "O(m)"
                ],
                [
                    "titulo" => "Percurso",
                    "descricao" => "Percorre a Trie de forma recursiva, acumulando as letras do caminho. Sempre que encontra um fim de palavra, exibe o prefixo acumulado. Como os filhos são visitados na ordem do alfabeto, as palavras saem ordenadas.",
                    "complexidade" => "O(n)"
                ]
            ],

            "comparacao" => [
                [
                    "criterio" => "Informação guardada no nó",
                    "simples" => "Árvore Binária: o valor completo (chave)",
                    "dupla" => "Trie: uma letra do caminho"
                ],
                [
                    "criterio" => "Número de filhos por nó",
                    "simples" => "Árvore Binária: no máximo 2 (esquerda e direita)",
                    "dupla" => "Trie: um para cada letra do alfabeto (26 no exemplo)"
                ],
                [
                    "criterio" => "Como se decide o caminho",
                    "simples" => "Árvore Binária: comparando a chave com o valor do nó",
                    "dupla" => "Trie: pela própria letra, sem comparações entre chaves"
                ],
                [
                    "criterio" => "Custo da busca",
                    "simples" => "Árvore Binária: depende da altura (varia com a quantidade de elementos)",
                    "dupla" => "Trie: O(m), depende só do tamanho da palavra"
                ],
                [
                    "criterio" => "Busca por prefixo",
                    "simples" => "Árvore Binária: não é natural",
                    "dupla" => "Trie: é a operação mais natural da estrutura"
                ],
                [
                    "criterio" => "Uso de memória",
                    "simples" => "Árvore Binária: 2 referências por nó",
                    "dupla" => "Trie: um vetor de referências por nó, que pode desperdiçar espaço"
                ]
            ],

            "orientacaoCodigo" => "Os exemplos usam um vetor de 26 posições para os filhos e supõem palavras apenas com letras minúsculas de a até z. A posição de cada letra é obtida por palavra[i] - 'a'. Os métodos ficam dentro das classes NoTrie e Trie.",

            "exemplos" => [
                [
                    "titulo" => "Exemplo 1 - Classe NoTrie",
                    "descricao" => "Cada nó guarda o vetor de filhos (um por letra) e o indicador de fim de palavra.",
                    "codigo" => <<<'CSHARP'
public class NoTrie
{
    public NoTrie[] filhos;
    public Boolean fimPalavra;

    public NoTrie()
    {
        this.filhos = new NoTrie[26];
        this.fimPalavra = false;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 2 - Classe Trie e verificação de árvore vazia",
                    "descricao" => "A Trie mantém apenas a referência para a raiz, que é criada junto com a árvore e não guarda letra.",
                    "codigo" => <<<'CSHARP'
public class Trie
{
    public NoTrie raiz;

    public Trie()
    {
        this.raiz = new NoTrie();
    }

    public Boolean estaVazia()
    {
        for (int i = 0; i < 26; i++)
        {
            if (this.raiz.filhos[i] != null)
            {
                return (false);
            }
        }
        return (true);
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 3 - Inserção",
                    "descricao" => "Percorre as letras criando os nós que ainda não existem e marca o último nó como fim de palavra.",
                    "codigo" => <<<'CSHARP'
public void inserir(string palavra)
{
    NoTrie noAtual = this.raiz;

    for (int i = 0; i < palavra.Length; i++)
    {
        int indice = palavra[i] - 'a';

        if (noAtual.filhos[indice] == null)
        { // O CAMINHO AINDA NAO EXISTE, CRIA O NO
            noAtual.filhos[indice] = new NoTrie();
        }
        noAtual = noAtual.filhos[indice];
    }

    noAtual.fimPalavra = true;
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 4 - Busca de palavra e de prefixo",
                    "descricao" => "O método auxiliar localizarNo segue o caminho das letras e devolve o último nó (ou null). A busca de palavra confere o fim de palavra; a de prefixo só confere se o caminho existe.",
                    "codigo" => <<<'CSHARP'
private NoTrie localizarNo(string texto)
{
    NoTrie noAtual = this.raiz;

    for (int i = 0; i < texto.Length; i++)
    {
        int indice = texto[i] - 'a';

        if (noAtual.filhos[indice] == null)
        { // A LETRA NAO TEM RAMO, ENTAO O CAMINHO NAO EXISTE
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
CSHARP
                ],
                [
                    "titulo" => "Exemplo 5 - Remoção",
                    "descricao" => "A remoção é recursiva: desmarca o fim de palavra e, na volta da recursão, descarta os nós que ficaram sem utilidade.",
                    "codigo" => <<<'CSHARP'
private Boolean semFilhos(NoTrie no)
{
    for (int i = 0; i < 26; i++)
    {
        if (no.filhos[i] != null)
        {
            return (false);
        }
    }
    return (true);
}

// RETORNA TRUE QUANDO O NO PODE SER DESCARTADO PELO PAI
private Boolean removerRec(NoTrie no, string palavra, int nivel)
{
    if (nivel == palavra.Length)
    {
        if (no.fimPalavra == false)
        { // A PALAVRA NAO EXISTE (ERA SO UM PREFIXO)
            return (false);
        }
        no.fimPalavra = false;
        return (semFilhos(no));
    }

    int indice = palavra[nivel] - 'a';
    NoTrie filho = no.filhos[indice];

    if (filho == null)
    { // A PALAVRA NAO EXISTE
        return (false);
    }

    if (removerRec(filho, palavra, nivel + 1) == true)
    {
        no.filhos[indice] = null;
        return (no.fimPalavra == false && semFilhos(no));
    }
    return (false);
}

public void remover(string palavra)
{
    removerRec(this.raiz, palavra, 0);
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 6 - Percurso (Imprimir)",
                    "descricao" => "O percurso acumula as letras do caminho e imprime o prefixo sempre que chega a um fim de palavra. As palavras saem em ordem alfabética.",
                    "codigo" => <<<'CSHARP'
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

public void imprimir()
{
    Console.WriteLine("Palavras: ");
    imprimirRec(this.raiz, "");
}
CSHARP
                ]
            ],

            "exercicios" => [
                "Desenhe uma Trie vazia e insira, em ordem, as palavras: rato, rata, rua, bola e bolo. Mostre o estado final e marque os nós de fim de palavra.",
                "No exercício anterior, quantos nós (sem contar a raiz) a Trie possui? Compare com a quantidade total de letras das cinco palavras e explique a diferença.",
                "Na Trie do primeiro exercício, a busca por \"ru\" como palavra retorna verdadeiro ou falso? E a busca de \"ru\" como prefixo? Justifique.",
                "Remova a palavra \"rata\" da Trie e indique quais nós são descartados e quais permanecem. Em seguida remova \"rato\" e repita a análise.",
                "Explique, com suas palavras, por que o custo da busca em uma Trie não aumenta quando mais palavras são inseridas, enquanto na Árvore Binária a altura pode crescer.",
                "Qual é o principal ponto fraco de uma Trie em relação ao uso de memória? Cite uma situação em que isso incomodaria.",
                "Compare a Trie com a Árvore Binária estudada anteriormente, indicando em que tipo de problema cada uma é mais adequada."
            ]
        ];
    }
}

?>