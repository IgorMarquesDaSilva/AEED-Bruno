<?php

class ArvoreBinaria
{
    public function obterConteudo()
    {
        return [
            "titulo" => "Árvore Binária",

            "introducao" => "Uma Árvore Binária é uma estrutura de dados não linear e hierárquica em que cada nó possui no máximo dois filhos: um à esquerda e outro à direita. Cada filho é a raiz de uma sub-árvore, e essa definição se repete de forma recursiva. Nesta aula, os valores são organizados como em uma árvore binária de busca: menores à esquerda, maiores à direita.",

            "objetivos" => [
                "Relembrar os conceitos de árvore: raiz, ramos, folhas, pais, filhos, irmãos, níveis e altura.",
                "Entender a estrutura da Árvore Binária: um nó com ponteiros para a esquerda e para a direita.",
                "Compreender a natureza recursiva das sub-árvores esquerda e direita.",
                "Acompanhar a inserção de valores comparando cada um com os nós já existentes.",
                "Conhecer a busca, os percursos e a remoção de nós.",
                "Entender por que a árvore é não balanceada e como isso afeta o desempenho.",
                "Visualizar exemplos implementados em C#."
            ],

            "definicao" => "Uma Árvore Binária é uma Estrutura de Dados em árvore em que cada nó possui no máximo dois filhos, chamados de filho esquerdo e filho direito. A estrutura começa no Nó Raiz, que possui dois ponteiros: um para um nó à esquerda e outro para um nó à direita. Cada um desses nós é, por sua vez, a raiz de uma sub-árvore, uma à esquerda e outra à direita, de forma recursiva. Quando um ponteiro não aponta para nenhum nó, ele vale nulo, e uma árvore sem nenhum nó é chamada de árvore vazia. Nesta implementação, a regra de organização é: valores menores que o do nó vão para a sub-árvore da esquerda e valores maiores vão para a sub-árvore da direita.",

            "contexto" => [
                "Em uma árvore genérica, cada nó pode ter qualquer número de filhos. Na Árvore Binária, o limite é dois, o que simplifica a estrutura e permite escrever algoritmos recursivos curtos.",
                "Na árvore genérica estudada em aula, o nó A tinha três filhos (B, C e E). Na árvore binária, o nó A teria no máximo dois, B à esquerda e C à direita.",
                "Considere inserir os valores 20, 27, 10, 51, 21, 7 e 12 em uma árvore vazia. O primeiro valor vira a raiz, e cada valor seguinte desce pela árvore comparando-se com os nós até encontrar um lugar vazio. O resultado desse exemplo aparece no diagrama abaixo."
            ],

            "representacao" => '<svg viewBox="0 0 760 290" role="img" aria-labelledby="arv-svg-titulo" class="arvore-svg" xmlns="http://www.w3.org/2000/svg">'
                . '<title id="arv-svg-titulo">Árvore binária resultante da inserção de 20, 27, 10, 51, 21, 7 e 12</title>'
                . '<g stroke="#b9ccd3" stroke-width="2" fill="none">'
                . '<line x1="380" y1="48" x2="200" y2="102"/><line x1="380" y1="48" x2="560" y2="102"/>'
                . '<line x1="200" y1="122" x2="110" y2="172"/><line x1="200" y1="122" x2="290" y2="172"/>'
                . '<line x1="560" y1="122" x2="470" y2="172"/><line x1="560" y1="122" x2="650" y2="172"/>'
                . '</g>'
                . '<g font-family="Segoe UI, Arial, sans-serif" font-size="20" font-weight="700" text-anchor="middle">'
                . '<circle cx="380" cy="32" r="22" fill="#e9f4f3" stroke="#0f766e" stroke-width="3"/><text x="380" y="39" fill="#0f766e">20</text>'
                . '<circle cx="200" cy="104" r="22" fill="#fff" stroke="#123554" stroke-width="2"/><text x="200" y="111" fill="#123554">10</text>'
                . '<circle cx="560" cy="104" r="22" fill="#fff" stroke="#123554" stroke-width="2"/><text x="560" y="111" fill="#123554">27</text>'
                . '<circle cx="110" cy="176" r="22" fill="#fff" stroke="#123554" stroke-width="2"/><text x="110" y="183" fill="#123554">7</text>'
                . '<circle cx="290" cy="176" r="22" fill="#fff" stroke="#123554" stroke-width="2"/><text x="290" y="183" fill="#123554">12</text>'
                . '<circle cx="470" cy="176" r="22" fill="#fff" stroke="#123554" stroke-width="2"/><text x="470" y="183" fill="#123554">21</text>'
                . '<circle cx="650" cy="176" r="22" fill="#fff" stroke="#123554" stroke-width="2"/><text x="650" y="183" fill="#123554">51</text>'
                . '</g>'
                . '<g font-family="Segoe UI, Arial, sans-serif" font-size="14" fill="#526779" text-anchor="middle">'
                . '<text x="380" y="78">raiz</text>'
                . '<text x="110" y="232">nível 3</text><text x="290" y="232">nível 3</text><text x="470" y="232">nível 3</text><text x="650" y="232">nível 3</text>'
                . '<text x="60" y="38" text-anchor="start">nível 1</text><text x="60" y="110" text-anchor="start">nível 2</text>'
                . '<text x="380" y="270">Esquerda: valores menores · Direita: valores maiores</text>'
                . '</g>'
                . '</svg>',

            "legendaRepresentacao" => "Árvore resultante da inserção de 20, 27, 10, 51, 21, 7 e 12. A altura é 3 (contando a raiz como nível 1).",

            "anatomia" => [
                [
                    "termo" => "Nó",
                    "explicacao" => "Cada elemento da árvore. Guarda um Valor e dois ponteiros: Esq (filho esquerdo) e Dir (filho direito). Ponteiro sem filho vale nulo."
                ],
                [
                    "termo" => "Raiz",
                    "explicacao" => "Nó inicial da árvore, no nível 1 (nos slides também aparece como nível 0). É por ele que todas as operações começam. Quando a árvore está vazia, a raiz é nula."
                ],
                [
                    "termo" => "Filhos esquerdo e direito",
                    "explicacao" => "No máximo dois filhos por nó. Valores menores que o do nó ficam à esquerda e valores maiores ficam à direita."
                ],
                [
                    "termo" => "Sub-árvores",
                    "explicacao" => "Cada filho é raiz de uma sub-árvore. Por isso as operações podem ser escritas de forma recursiva: o mesmo raciocínio se repete em cada sub-árvore."
                ],
                [
                    "termo" => "Folha",
                    "explicacao" => "Nó sem filhos (os dois ponteiros são nulos). No exemplo, 7, 12, 21 e 51 são folhas."
                ],
                [
                    "termo" => "Níveis e altura",
                    "explicacao" => "O nível indica a profundidade na hierarquia. A altura é a quantidade de níveis da árvore: no exemplo, 3."
                ]
            ],

            "comoFunciona" => [
                "A árvore começa vazia: a raiz aponta para nulo.",
                "O primeiro valor inserido torna-se a raiz.",
                "Cada novo valor é comparado com a raiz: se for menor, desce pela esquerda; se for maior, desce pela direita.",
                "O processo se repete em cada nó visitado, até encontrar um ponteiro nulo.",
                "O novo nó é colocado nesse ponteiro nulo, como folha."
            ],

            "importancia" => "A Árvore Binária é a base de várias estruturas mais avançadas e permite buscas, inserções e remoções eficientes quando está equilibrada, já que cada comparação descarta uma das sub-árvores. Por isso ela aparece em índices, dicionários ordenados e expressões aritméticas.",

            "naoBalanceada" => "Esta é uma árvore não balanceada: o formato depende da ordem de inserção. Inserindo 1, 2, 3, 4 e 5 nessa ordem, cada valor vai sempre para a direita e a árvore vira uma lista encadeada, com altura 5. Nesse pior caso, as operações custam O(n). Em uma árvore bem distribuída, a altura é próxima de log₂ n e as operações custam O(log n).",

            "aplicacoes" => [
                "Armazenar dados ordenados com busca rápida, como cadastros e dicionários.",
                "Representar expressões aritméticas, com operadores nos nós internos e operandos nas folhas.",
                "Servir de base para árvores balanceadas, usadas em bancos de dados e sistemas de arquivos.",
                "Ordenar dados percorrendo a árvore em ordem."
            ],

            "operacoes" => [
                [
                    "nome" => "Inserção",
                    "descricao" => "Desce comparando o valor com cada nó (menor à esquerda, maior à direita) até achar um ponteiro nulo e insere o novo nó ali.",
                    "complexidade" => "O(h)"
                ],
                [
                    "nome" => "Busca (Consulta)",
                    "descricao" => "Faz as mesmas comparações da inserção até encontrar o valor ou chegar a um ponteiro nulo.",
                    "complexidade" => "O(h)"
                ],
                [
                    "nome" => "Remoção",
                    "descricao" => "Localiza o nó e trata três casos: folha, nó com um filho ou nó com dois filhos.",
                    "complexidade" => "O(h)"
                ],
                [
                    "nome" => "Percurso",
                    "descricao" => "Visita todos os nós de forma recursiva, em pré-ordem, em-ordem ou pós-ordem.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Altura",
                    "descricao" => "Calcula a quantidade de níveis comparando a altura das sub-árvores esquerda e direita.",
                    "complexidade" => "O(n)"
                ]
            ],

            "complexidadeNota" => "Na tabela, h é a altura da árvore e n é o número de nós. Em uma árvore equilibrada h é aproximadamente log₂ n; no pior caso (árvore degenerada), h é igual a n.",

            "insercoes" => [
                [
                    "titulo" => "Inserção de um valor",
                    "complexidade" => "O(h)",
                    "passos" => [
                        "Se a árvore estiver vazia, o novo nó se torna a raiz.",
                        "Caso contrário, começar pela raiz como nó atual.",
                        "Se o valor for menor que o do nó atual, seguir para o filho esquerdo; se for maior, seguir para o filho direito.",
                        "Repetir até encontrar um ponteiro nulo.",
                        "Ligar o novo nó nesse ponteiro nulo, como filho esquerdo ou direito do último nó visitado."
                    ]
                ],
                [
                    "titulo" => "Exemplo: inserir 20, 27, 10, 51, 21, 7 e 12",
                    "complexidade" => "Visualização",
                    "passos" => [
                        "20: árvore vazia, então o 20 se torna a raiz.",
                        "27: 27 > 20, então entra como filho direito de 20.",
                        "10: 10 < 20, então entra como filho esquerdo de 20.",
                        "51: 51 > 20 e 51 > 27, então entra como filho direito de 27.",
                        "21: 21 > 20 e 21 < 27, então entra como filho esquerdo de 27.",
                        "7: 7 < 20 e 7 < 10, então entra como filho esquerdo de 10.",
                        "12: 12 < 20 e 12 > 10, então entra como filho direito de 10."
                    ]
                ]
            ],

            "remocoes" => [
                [
                    "titulo" => "Remoção de um valor",
                    "passos" => [
                        "Buscar o nó a ser removido; se não existir, não há o que remover.",
                        "Caso 1, folha: o ponteiro do pai que apontava para o nó passa a ser nulo.",
                        "Caso 2, um filho: o pai passa a apontar diretamente para o único filho do nó removido.",
                        "Caso 3, dois filhos: localizar o sucessor (o menor valor da sub-árvore direita), copiar seu valor para o nó e remover o sucessor da sub-árvore direita."
                    ]
                ]
            ],

            "buscaPercurso" => [
                [
                    "titulo" => "Busca (Consulta)",
                    "descricao" => "Compara o valor procurado com o nó atual: se for igual, encontrou; se for menor, continua à esquerda; se for maior, continua à direita; se chegar a nulo, o valor não existe.",
                    "complexidade" => "O(h)"
                ],
                [
                    "titulo" => "Percurso em-ordem",
                    "descricao" => "Esquerda, nó, direita. Visita os valores em ordem crescente. No exemplo: 7, 10, 12, 20, 21, 27, 51.",
                    "complexidade" => "O(n)"
                ],
                [
                    "titulo" => "Percurso pré-ordem",
                    "descricao" => "Nó, esquerda, direita. Visita o nó antes das sub-árvores. No exemplo: 20, 10, 7, 12, 27, 21, 51.",
                    "complexidade" => "O(n)"
                ],
                [
                    "titulo" => "Percurso pós-ordem",
                    "descricao" => "Esquerda, direita, nó. Visita o nó depois das sub-árvores. No exemplo: 7, 12, 10, 21, 51, 27, 20.",
                    "complexidade" => "O(n)"
                ]
            ],

            "comparacao" => [
                [
                    "criterio" => "Filhos por nó",
                    "simples" => "Árvore genérica: qualquer quantidade",
                    "dupla" => "Árvore binária: no máximo 2 (esquerdo e direito)"
                ],
                [
                    "criterio" => "Ponteiros no nó",
                    "simples" => "Árvore genérica: uma referência para cada filho",
                    "dupla" => "Árvore binária: Esq e Dir"
                ],
                [
                    "criterio" => "Posição dos valores",
                    "simples" => "Árvore genérica: sem regra de ordenação própria",
                    "dupla" => "Árvore binária de busca: menores à esquerda, maiores à direita"
                ],
                [
                    "criterio" => "Busca",
                    "simples" => "Árvore genérica: pode exigir percorrer vários ramos",
                    "dupla" => "Árvore binária de busca: descarta uma sub-árvore a cada comparação"
                ],
                [
                    "criterio" => "Pior caso",
                    "simples" => "Árvore genérica: O(n)",
                    "dupla" => "Árvore binária: O(n), quando vira uma lista"
                ]
            ],

            "orientacaoCodigo" => "Os exemplos seguem as operações: primeiro definimos o nó (valor e ponteiros esq e dir), depois inserimos, buscamos, percorremos, calculamos a altura e removemos. As operações são recursivas, porque cada sub-árvore é também uma árvore. Valores repetidos são ignorados. Os métodos ficam dentro das classes NoArvore e ArvoreBinaria.",

            "exemplos" => [
                [
                    "titulo" => "Exemplo 1 - Classe NoArvore",
                    "descricao" => "Cada nó guarda um valor e as referências para o filho esquerdo e para o filho direito.",
                    "codigo" => <<<'CSHARP'
public class NoArvore
{
    public int valor;
    public NoArvore esq;
    public NoArvore dir;

    public NoArvore(int Valor)
    {
        this.valor = Valor;
        this.esq = null;
        this.dir = null;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 2 - Classe ArvoreBinaria e verificação de árvore vazia",
                    "descricao" => "A árvore mantém apenas a referência para a raiz. Árvore vazia significa raiz nula.",
                    "codigo" => <<<'CSHARP'
public class ArvoreBinaria
{
    public NoArvore raiz;

    public ArvoreBinaria()
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
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 3 - Inserção",
                    "descricao" => "Se o ponto atual é nulo, o novo nó é criado ali. Caso contrário, a inserção continua na sub-árvore esquerda (valor menor) ou direita (valor maior).",
                    "codigo" => <<<'CSHARP'
private NoArvore inserirRec(NoArvore noAtual, int Valor)
{
    if (noAtual == null)
    { // ARVORE (OU SUB-ARVORE) VAZIA, O NOVO NO SE TORNA RAIZ DELA
        return (new NoArvore(Valor));
    }

    if (Valor < noAtual.valor)
    { // MENOR, DESCE PELA ESQUERDA
        noAtual.esq = inserirRec(noAtual.esq, Valor);
    }
    else if (Valor > noAtual.valor)
    { // MAIOR, DESCE PELA DIREITA
        noAtual.dir = inserirRec(noAtual.dir, Valor);
    }

    return (noAtual);
}

public void inserir(int Valor)
{
    this.raiz = inserirRec(this.raiz, Valor);
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 4 - Busca (Consulta)",
                    "descricao" => "A cada passo, a comparação descarta uma das sub-árvores. Se chegar a nulo, o valor não existe.",
                    "codigo" => <<<'CSHARP'
public Boolean consulta(int valor)
{
    NoArvore noAtual = this.raiz;

    while (noAtual != null)
    {
        if (valor == noAtual.valor)
        {
            return (true);
        }
        else if (valor < noAtual.valor)
        {
            noAtual = noAtual.esq;
        }
        else
        {
            noAtual = noAtual.dir;
        }
    }
    return (false);
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 5 - Percursos (Imprimir)",
                    "descricao" => "A única diferença entre os três percursos é o momento em que o nó é visitado em relação às sub-árvores. O em-ordem imprime os valores em ordem crescente.",
                    "codigo" => <<<'CSHARP'
public void emOrdem(NoArvore no)
{
    if (no != null)
    {
        emOrdem(no.esq);
        Console.WriteLine(no.valor);
        emOrdem(no.dir);
    }
}

public void preOrdem(NoArvore no)
{
    if (no != null)
    {
        Console.WriteLine(no.valor);
        preOrdem(no.esq);
        preOrdem(no.dir);
    }
}

public void posOrdem(NoArvore no)
{
    if (no != null)
    {
        posOrdem(no.esq);
        posOrdem(no.dir);
        Console.WriteLine(no.valor);
    }
}

public void imprimir()
{
    Console.WriteLine("Elementos em ordem: ");
    emOrdem(this.raiz);
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 6 - Altura",
                    "descricao" => "A altura de uma árvore é 1 mais a maior altura entre suas sub-árvores. A árvore vazia tem altura 0.",
                    "codigo" => <<<'CSHARP'
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

public int altura()
{
    return (alturaRec(this.raiz));
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 7 - Remoção",
                    "descricao" => "Trata os três casos: folha, um filho e dois filhos. No caso de dois filhos, o nó recebe o valor do sucessor (menor valor da sub-árvore direita), que é então removido.",
                    "codigo" => <<<'CSHARP'
private NoArvore removerRec(NoArvore noAtual, int Valor)
{
    if (noAtual == null)
    { // VALOR NAO EXISTE
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
    { // ENCONTROU O NO A SER REMOVIDO
        if (noAtual.esq == null)
        { // FOLHA OU SO FILHO DIREITO
            return (noAtual.dir);
        }
        if (noAtual.dir == null)
        { // SO FILHO ESQUERDO
            return (noAtual.esq);
        }

        // DOIS FILHOS: BUSCA O SUCESSOR (MENOR DA SUB-ARVORE DIREITA)
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

public void remover(int Valor)
{
    this.raiz = removerRec(this.raiz, Valor);
}
CSHARP
                ]
            ],

            "exercicios" => [
                "Desenhe uma árvore binária vazia e insira, em ordem, os valores 20, 27, 10, 51, 21, 7 e 12. Compare com o diagrama da aula.",
                "Insira os mesmos valores em outra ordem: 7, 10, 12, 20, 21, 27, 51. Desenhe a árvore e informe a altura. O que aconteceu?",
                "Na árvore do primeiro exercício, escreva a sequência dos percursos em-ordem, pré-ordem e pós-ordem.",
                "Quantas comparações são necessárias para buscar o valor 21? E para buscar o valor 13, que não existe?",
                "Remova o valor 7, depois o valor 27 e depois o valor 20 da árvore do primeiro exercício, desenhando a árvore após cada remoção.",
                "Explique, com suas palavras, por que a árvore binária de busca é chamada de não balanceada.",
                "Compare a Árvore Binária com a Lista Simples: em que situação cada uma é mais vantajosa para buscar um valor?"
            ]
        ];
    }
}

?>