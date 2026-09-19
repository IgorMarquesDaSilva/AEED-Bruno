<?php

class Pilha
{
    public function obterConteudo()
    {
        return [
            "titulo" => "Pilha Encadeada - LIFO",

            "introducao" => "Uma pilha encadeada organiza elementos em nós conectados, seguindo a regra LIFO (Last in First out): o último elemento que entra na pilha é o primeiro que sai.",

            "objetivos" => [
                "Entender o conceito de pilha e a regra LIFO.",
                "Reconhecer o Topo como único ponto de acesso de uma pilha encadeada.",
                "Aprender as operações de inserção (push) e remoção (pop).",
                "Compreender as operações de busca e percurso em uma pilha.",
                "Visualizar exemplos implementados em C#."
            ],

            "definicao" => "Uma pilha é uma Estrutura de Dados que possibilita armazenar e manipular um conjunto de dados seguindo o princípio LIFO - Last in First Out: o primeiro elemento a ser inserido é o último a ser retirado. Essa estrutura também é conhecida pelo Tipo Abstrato de Dados (TAD) stack.",

            "contexto" => [
                "Utilizamos pilhas em diversas situações do nosso cotidiano: uma pilha de pratos, uma pilha de folhas ou documentos. Em ambos os casos, o último item colocado é sempre o primeiro a ser retirado.",
                "A Estrutura de Dados PILHA pode ser implementada de diferentes modos, como por vetor ou por pilha encadeada. Na pilha encadeada, cada nó conhece e é conectado com o seu sucessor, assim como ocorre na lista simplesmente encadeada e na fila.",
                "A diferença de uma pilha para uma lista genérica ou para uma fila está nas regras de acesso: a pilha só permite inserir e remover elementos pelo mesmo lado, chamado de Topo."
            ],

            "representacao" => '<svg viewBox="0 0 320 300" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Pilha encadeada com Topo apontando para o nó 12, seguido de 7, 51 e 10, terminando em NULL" style="max-width:340px;">
                <text x="10" y="24" font-family="Consolas, monospace" font-size="14" font-weight="bold" fill="#123554">Topo (início)</text>
                <path d="M100 20 h30" stroke="#0f766e" stroke-width="2" fill="none" marker-end="url(#seta)"/>
                <defs>
                    <marker id="seta" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                        <path d="M0,0 L6,3 L0,6 Z" fill="#0f766e"/>
                    </marker>
                </defs>
                <g font-family="Consolas, monospace" font-size="14" fill="#123554">
                    <g transform="translate(140,10)">
                        <rect width="90" height="40" fill="#fff8ee" stroke="#123554" stroke-width="1.5"/>
                        <line x1="60" y1="0" x2="60" y2="40" stroke="#123554" stroke-width="1.5"/>
                        <text x="25" y="25" text-anchor="middle">12</text>
                        <line x1="75" y1="40" x2="75" y2="65" stroke="#0f766e" stroke-width="2" marker-end="url(#seta2)"/>
                    </g>
                    <g transform="translate(140,75)">
                        <rect width="90" height="40" fill="#ffffff" stroke="#123554" stroke-width="1.5"/>
                        <line x1="60" y1="0" x2="60" y2="40" stroke="#123554" stroke-width="1.5"/>
                        <text x="25" y="25" text-anchor="middle">7</text>
                        <line x1="75" y1="40" x2="75" y2="65" stroke="#0f766e" stroke-width="2" marker-end="url(#seta2)"/>
                    </g>
                    <g transform="translate(140,140)">
                        <rect width="90" height="40" fill="#ffffff" stroke="#123554" stroke-width="1.5"/>
                        <line x1="60" y1="0" x2="60" y2="40" stroke="#123554" stroke-width="1.5"/>
                        <text x="25" y="25" text-anchor="middle">51</text>
                        <line x1="75" y1="40" x2="75" y2="65" stroke="#0f766e" stroke-width="2" marker-end="url(#seta2)"/>
                    </g>
                    <g transform="translate(140,205)">
                        <rect width="90" height="40" fill="#ffffff" stroke="#123554" stroke-width="1.5"/>
                        <line x1="60" y1="0" x2="60" y2="40" stroke="#123554" stroke-width="1.5"/>
                        <text x="25" y="25" text-anchor="middle">10</text>
                        <line x1="75" y1="40" x2="75" y2="65" stroke="#0f766e" stroke-width="2" marker-end="url(#seta2)"/>
                    </g>
                </g>
                <defs>
                    <marker id="seta2" markerWidth="8" markerHeight="8" refX="4" refY="6" orient="auto">
                        <path d="M0,0 L8,0 L4,8 Z" fill="#0f766e"/>
                    </marker>
                </defs>
                <text x="185" y="290" text-anchor="middle" font-family="Consolas, monospace" font-size="14" font-weight="bold" fill="#0f766e">NULL</text>
            </svg>',

            "anatomia" => [
                [
                    "termo" => "Nó",
                    "explicacao" => "Cada elemento da pilha é chamado de Nó. Ele guarda um Valor e uma referência Prox, que aponta para o próximo nó da pilha."
                ],
                [
                    "termo" => "Topo (início)",
                    "explicacao" => "É o único ponto de acesso da pilha. É por ele que os elementos são inseridos (push) e removidos (pop)."
                ],
                [
                    "termo" => "Prox",
                    "explicacao" => "Referência de cada nó para o próximo nó da pilha. O Prox do último nó da pilha sempre aponta para NULL."
                ]
            ],

            "comoFunciona" => [
                "O primeiro nó da pilha é chamado de Topo (início).",
                "O Prox do último nó da pilha sempre aponta para NULL.",
                "Novos elementos só podem ser inseridos no Topo da pilha.",
                "Elementos só podem ser removidos do Topo da pilha.",
                "Diferente da fila, a pilha insere e remove sempre pelo mesmo lado."
            ],

            "importancia" => "A pilha é importante sempre que a última ação ou o último elemento inserido precisa ser o primeiro a ser tratado, como ao desfazer uma ação ou voltar para a página anterior de um site.",

            "aplicacoes" => [
                "Histórico de navegação de um navegador (botão Voltar).",
                "Função de desfazer (Ctrl+Z) em editores de texto e imagem.",
                "Pilha de chamadas de função (call stack) durante a execução de um programa.",
                "Verificação de parênteses e colchetes balanceados em expressões.",
                "Avaliação de expressões matemáticas em notação pós-fixada."
            ],

            "operacoes" => [
                [
                    "nome" => "Inserção (PUSH)",
                    "descricao" => "Insere um novo nó sempre no Topo da pilha.",
                    "complexidade" => "O(1)"
                ],
                [
                    "nome" => "Remoção (POP)",
                    "descricao" => "Remove sempre o nó que está no Topo da pilha.",
                    "complexidade" => "O(1)"
                ],
                [
                    "nome" => "Busca (Consulta)",
                    "descricao" => "Percorre a pilha a partir do Topo até localizar o valor desejado.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Percurso",
                    "descricao" => "Percorre todos os nós da pilha, do Topo até o final, para exibir ou processar os valores.",
                    "complexidade" => "O(n)"
                ]
            ],

            "insercoes" => [
                [
                    "titulo" => "Inserção no Topo (PUSH)",
                    "complexidade" => "O(1)",
                    "passos" => [
                        "Criar o novo nó com o valor informado.",
                        "Se a pilha estiver vazia, o novo nó passa a ser o Topo da pilha.",
                        "Caso contrário, fazer o Prox do novo nó apontar para o nó que atualmente é o Topo.",
                        "Tornar o novo nó o novo Topo (início) da pilha."
                    ]
                ]
            ],

            "remocoes" => [
                [
                    "titulo" => "Remoção no Topo (POP)",
                    "passos" => [
                        "Verificar se a pilha está vazia; se estiver, não há o que remover.",
                        "Guardar em um nó auxiliar a referência do nó que está no Topo.",
                        "Fazer o Topo apontar para o Prox do nó que estava no Topo.",
                        "O antigo nó do Topo deixa de fazer parte da pilha."
                    ]
                ]
            ],

            "buscaPercurso" => [
                [
                    "titulo" => "Busca (Consulta)",
                    "descricao" => "Começa pelo Topo e compara os valores nó a nó até encontrar o valor procurado ou chegar ao fim da pilha.",
                    "complexidade" => "O(n)"
                ],
                [
                    "titulo" => "Percurso",
                    "descricao" => "Começa no Topo e utiliza o Prox de cada nó até chegar em NULL, exibindo todos os valores na ordem da pilha.",
                    "complexidade" => "O(n)"
                ]
            ],

            "comparacao" => [
                [
                    "criterio" => "Regra de acesso",
                    "fila" => "Insere no fim e remove no início",
                    "pilha" => "Insere e remove sempre pelo mesmo lado (Topo)"
                ],
                [
                    "criterio" => "Princípio",
                    "fila" => "FIFO - primeiro que entra é o primeiro que sai",
                    "pilha" => "LIFO - último que entra é o primeiro que sai"
                ],
                [
                    "criterio" => "Referências por nó",
                    "fila" => "Somente para o próximo (Prox)",
                    "pilha" => "Somente para o próximo (Prox)"
                ],
                [
                    "criterio" => "Aplicações típicas",
                    "fila" => "Filas de espera, filas de impressão, filas de processos",
                    "pilha" => "Desfazer ações, histórico de navegação, chamadas de função"
                ]
            ],

            "orientacaoCodigo" => "Os exemplos seguem o mesmo raciocínio das operações: primeiro definimos o nó e a pilha, depois inserimos (push), removemos (pop), buscamos e percorremos. Os métodos ficam dentro das classes No e Pilha.",

            "exemplos" => [
                [
                    "titulo" => "Exemplo 1 - Classe No",
                    "descricao" => "Cada nó da pilha guarda um valor e a referência Prox para o próximo nó.",
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
                    "titulo" => "Exemplo 2 - Classe Pilha e verificação de pilha vazia",
                    "descricao" => "A pilha mantém apenas a referência para o Topo, único ponto de acesso da estrutura.",
                    "codigo" => <<<'CSHARP'
public class Pilha
{
    public No topo;

    public Pilha()
    {
        this.topo = null;
    }

    public Boolean estaVazia()
    {
        if (this.topo == null)
        {
            return (true);
        }
        return (false);
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 3 - Inserção (PUSH)",
                    "descricao" => "O novo nó é sempre inserido no Topo da pilha.",
                    "codigo" => <<<'CSHARP'
public void push(int Valor)
{
    // CRIAR NOVO NO
    No novoNo = new No(Valor);

    if (estaVazia() == true)
    { // PILHA VAZIA!
        this.topo = novoNo;
    }
    else
    {
        novoNo.prox = this.topo; // O prox do novo no aponta para o antigo Topo
        this.topo = novoNo;      // O novo no passa a ser o Topo
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 4 - Remoção (POP)",
                    "descricao" => "A remoção acontece sempre no Topo da pilha.",
                    "codigo" => <<<'CSHARP'
public No pop()
{
    No aux = null;

    if (estaVazia() == true)
    {
        return (aux);
    }
    else
    { // Remoção do Topo da pilha
        aux = this.topo;
        this.topo = this.topo.prox;
        return (aux);
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 5 - Busca (Consulta)",
                    "descricao" => "A busca percorre a pilha a partir do Topo até encontrar o valor ou chegar ao final.",
                    "codigo" => <<<'CSHARP'
public Boolean consulta(int valor, ref No noAtual, ref No noAnterior)
{
    noAtual = this.topo;
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
                    "descricao" => "O percurso exibe todos os elementos da pilha, do Topo até o final.",
                    "codigo" => <<<'CSHARP'
public void imprimir()
{
    No noAux = this.topo;

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
                "Desenhe uma pilha com os valores 12, 7, 51 e 10 inseridos nessa ordem, destacando o Topo e o Prox de cada nó.",
                "Use o método push para inserir os valores 5, 8 e 20 em uma pilha vazia e desenhe o resultado.",
                "Aplique o método pop duas vezes seguidas na pilha do exercício anterior e mostre o estado final.",
                "Explique por que a pilha não permite inserir ou remover um elemento que não esteja no Topo.",
                "Implemente um método que conte quantos elementos existem na pilha, percorrendo-a a partir do Topo.",
                "Cite um exemplo do seu cotidiano que funcione como uma pilha (LIFO) e outro que funcione como uma fila (FIFO).",
                "Compare a Pilha Encadeada com a Fila Encadeada estudada anteriormente, apontando a principal diferença na regra de acesso."
            ]
        ];
    }
}
?>