<?php

class Fila
{
    public function obterConteudo()
    {
        return [
            "titulo" => "Fila Encadeada - FIFO",

            "introducao" => "Uma fila encadeada organiza elementos em nós conectados, seguindo a regra FIFO (First in First out): o primeiro elemento que entra na fila é o primeiro que sai.",

            "objetivos" => [
                "Entender o conceito de fila e a regra FIFO.",
                "Reconhecer os elementos Cabeça e Cauda de uma fila encadeada.",
                "Aprender as operações de inserção (enfileirar) e remoção (desenfileirar).",
                "Compreender as operações de busca e percurso em uma fila.",
                "Visualizar exemplos implementados em C#."
            ],

            "definicao" => "Uma fila é uma Estrutura de Dados que possibilita armazenar e manipular um conjunto de dados seguindo o princípio FIFO - First in First Out: o primeiro elemento a ser inserido é o primeiro a ser retirado. Essa estrutura também é conhecida pelo Tipo Abstrato de Dados (TAD) queue.",

            "contexto" => [
                "Utilizamos filas em diversas situações do nosso cotidiano: a fila de um banco, a fila do cinema, a fila de impressão de documentos. Em todas elas, quem chega primeiro é atendido primeiro.",
                "A Estrutura de Dados FILA pode ser implementada de diferentes modos, como por vetor ou por fila encadeada. Na fila encadeada, cada nó conhece e é conectado com o seu sucessor, assim como ocorre na lista simplesmente encadeada.",
                "A diferença de uma fila para uma lista genérica está nas regras de acesso: a fila só permite inserir elementos no final e remover elementos do início, garantindo a ordem de chegada."
            ],

            "representacao" => "Cabeça -> [12 | Prox] -> [7 | Prox] -> [10 | Prox] -> [51 | Prox] -> NULL <- Cauda",

            "anatomia" => [
                [
                    "termo" => "Nó",
                    "explicacao" => "Cada elemento da fila é chamado de Nó. Ele guarda um Valor e uma referência Prox, que aponta para o próximo nó da fila."
                ],
                [
                    "termo" => "Cabeça (início)",
                    "explicacao" => "É o primeiro elemento da fila. É por ele que os elementos são removidos (desenfileirados)."
                ],
                [
                    "termo" => "Cauda (fim)",
                    "explicacao" => "É o último elemento da fila. É por ele que novos elementos são inseridos (enfileirados)."
                ],
                [
                    "termo" => "Prox",
                    "explicacao" => "Referência de cada nó para o próximo nó da fila. O Prox do último nó (Cauda) sempre aponta para NULL."
                ]
            ],

            "comoFunciona" => [
                "O primeiro nó da fila é chamado de início ou cabeça.",
                "O último nó da fila é chamado de fim ou cauda.",
                "O Prox do nó cauda sempre aponta para NULL.",
                "Novos elementos só podem ser inseridos no fim da fila.",
                "Elementos só podem ser removidos do início da fila."
            ],

            "importancia" => "A fila é importante sempre que a ordem de chegada precisa ser respeitada durante o processamento dos elementos, garantindo que ninguém seja atendido fora de ordem.",

            "aplicacoes" => [
                "Fila de impressão de documentos.",
                "Fila de atendimento bancário ou de senhas.",
                "Fila de processos aguardando o processador em um Sistema Operacional.",
                "Fila de mensagens em sistemas de comunicação."
            ],

            "operacoes" => [
                [
                    "nome" => "Inserção (Enfileirar)",
                    "descricao" => "Insere um novo nó sempre no final (cauda) da fila.",
                    "complexidade" => "O(1)"
                ],
                [
                    "nome" => "Remoção (Desenfileirar)",
                    "descricao" => "Remove sempre o nó que está no início (cabeça) da fila.",
                    "complexidade" => "O(1)"
                ],
                [
                    "nome" => "Busca (Consulta)",
                    "descricao" => "Percorre a fila a partir da cabeça até localizar o valor desejado.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Percurso",
                    "descricao" => "Percorre todos os nós da fila, do início ao fim, para exibir ou processar os valores.",
                    "complexidade" => "O(n)"
                ]
            ],

            "insercoes" => [
                [
                    "titulo" => "Inserção no fim (Enfileirar)",
                    "complexidade" => "O(1)",
                    "passos" => [
                        "Criar o novo nó com o valor informado.",
                        "Se a fila estiver vazia, o novo nó passa a ser a Cabeça e a Cauda da fila.",
                        "Caso contrário, fazer o Prox do nó Cauda atual apontar para o novo nó.",
                        "Tornar o novo nó a nova Cauda (fim) da fila."
                    ]
                ]
            ],

            "remocoes" => [
                [
                    "titulo" => "Remoção no início (Desenfileirar)",
                    "passos" => [
                        "Verificar se a fila está vazia; se estiver, não há o que remover.",
                        "Se existir apenas um elemento (Cabeça igual a Cauda), tornar Cabeça e Cauda nulos.",
                        "Caso contrário, fazer a Cabeça apontar para o Prox do nó atual da Cabeça.",
                        "O antigo nó da Cabeça deixa de fazer parte da fila."
                    ]
                ]
            ],

            "buscaPercurso" => [
                [
                    "titulo" => "Busca (Consulta)",
                    "descricao" => "Começa pela Cabeça e compara os valores nó a nó até encontrar o valor procurado ou chegar ao fim da fila.",
                    "complexidade" => "O(n)"
                ],
                [
                    "titulo" => "Percurso",
                    "descricao" => "Começa na Cabeça e utiliza o Prox de cada nó até chegar em NULL, exibindo todos os valores na ordem da fila.",
                    "complexidade" => "O(n)"
                ]
            ],

            "comparacao" => [
                [
                    "criterio" => "Regra de acesso",
                    "simples" => "Lista: insere e remove em qualquer posição",
                    "dupla" => "Fila: insere só no fim e remove só no início"
                ],
                [
                    "criterio" => "Princípio",
                    "simples" => "Lista: sem ordem fixa de entrada e saída",
                    "dupla" => "Fila: FIFO - primeiro que entra é o primeiro que sai"
                ],
                [
                    "criterio" => "Referências por nó",
                    "simples" => "Somente para o próximo (Prox)",
                    "dupla" => "Somente para o próximo (Prox)"
                ],
                [
                    "criterio" => "Aplicações típicas",
                    "simples" => "Armazenar coleções em geral",
                    "dupla" => "Filas de espera, filas de impressão, filas de processos"
                ]
            ],

            "videos" => [
                [
                    "titulo" => "Videoaula sobre Fila Encadeada - FIFO",
                    "descricao" => "Vídeo complementar sobre fila encadeada FIFO para apoiar o estudo das operações de enfileirar e desenfileirar.",
                    "fonte" => "YouTube - vídeo complementar",
                    "url" => "https://www.youtube.com/embed/mCathNfPHqM",
                    "link" => "https://www.youtube.com/watch?v=mCathNfPHqM"
                ]
            ],

            "orientacaoCodigo" => "Os exemplos seguem o mesmo raciocínio das operações: primeiro definimos o nó e a fila, depois inserimos (enfileiramos), removemos (desenfileiramos), buscamos e percorremos. Os métodos ficam dentro das classes No e Fila.",

            "exemplos" => [
                [
                    "titulo" => "Exemplo 1 - Classe No",
                    "descricao" => "Cada nó da fila guarda um valor e a referência Prox para o próximo nó.",
                    "codigo" => <<<'CSHARP'
public class No
{
    public int valor;
    public No prox;

    public No(int Valor)
    {
        this.valor = Valor;
        this.prox = null;
    }

    public void imprimir()
    {
        Console.WriteLine("Valor: " + this.valor);
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 2 - Classe Fila e verificação de fila vazia",
                    "descricao" => "A fila mantém as referências para o início (Cabeça) e para o fim (Cauda).",
                    "codigo" => <<<'CSHARP'
public class Fila
{
    public No inicio;
    public No fim;

    public Fila()
    {
        this.inicio = null;
        this.fim = null;
    }

    public Boolean estaVazia()
    {
        if (this.inicio == null)
        {
            return (true);
        }
        return (false);
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 3 - Inserção (Enfileirar)",
                    "descricao" => "O novo nó é sempre inserido no fim (Cauda) da fila.",
                    "codigo" => <<<'CSHARP'
public void inserirEnfileirar(int Valor)
{
    // CRIAR NOVO NO
    No novoNo = new No(Valor);

    if (estaVazia() == true)
    { // FILA VAZIA!
        this.inicio = novoNo;
        this.fim = novoNo;
    }
    else
    {
        this.fim.prox = novoNo; // O prox do fim (que era nulo) passa a apontar para o novo no
        this.fim = novoNo;      // Fim passa a ser o novo no
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 4 - Remoção (Desenfileirar)",
                    "descricao" => "A remoção acontece sempre no início (Cabeça) da fila.",
                    "codigo" => <<<'CSHARP'
public void removerDesenfileirar()
{
    if (estaVazia() == true)
    {
        return;
    }
    else if (this.inicio == this.fim)
    { // Caso exista apenas um elemento na Fila
        this.inicio = null;
        this.fim = null;
    }
    else
    { // Remoção do elemento no inicio da Fila
        this.inicio = this.inicio.prox;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 5 - Busca (Consulta)",
                    "descricao" => "A busca percorre a fila a partir da Cabeça até encontrar o valor ou chegar ao final.",
                    "codigo" => <<<'CSHARP'
public Boolean consulta(int valor, ref No noAtual, ref No noAnterior)
{
    noAtual = this.inicio;
    noAnterior = null;

    while (noAtual != null)
    {
        if (noAtual.valor == valor)
        {
            return (true);
        }
        noAnterior = noAtual;
        noAtual = noAtual.prox;
    }
    return (false);
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 6 - Percurso (Imprimir)",
                    "descricao" => "O percurso exibe todos os elementos da fila, do início ao fim.",
                    "codigo" => <<<'CSHARP'
public void imprimir()
{
    No noAux = this.inicio;

    Console.WriteLine("Elementos: ");

    while (noAux != null)
    {
        Console.WriteLine(noAux.valor + " -> ");
        noAux = noAux.prox;
    }
}
CSHARP
                ]
            ],

            "exercicios" => [
                "Desenhe uma fila com os valores 12, 7, 10 e 51, destacando Cabeça, Cauda e o Prox de cada nó.",
                "Use o método inserirEnfileirar para inserir os valores 5, 8 e 20 em uma fila vazia e desenhe o resultado.",
                "Aplique removerDesenfileirar duas vezes seguidas na fila do exercício anterior e mostre o estado final.",
                "Explique por que a fila não permite inserir um elemento no início ou remover um elemento do fim.",
                "Implemente um método que conte quantos elementos existem na fila, percorrendo-a do início ao fim.",
                "Cite um exemplo do seu cotidiano que funcione como uma fila e outro que não respeite a regra FIFO.",
                "Compare a Fila Encadeada com a Lista Duplamente Encadeada estudada anteriormente."
            ]
        ];
    }
}
?>