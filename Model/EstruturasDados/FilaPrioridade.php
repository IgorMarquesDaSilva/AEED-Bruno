<?php

class FilaPrioridade
{
    public function obterConteudo()
    {
        return [
            "titulo" => "Fila de Prioridades Encadeada - FIFO",

            "introducao" => "Uma fila de prioridades encadeada organiza elementos em nós conectados, mas a ordem de saída não depende apenas da chegada: quem tem maior prioridade sai primeiro. Quando dois elementos possuem a mesma prioridade, o critério de desempate é o FIFO (First in First out).",

            "objetivos" => [
                "Entender o conceito de fila de prioridades e em que ela se diferencia da fila comum.",
                "Compreender a convenção de que valores maiores representam maior prioridade.",
                "Aprender como a inserção ordenada mantém a fila sempre organizada por prioridade.",
                "Compreender o uso do FIFO como critério de desempate entre prioridades iguais.",
                "Visualizar exemplos implementados em C#."
            ],

            "definicao" => "Uma fila de prioridades é uma Estrutura de Dados que armazena um conjunto de elementos, onde cada elemento possui uma prioridade associada. Diferente da fila comum (FIFO puro), a remoção não segue somente a ordem de chegada: o elemento removido é sempre aquele com a maior prioridade. Nesta implementação, adota-se a convenção de que quanto maior o número, maior a prioridade. Quando existem elementos com prioridades iguais, o desempate segue a regra FIFO, ou seja, entre eles sai primeiro quem chegou primeiro.",

            "contexto" => [
                "Filas de prioridade aparecem em diversas situações reais: no atendimento hospitalar, pacientes mais graves são atendidos antes, mesmo que tenham chegado depois de outros; no sistema operacional, processos com prioridade mais alta recebem o processador antes dos demais.",
                "A Fila de Prioridades Encadeada pode ser implementada mantendo os nós sempre ordenados por prioridade, do maior para o menor. Assim, a remoção acontece sempre no início da fila, de forma parecida com a fila comum.",
                "A diferença de uma fila de prioridades para uma fila comum está no momento da inserção: em vez de inserir sempre no fim, o novo elemento é posicionado no local correto, de acordo com sua prioridade."
            ],

            "representacao" => "Cabeça -> [Valor 51, Prio 9] -> [Valor 12, Prio 9] -> [Valor 7, Prio 5] -> [Valor 10, Prio 2] -> NULL <- Cauda",

            "anatomia" => [
                [
                    "termo" => "Nó",
                    "explicacao" => "Cada elemento da fila é chamado de Nó. Ele guarda um Valor, uma Prioridade e uma referência Prox, que aponta para o próximo nó da fila."
                ],
                [
                    "termo" => "Prioridade",
                    "explicacao" => "Número associado a cada nó que define sua importância. Quanto maior o número, maior a prioridade do elemento."
                ],
                [
                    "termo" => "Cabeça (início)",
                    "explicacao" => "É o nó com a maior prioridade da fila (ou o mais antigo entre os de maior prioridade). É por ele que os elementos são removidos."
                ],
                [
                    "termo" => "Cauda (fim)",
                    "explicacao" => "É o nó com a menor prioridade da fila. Novos elementos com prioridade ainda menor são inseridos após ele."
                ],
                [
                    "termo" => "Prox",
                    "explicacao" => "Referência de cada nó para o próximo nó da fila. O Prox do último nó (Cauda) sempre aponta para NULL."
                ]
            ],

            "comoFunciona" => [
                "Cada nó da fila guarda, além do valor, um número que representa sua prioridade.",
                "A fila é mantida sempre ordenada, do maior nível de prioridade para o menor.",
                "Um novo elemento é inserido logo antes do primeiro nó com prioridade menor que a dele.",
                "Quando duas prioridades são iguais, o novo elemento é inserido depois dos elementos já existentes com aquela mesma prioridade, respeitando o FIFO.",
                "A remoção sempre retira o nó da Cabeça, que é o de maior prioridade."
            ],

            "importancia" => "A fila de prioridades é importante sempre que a ordem de atendimento não pode depender apenas do momento de chegada, mas também da urgência ou relevância de cada elemento, garantindo que os casos mais importantes sejam tratados primeiro.",

            "aplicacoes" => [
                "Atendimento de emergência hospitalar, priorizando os casos mais graves.",
                "Escalonamento de processos em Sistemas Operacionais, de acordo com sua prioridade.",
                "Filas de impressão que priorizam documentos urgentes.",
                "Algoritmos de busca em grafos, como o algoritmo de Dijkstra, que utilizam filas de prioridade internamente."
            ],

            "operacoes" => [
                [
                    "nome" => "Inserção ordenada",
                    "descricao" => "Percorre a fila até encontrar a posição correta e insere o novo nó de acordo com sua prioridade.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Remoção (Desenfileirar)",
                    "descricao" => "Remove sempre o nó que está no início (Cabeça), que é o de maior prioridade.",
                    "complexidade" => "O(1)"
                ],
                [
                    "nome" => "Busca (Consulta)",
                    "descricao" => "Percorre a fila a partir da cabeça até localizar o valor desejado.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Percurso",
                    "descricao" => "Percorre todos os nós da fila, do início ao fim, exibindo valor e prioridade de cada um.",
                    "complexidade" => "O(n)"
                ]
            ],

            "insercoes" => [
                [
                    "titulo" => "Inserção ordenada por prioridade",
                    "complexidade" => "O(n)",
                    "passos" => [
                        "Criar o novo nó com o valor e a prioridade informados.",
                        "Se a fila estiver vazia, o novo nó passa a ser a Cabeça e a Cauda da fila.",
                        "Caso contrário, percorrer a fila a partir da Cabeça até encontrar um nó com prioridade menor que a do novo elemento.",
                        "Se nenhum nó tiver prioridade menor, o novo elemento é inserido no fim, tornando-se a nova Cauda.",
                        "Se um nó de menor prioridade for encontrado, o novo elemento é inserido imediatamente antes dele, respeitando o FIFO entre prioridades iguais."
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
                        "O antigo nó da Cabeça deixa de fazer parte da fila, sempre o de maior prioridade no momento da remoção."
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
                    "descricao" => "Começa na Cabeça e utiliza o Prox de cada nó até chegar em NULL, exibindo valor e prioridade de cada elemento na ordem da fila.",
                    "complexidade" => "O(n)"
                ]
            ],

            "comparacao" => [
                [
                    "criterio" => "Critério de saída",
                    "simples" => "Fila comum: ordem de chegada (FIFO)",
                    "dupla" => "Fila de prioridades: maior prioridade primeiro, FIFO no empate"
                ],
                [
                    "criterio" => "Local de inserção",
                    "simples" => "Fila comum: sempre no fim (Cauda)",
                    "dupla" => "Fila de prioridades: posição de acordo com a prioridade"
                ],
                [
                    "criterio" => "Complexidade da inserção",
                    "simples" => "Fila comum: O(1)",
                    "dupla" => "Fila de prioridades: O(n)"
                ],
                [
                    "criterio" => "Local de remoção",
                    "simples" => "Fila comum: sempre no início (Cabeça)",
                    "dupla" => "Fila de prioridades: sempre no início (Cabeça)"
                ]
            ],

            "videos" => [
                [
                    "titulo" => "Videoaula sobre Fila de Prioridades",
                    "descricao" => "Vídeo complementar sobre fila de prioridades encadeada para apoiar o estudo da inserção ordenada e do critério FIFO no desempate.",
                    "fonte" => "YouTube - vídeo complementar",
                    "url" => "https://www.youtube.com/embed/wptevk0bshY",
                    "link" => "https://www.youtube.com/watch?v=wptevk0bshY"
                ]
            ],

            "orientacaoCodigo" => "Os exemplos seguem o mesmo raciocínio das operações: primeiro definimos o nó (agora com um campo de prioridade), depois inserimos de forma ordenada, removemos, buscamos e percorremos. Os métodos ficam dentro das classes No e FilaPrioridade.",

            "exemplos" => [
                [
                    "titulo" => "Exemplo 1 - Classe No",
                    "descricao" => "Cada nó da fila guarda um valor, sua prioridade e a referência Prox para o próximo nó.",
                    "codigo" => <<<'CSHARP'
public class No
{
    public int valor;
    public int prioridade;
    public No prox;

    public No(int Valor, int Prioridade)
    {
        this.valor = Valor;
        this.prioridade = Prioridade;
        this.prox = null;
    }

    public void imprimir()
    {
        Console.WriteLine("Valor: " + this.valor + " | Prioridade: " + this.prioridade);
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 2 - Classe FilaPrioridade e verificação de fila vazia",
                    "descricao" => "A fila mantém as referências para o início (Cabeça) e para o fim (Cauda), sempre ordenados por prioridade.",
                    "codigo" => <<<'CSHARP'
public class FilaPrioridade
{
    public No inicio;
    public No fim;

    public FilaPrioridade()
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
                    "titulo" => "Exemplo 3 - Inserção ordenada por prioridade",
                    "descricao" => "O novo nó é inserido na posição correta, de acordo com a prioridade. Quanto maior o número, maior a prioridade. Em caso de empate, o novo elemento entra depois dos já existentes com a mesma prioridade (FIFO).",
                    "codigo" => <<<'CSHARP'
public void inserirOrdenado(int Valor, int Prioridade)
{
    // CRIAR NOVO NO
    No novoNo = new No(Valor, Prioridade);

    if (estaVazia() == true)
    { // FILA VAZIA!
        this.inicio = novoNo;
        this.fim = novoNo;
        return;
    }

    if (Prioridade > this.inicio.prioridade)
    { // NOVO NO TEM A MAIOR PRIORIDADE DE TODOS
        novoNo.prox = this.inicio;
        this.inicio = novoNo;
        return;
    }

    No noAtual = this.inicio;

    while (noAtual.prox != null && noAtual.prox.prioridade >= Prioridade)
    {
        noAtual = noAtual.prox;
    }

    novoNo.prox = noAtual.prox;
    noAtual.prox = novoNo;

    if (novoNo.prox == null)
    { // NOVO NO PASSOU A SER O FIM DA FILA
        this.fim = novoNo;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 4 - Remoção (Desenfileirar)",
                    "descricao" => "A remoção acontece sempre no início (Cabeça), que é o nó de maior prioridade.",
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
                    "descricao" => "O percurso exibe o valor e a prioridade de todos os elementos, do início ao fim.",
                    "codigo" => <<<'CSHARP'
public void imprimir()
{
    No noAux = this.inicio;

    Console.WriteLine("Elementos: ");

    while (noAux != null)
    {
        Console.WriteLine("Valor: " + noAux.valor + " | Prioridade: " + noAux.prioridade);
        noAux = noAux.prox;
    }
}
CSHARP
                ]
            ],

            "exercicios" => [
                "Desenhe uma fila de prioridades vazia e insira, em ordem, os pares (valor, prioridade): (12, 5), (7, 9), (10, 5) e (51, 2). Mostre o estado final da fila.",
                "No exercício anterior, explique por que o valor 10 ficou depois do valor 12, mesmo os dois tendo prioridade 5.",
                "Aplique removerDesenfileirar duas vezes seguidas na fila do primeiro exercício e mostre o estado final.",
                "Explique, com suas palavras, por que a inserção em uma fila de prioridades é O(n), enquanto na fila comum é O(1).",
                "Cite um exemplo do seu cotidiano que funcione como uma fila de prioridades, indicando qual seria o critério de prioridade.",
                "Compare a Fila de Prioridades Encadeada com a Fila Encadeada FIFO estudada anteriormente."
            ]
        ];
    }
}

?>