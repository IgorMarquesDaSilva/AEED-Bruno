<?php

class Patricia
{
    public function obterConteudo()
    {
        return [
            "titulo" => "Árvore Patricia (Trie Compacta)",

            "introducao" => "A Árvore Patricia é uma Trie compacta. Enquanto a Trie guarda uma letra por nó, a Patricia guarda fragmentos da palavra: trechos que só se separam quando as palavras deixam de ter o mesmo início. O resultado é uma árvore com muito menos nós para armazenar as mesmas palavras.",

            "objetivos" => [
                "Entender o que é uma Árvore Patricia e como ela se relaciona com a Trie.",
                "Compreender por que guardar fragmentos em vez de letras reduz a quantidade de nós.",
                "Reconhecer a estrutura do nó: fragmento, fim de palavra, filho e próximo irmão.",
                "Acompanhar a inserção, entendendo quando um nó precisa ser dividido (fragmentado).",
                "Acompanhar a busca e a remoção, incluindo a fusão de nós ao compactar novamente.",
                "Comparar Trie e Patricia com um mesmo conjunto de palavras.",
                "Visualizar exemplos implementados em C#."
            ],

            "definicao" => "Uma Árvore Patricia é uma Estrutura de Dados em árvore, não linear e não balanceada, que atua como uma Árvore Trie compacta. Cada nó guarda um fragmento da palavra (uma ou mais letras) e um indicador de fim de palavra. Os nós seguem uma organização em que cada um possui dois ponteiros: um para o filho (o primeiro nó do nível abaixo, que continua a palavra) e outro para o próximo irmão (o nó seguinte no mesmo nível, que representa uma alternativa). Os irmãos ficam em ordem alfabética. Sempre que uma nova palavra compartilha apenas parte do fragmento de um nó, esse nó é dividido em dois: o trecho em comum e o restante. Observação: a Patricia original, proposta em 1968, trabalha com bits das chaves; aqui adotamos a versão estudada em aula, que opera sobre caracteres.",

            "contexto" => [
                "Na Trie, a palavra dentista ocuparia oito nós em um caminho de uma letra por nó, mesmo quando não há nenhuma ramificação pelo caminho. Muitos desses nós só têm um filho e servem apenas para passar adiante.",
                "A Patricia elimina esses nós de passagem. Trechos sem ramificação são guardados juntos em um único nó, como ados ou ista.",
                "Nada se perde: para reconstruir uma palavra, basta concatenar os fragmentos do caminho. Por exemplo, d + ent + ista forma dentista."
            ],

            "representacao" => '<svg viewBox="0 0 760 300" role="img" aria-labelledby="pat-svg-titulo" class="arvore-svg" xmlns="http://www.w3.org/2000/svg"><title id="pat-svg-titulo">Árvore Patricia com as palavras dados, amora, dente, amor e dentista</title><g font-family="Segoe UI, Arial, sans-serif" font-size="18" font-weight="700" text-anchor="middle"><text x="80" y="22" fill="#526779" font-size="14">raiz</text><line x1="80" y1="28" x2="80" y2="35" stroke="#b42318" stroke-width="3"/><polygon points="80,44 74,33 86,33" fill="#b42318"/><rect x="40" y="44" width="80" height="36" rx="7" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="80.0" y="68.0" fill="#0f766e">amor</text><rect x="200" y="44" width="40" height="36" rx="7" fill="#ffffff" stroke="#123554" stroke-width="2"/><text x="220.0" y="68.0" fill="#123554">d</text><line x1="120" y1="62" x2="191" y2="62" stroke="#2563eb" stroke-width="3"/><polygon points="200,62 189,56 189,68" fill="#2563eb"/><rect x="60" y="124" width="40" height="36" rx="7" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="80.0" y="148.0" fill="#0f766e">a</text><line x1="80" y1="80" x2="80" y2="115" stroke="#b42318" stroke-width="3"/><polygon points="80,124 74,113 86,113" fill="#b42318"/><rect x="200" y="124" width="80" height="36" rx="7" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="240.0" y="148.0" fill="#0f766e">ados</text><line x1="220" y1="80" x2="220" y2="115" stroke="#b42318" stroke-width="3"/><polygon points="220,124 214,113 226,113" fill="#b42318"/><rect x="340" y="124" width="60" height="36" rx="7" fill="#ffffff" stroke="#123554" stroke-width="2"/><text x="370.0" y="148.0" fill="#123554">ent</text><line x1="280" y1="142" x2="331" y2="142" stroke="#2563eb" stroke-width="3"/><polygon points="340,142 329,136 329,148" fill="#2563eb"/><rect x="320" y="204" width="40" height="36" rx="7" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="340.0" y="228.0" fill="#0f766e">e</text><line x1="350" y1="160" x2="350" y2="195" stroke="#b42318" stroke-width="3"/><polygon points="350,204 344,193 356,193" fill="#b42318"/><rect x="440" y="204" width="70" height="36" rx="7" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="475.0" y="228.0" fill="#0f766e">ista</text><line x1="360" y1="222" x2="431" y2="222" stroke="#2563eb" stroke-width="3"/><polygon points="440,222 429,216 429,228" fill="#2563eb"/></g><g font-family="Segoe UI, Arial, sans-serif" font-size="13" fill="#526779"><text x="540" y="64">Palavras inseridas:</text><text x="540" y="84">amor, amora, dados,</text><text x="540" y="102">dente e dentista</text><rect x="40" y="268" width="22" height="16" rx="4" fill="#e9f4f3" stroke="#0f766e" stroke-width="2"/><text x="70" y="281">fim de palavra</text><rect x="180" y="268" width="22" height="16" rx="4" fill="#fff" stroke="#123554" stroke-width="2"/><text x="210" y="281">não é fim de palavra</text><line x1="372" y1="276" x2="404" y2="276" stroke="#2563eb" stroke-width="3"/><text x="412" y="281">próximo (irmão)</text><line x1="540" y1="276" x2="572" y2="276" stroke="#b42318" stroke-width="3"/><text x="580" y="281">filho (desce um nível)</text></g></svg>',

            "legendaRepresentacao" => "Patricia após inserir dados, amora, dente, amor e dentista. A seta azul liga irmãos e a seta vermelha desce para o filho. A árvore tem 7 nós.",

            "anatomia" => [
                [
                    "termo" => "Fragmento",
                    "explicacao" => "Trecho da palavra guardado no nó: uma ou várias letras. É o que diferencia a Patricia da Trie, em que cada nó guarda uma única letra."
                ],
                [
                    "termo" => "Fim de palavra",
                    "explicacao" => "Indicador booleano que marca os nós em que uma palavra inserida termina. Na árvore do exemplo, amor, a, ados, e e ista são fins de palavra, enquanto d e ent são apenas caminho."
                ],
                [
                    "termo" => "Filho",
                    "explicacao" => "Referência para o primeiro nó do nível abaixo. Continua o caminho da palavra: quem está abaixo de d começa com d."
                ],
                [
                    "termo" => "Próximo (irmão)",
                    "explicacao" => "Referência para o nó seguinte no mesmo nível. Os irmãos começam por letras diferentes e ficam em ordem alfabética, como amor antes de d."
                ],
                [
                    "termo" => "Raiz",
                    "explicacao" => "Referência para o primeiro nó do primeiro nível. Quando a árvore está vazia, a raiz é nula."
                ],
                [
                    "termo" => "Divisão (fragmentação)",
                    "explicacao" => "Ocorre na inserção, quando a nova palavra coincide só com o início de um fragmento: o nó é dividido em um nó com o trecho em comum e um filho com o restante."
                ],
                [
                    "termo" => "Fusão",
                    "explicacao" => "Ocorre na remoção, quando um nó que não é fim de palavra fica com um único filho: os dois são unidos em um só, recompactando a árvore."
                ]
            ],

            "comoFunciona" => [
                "A árvore começa vazia, com a raiz nula.",
                "Para inserir, percorre-se o nível atual procurando um nó cujo fragmento comece com a mesma letra da palavra.",
                "Se nenhum nó coincide, a palavra inteira vira um novo nó, na posição alfabética entre os irmãos.",
                "Se um nó coincide por completo com o início da palavra, o que sobra da palavra continua no nível abaixo (filho).",
                "Se um nó coincide só em parte, ele é dividido no ponto em que as palavras se separam, e o restante da palavra entra como novo irmão.",
                "O nó em que a palavra termina é marcado como fim de palavra."
            ],

            "importancia" => "A Patricia mantém as vantagens da Trie, como busca por palavra em tempo proporcional ao tamanho dela e palavras em ordem alfabética, usando bem menos nós e ponteiros. Isso pesa quando há muitas palavras longas com poucos pontos de ramificação.",

            "diferencaTitulo" => "Trie x Patricia no mesmo exemplo",

            "diferencaTrie" => "Para armazenar dados, amora, dente, amor e dentista, a Trie precisa de 18 nós, um por letra distinta no caminho. A Patricia armazena as mesmas cinco palavras com apenas 7 nós (amor, a, d, ados, ent, e e ista). A diferença vem de guardar trechos sem ramificação em um único nó.",

            "aplicacoes" => [
                "Tabelas de roteamento de redes, que comparam prefixos de endereços.",
                "Índices de texto e dicionários grandes, com economia de memória.",
                "Autocompletar e busca por prefixo em grandes volumes de palavras.",
                "Sistemas de arquivos e estruturas de armazenamento chave-valor baseadas em prefixos."
            ],

            "operacoes" => [
                [
                    "nome" => "Inserção",
                    "descricao" => "Localiza o ponto de encaixe, dividindo um nó quando a palavra coincide apenas com parte do fragmento.",
                    "complexidade" => "O(m)"
                ],
                [
                    "nome" => "Busca de palavra",
                    "descricao" => "Compara os fragmentos ao longo do caminho; a palavra existe se o último nó coincide por completo e é fim de palavra.",
                    "complexidade" => "O(m)"
                ],
                [
                    "nome" => "Remoção",
                    "descricao" => "Desmarca o fim de palavra, descarta nós sem utilidade e funde nós quando sobra apenas um filho.",
                    "complexidade" => "O(m)"
                ],
                [
                    "nome" => "Percurso",
                    "descricao" => "Visita todos os nós de forma recursiva, concatenando os fragmentos e listando as palavras em ordem alfabética.",
                    "complexidade" => "O(n)"
                ]
            ],

            "complexidadeNota" => "Na tabela, m é o número de letras da palavra e n é o número de nós. A varredura dos irmãos em cada nível é limitada pelo tamanho do alfabeto, por isso ela não entra no custo.",

            "insercoes" => [
                [
                    "titulo" => "Inserção de uma palavra",
                    "complexidade" => "O(m)",
                    "passos" => [
                        "No nível atual, comparar a palavra com o fragmento de cada nó, calculando quantas letras iniciais são iguais.",
                        "Se nenhuma letra for igual e a palavra vier antes do nó em ordem alfabética, inserir um novo nó antes dele; se vier depois, seguir para o próximo irmão.",
                        "Se não houver mais irmãos, criar um novo nó com a palavra inteira como último irmão e marcá-lo como fim de palavra.",
                        "Se o trecho em comum for menor que o fragmento, dividir o nó: o trecho em comum permanece no nó e o restante vira o seu filho, herdando o fim de palavra e os filhos antigos.",
                        "Se a palavra terminou, marcar o nó como fim de palavra; senão, repetir o processo no nível abaixo com o que sobrou da palavra."
                    ]
                ],
                [
                    "titulo" => "Exemplo: inserir dados, amora, dente, amor e dentista",
                    "complexidade" => "Visualização",
                    "passos" => [
                        "dados: árvore vazia, então o nó dados se torna o primeiro nó e é marcado como fim de palavra.",
                        "amora: não tem letras em comum com dados e começa com a, que vem antes de d. O nó amora entra antes de dados, como seu irmão.",
                        "dente: coincide com dados na letra d. O nó dados é fragmentado em d e ados (fim de palavra). O restante, ente, entra como irmão de ados.",
                        "amor: coincide com amora em amor. O nó amora é fragmentado em amor e a (fim de palavra), e o nó amor é marcado como fim de palavra, pois a palavra termina ali.",
                        "dentista: passa por d, depois compara entista com os filhos de d. Coincide com ente em ent, então ente é fragmentado em ent e e (fim de palavra), e ista entra como irmão de e."
                    ]
                ]
            ],

            "remocoes" => [
                [
                    "titulo" => "Remoção de uma palavra",
                    "passos" => [
                        "Percorrer o caminho comparando fragmentos; se algum fragmento não coincidir por completo, a palavra não existe e nada é removido.",
                        "No nó em que a palavra termina, verificar se ele é fim de palavra; se não for, a palavra não existe (era só um prefixo de outra).",
                        "Desmarcar o nó como fim de palavra.",
                        "Se o nó ficou sem filhos e não é fim de palavra, descartá-lo, preservando seus irmãos.",
                        "Se o nó não é fim de palavra e ficou com um único filho, fundir os dois: concatenar os fragmentos e herdar o fim de palavra e os filhos do filho."
                    ]
                ],
                [
                    "titulo" => "Exemplo: remover dente da árvore da aula",
                    "passos" => [
                        "O caminho é d, depois ent, depois e. O nó e é fim de palavra e é desmarcado.",
                        "O nó e ficou sem filhos e sem marcação, então é descartado. O nó ent passa a ter apenas ista como filho.",
                        "Como ent não é fim de palavra e tem um único filho, ent e ista são fundidos no nó entista, que é fim de palavra."
                    ]
                ]
            ],

            "buscaPercurso" => [
                [
                    "titulo" => "Busca de palavra",
                    "descricao" => "Exemplo amor: o primeiro nó coincide por completo e é fim de palavra, então a palavra existe. Exemplo dentista: d coincide, ados não coincide e passa-se ao irmão ent, que coincide; e não coincide e passa-se ao irmão ista, que coincide e é fim de palavra.",
                    "complexidade" => "O(m)"
                ],
                [
                    "titulo" => "Percurso",
                    "descricao" => "Percorre cada nível pelos irmãos e desce pelos filhos, concatenando os fragmentos. Ao encontrar um fim de palavra, exibe o texto acumulado. Como os irmãos estão em ordem alfabética, as palavras saem ordenadas: amor, amora, dados, dente, dentista.",
                    "complexidade" => "O(n)"
                ]
            ],

            "comparacao" => [
                [
                    "criterio" => "O que o nó guarda",
                    "simples" => "Trie: uma letra",
                    "dupla" => "Patricia: um fragmento (uma ou mais letras)"
                ],
                [
                    "criterio" => "Nós no exemplo da aula",
                    "simples" => "Trie: 18 nós",
                    "dupla" => "Patricia: 7 nós"
                ],
                [
                    "criterio" => "Nós com um só filho",
                    "simples" => "Trie: comuns, formam longos caminhos",
                    "dupla" => "Patricia: evitados pela compactação"
                ],
                [
                    "criterio" => "Altura da árvore",
                    "simples" => "Trie: igual ao tamanho da maior palavra",
                    "dupla" => "Patricia: menor ou igual à da Trie"
                ],
                [
                    "criterio" => "Inserção",
                    "simples" => "Trie: cria os nós que faltam",
                    "dupla" => "Patricia: pode dividir um nó existente"
                ],
                [
                    "criterio" => "Remoção",
                    "simples" => "Trie: descarta nós sem uso",
                    "dupla" => "Patricia: descarta e funde nós"
                ],
                [
                    "criterio" => "Complexidade da busca",
                    "simples" => "Trie: O(m)",
                    "dupla" => "Patricia: O(m)"
                ]
            ],

            "orientacaoCodigo" => "Os exemplos usam o mesmo modelo dos slides: cada nó tem o fragmento, o indicador de fim de palavra, o ponteiro filho (desce um nível) e o ponteiro prox (próximo irmão). As palavras são tratadas em letras minúsculas. O método auxiliar prefixoComum devolve quantas letras iniciais duas cadeias têm em comum. Os métodos ficam dentro das classes NoPatricia e Patricia.",

            "exemplos" => [
                [
                    "titulo" => "Exemplo 1 - Classe NoPatricia",
                    "descricao" => "Cada nó guarda um fragmento, o indicador de fim de palavra, o ponteiro filho e o ponteiro prox para o próximo irmão.",
                    "codigo" => <<<'CSHARP'
public class NoPatricia
{
    public string fragmento;
    public Boolean fimPalavra;
    public NoPatricia filho;
    public NoPatricia prox;

    public NoPatricia(string Fragmento)
    {
        this.fragmento = Fragmento;
        this.fimPalavra = false;
        this.filho = null;
        this.prox = null;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 2 - Classe Patricia, árvore vazia e prefixo comum",
                    "descricao" => "A árvore guarda apenas a raiz, que é o primeiro nó do primeiro nível. O método prefixoComum conta quantas letras iniciais duas cadeias compartilham.",
                    "codigo" => <<<'CSHARP'
public class Patricia
{
    public NoPatricia raiz;

    public Patricia()
    {
        this.raiz = null;
    }

    public Boolean estaVazia()
    {
        if (this.raiz == null)
        {
            return (true);
        }
        return (false);
    }

    private int prefixoComum(string a, string b)
    {
        int i = 0;

        while (i < a.Length && i < b.Length && a[i] == b[i])
        {
            i++;
        }
        return (i);
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 3 - Inserção",
                    "descricao" => "Trata os casos: nível vazio, nenhuma letra em comum (mantendo a ordem alfabética dos irmãos), divisão do nó e continuação no nível abaixo.",
                    "codigo" => <<<'CSHARP'
private NoPatricia inserirRec(NoPatricia no, string palavra)
{
    if (no == null)
    { // FIM DO NIVEL, A PALAVRA INTEIRA VIRA UM NOVO NO
        NoPatricia novo = new NoPatricia(palavra);
        novo.fimPalavra = true;
        return (novo);
    }

    int k = prefixoComum(no.fragmento, palavra);

    if (k == 0)
    { // NENHUMA LETRA EM COMUM
        if (palavra[0] < no.fragmento[0])
        { // VEM ANTES, ENTRA ANTES DESTE IRMAO
            NoPatricia novo = new NoPatricia(palavra);
            novo.fimPalavra = true;
            novo.prox = no;
            return (novo);
        }
        no.prox = inserirRec(no.prox, palavra);
        return (no);
    }

    if (k < no.fragmento.Length)
    { // COINCIDE SO COM O INICIO: DIVIDE O NO
        NoPatricia resto = new NoPatricia(no.fragmento.Substring(k));
        resto.fimPalavra = no.fimPalavra;
        resto.filho = no.filho;

        no.fragmento = no.fragmento.Substring(0, k);
        no.fimPalavra = false;
        no.filho = resto;
    }

    if (k == palavra.Length)
    { // A PALAVRA TERMINA NESTE NO
        no.fimPalavra = true;
    }
    else
    { // O QUE SOBROU DA PALAVRA CONTINUA NO NIVEL ABAIXO
        no.filho = inserirRec(no.filho, palavra.Substring(k));
    }
    return (no);
}

public void inserir(string palavra)
{
    this.raiz = inserirRec(this.raiz, palavra);
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 4 - Busca",
                    "descricao" => "Percorre os irmãos do nível e desce quando o fragmento coincide por completo. Se o fragmento coincidir só em parte, a palavra não existe.",
                    "codigo" => <<<'CSHARP'
public Boolean buscar(string palavra)
{
    NoPatricia noAtual = this.raiz;

    while (noAtual != null)
    {
        int k = prefixoComum(noAtual.fragmento, palavra);

        if (k == 0)
        { // NAO COINCIDE, TENTA O PROXIMO IRMAO
            noAtual = noAtual.prox;
        }
        else if (k < noAtual.fragmento.Length)
        { // COINCIDE SO EM PARTE, A PALAVRA NAO EXISTE
            return (false);
        }
        else if (k == palavra.Length)
        { // CHEGOU AO FIM DA PALAVRA
            return (noAtual.fimPalavra);
        }
        else
        { // DESCE UM NIVEL COM O RESTANTE DA PALAVRA
            palavra = palavra.Substring(k);
            noAtual = noAtual.filho;
        }
    }
    return (false);
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 5 - Remoção",
                    "descricao" => "Desmarca o fim de palavra e, na volta da recursão, descarta o nó inútil ou funde o nó com seu único filho para manter a árvore compacta.",
                    "codigo" => <<<'CSHARP'
private NoPatricia removerRec(NoPatricia no, string palavra)
{
    if (no == null)
    { // PALAVRA NAO EXISTE
        return (null);
    }

    int k = prefixoComum(no.fragmento, palavra);

    if (k == 0)
    {
        no.prox = removerRec(no.prox, palavra);
        return (no);
    }
    if (k < no.fragmento.Length)
    { // COINCIDE SO EM PARTE, A PALAVRA NAO EXISTE
        return (no);
    }

    if (k == palavra.Length)
    {
        if (no.fimPalavra == false)
        { // ERA SO UM PREFIXO DE OUTRA PALAVRA
            return (no);
        }
        no.fimPalavra = false;
    }
    else
    {
        no.filho = removerRec(no.filho, palavra.Substring(k));
    }

    if (no.fimPalavra == false)
    {
        if (no.filho == null)
        { // NO SEM UTILIDADE, DESCARTA E MANTEM OS IRMAOS
            return (no.prox);
        }
        if (no.filho.prox == null)
        { // UM UNICO FILHO, FUNDE OS DOIS NOS
            no.fragmento = no.fragmento + no.filho.fragmento;
            no.fimPalavra = no.filho.fimPalavra;
            no.filho = no.filho.filho;
        }
    }
    return (no);
}

public void remover(string palavra)
{
    this.raiz = removerRec(this.raiz, palavra);
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 6 - Percurso (Imprimir)",
                    "descricao" => "Percorre os irmãos de cada nível e desce pelos filhos, acumulando os fragmentos. As palavras saem em ordem alfabética.",
                    "codigo" => <<<'CSHARP'
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

public void imprimir()
{
    Console.WriteLine("Palavras: ");
    imprimirRec(this.raiz, "");
}
CSHARP
                ]
            ],

            "exercicios" => [
                "Desenhe uma Patricia vazia e insira, em ordem, as palavras: dados, amora, dente, amor e dentista. Confira se o resultado tem 7 nós.",
                "Insira as palavras casa, caso, cama e bola em uma Patricia e depois em uma Trie. Compare a quantidade de nós de cada uma.",
                "Na árvore do exercício anterior, mostre o que acontece, passo a passo, ao inserir a palavra cabo. Qual nó é dividido?",
                "Faça a busca de dent e de dentista na árvore da aula. Qual retorna verdadeiro e por quê? Em que nó cada busca termina?",
                "Remova dados, depois amora, da árvore da aula. Indique em que momento ocorre uma fusão de nós.",
                "Explique, com suas palavras, por que a Patricia precisa dividir um nó na inserção e fundir nós na remoção.",
                "Compare Trie, Patricia e Árvore Binária: em que situação você escolheria cada uma?"
            ]
        ];
    }
}

?>