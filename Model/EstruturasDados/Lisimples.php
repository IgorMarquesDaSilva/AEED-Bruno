<?php

class Lisimples
{
    public function obterConteudo()
    {
        return [
            "titulo" => "Lista Simplesmente Encadeada",

            "introducao" => "Uma lista simplesmente encadeada organiza elementos em nós conectados por uma única direção. Cada nó armazena um valor e uma referência para o próximo nó. Diferente da lista duplamente encadeada, cada nó conhece apenas o próximo elemento.",

            "objetivos" => [
                "Entender como os nós se conectam em um único sentido.",
                "Aprender as principais operações de inserção e remoção.",
                "Comparar lista simplesmente encadeada e lista duplamente encadeada.",
                "Visualizar exemplos implementados em C#."
            ],

            "definicao" => "Uma lista simplesmente encadeada é uma estrutura de dados linear e dinâmica. Cada nó armazena um valor e uma referência: ela aponta apenas para o próximo nó. O acesso é sempre a partir do início (cabeça) em direção ao fim.",

            "contexto" => [
                "Listas aparecem no cotidiano quando organizamos compras, contatos, músicas ou páginas visitadas. Em programação, a ideia é armazenar elementos e permitir operações como inserir, buscar, percorrer e remover.",
                "Em um vetor, os elementos ocupam posições consecutivas e o tamanho costuma precisar ser planejado. Em uma lista encadeada, os nós são criados conforme a necessidade e ficam conectados por referências.",
                "Na lista simplesmente encadeada, cada nó aponta apenas para o próximo. Na lista duplamente encadeada, acrescentamos a referência anterior, permitindo caminhar nos dois sentidos."
            ],

            "representacao" => "[Valor | Próximo] -> [Valor | Próximo] -> [Valor | Próximo] -> null",

            "anatomia" => [
                [
                    "termo" => "Nó",
                    "explicacao" => "Elemento da lista que guarda um valor e uma referência para o próximo nó."
                ],
                [
                    "termo" => "Cabeça ou Início",
                    "explicacao" => "Primeiro nó da lista. É o ponto de entrada obrigatório para qualquer operação."
                ],
                [
                    "termo" => "Cauda ou Fim",
                    "explicacao" => "Último nó da lista. Sua referência Proximo sempre deve ser null."
                ],
                [
                    "termo" => "Ligação",
                    "explicacao" => "Cada nó aponta para o próximo usando a referência Proximo. A navegação é sempre em um único sentido: do início para o fim."
                ]
            ],

            "comoFunciona" => [
                "O primeiro nó é chamado de início ou cabeça da lista.",
                "O último nó é chamado de fim ou cauda da lista.",
                "O primeiro nó não possui anterior — a lista não guarda essa referência.",
                "O último nó não possui próximo: sua referência Proximo é null.",
                "A navegação acontece sempre do início para o fim, seguindo os ponteiros Proximo."
            ],

            "importancia" => "A lista simplesmente encadeada é importante quando o sistema precisa inserir e remover elementos dinamicamente sem desperdício de memória, e a navegação em um único sentido é suficiente.",

            "aplicacoes" => [
                "Filas de impressão ou de processos.",
                "Histórico de ações com desfazer (pilha implementada como lista).",
                "Listas de tarefas percorridas sempre do início ao fim.",
                "Implementação de outras estruturas como pilhas e filas."
            ],

            "operacoes" => [
                [
                    "nome" => "Inserir no início",
                    "descricao" => "O novo nó passa a ser o primeiro e aponta para o antigo início.",
                    "complexidade" => "O(1)"
                ],
                [
                    "nome" => "Inserir no final",
                    "descricao" => "Mantendo uma referência para o fim, o novo nó é conectado diretamente ao último.",
                    "complexidade" => "O(1) com referência ao fim, O(n) sem ela"
                ],
                [
                    "nome" => "Buscar um valor",
                    "descricao" => "Os nós são percorridos desde o início até encontrar o valor desejado.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Remover um nó",
                    "descricao" => "É necessário localizar o nó anterior ao que será removido para religar a cadeia.",
                    "complexidade" => "O(n)"
                ]
            ],

            "insercoes" => [
                [
                    "titulo" => "Inserção no início",
                    "complexidade" => "O(1)",
                    "passos" => [
                        "Criar o novo nó com o valor informado.",
                        "Fazer Proximo do novo nó apontar para o Inicio atual.",
                        "Atualizar Inicio para o novo nó.",
                        "Se a lista estava vazia, atualizar também Fim."
                    ]
                ],
                [
                    "titulo" => "Inserção no final",
                    "complexidade" => "O(1) com referência ao fim",
                    "passos" => [
                        "Criar o novo nó.",
                        "Fazer Proximo do antigo Fim apontar para o novo nó.",
                        "Atualizar Fim para o novo nó.",
                        "Se a lista estava vazia, Inicio recebe o mesmo nó."
                    ]
                ],
                [
                    "titulo" => "Inserção no meio ou ordenada",
                    "complexidade" => "O(n)",
                    "passos" => [
                        "Percorrer a lista até localizar o nó anterior à posição desejada.",
                        "Fazer Proximo do novo nó apontar para o nó seguinte.",
                        "Fazer Proximo do nó anterior apontar para o novo nó.",
                        "A ligação é feita em um único sentido."
                    ]
                ]
            ],

            "remocoes" => [
                [
                    "titulo" => "Remoção no início",
                    "passos" => [
                        "Guardar ou localizar o primeiro nó.",
                        "Fazer Inicio apontar para o segundo nó.",
                        "Se a lista ficou vazia, Fim também passa a ser null.",
                        "O antigo primeiro nó é descartado."
                    ]
                ],
                [
                    "titulo" => "Remoção no final",
                    "passos" => [
                        "Percorrer a lista até o nó anterior ao último.",
                        "Fazer Proximo desse nó anterior receber null.",
                        "Atualizar Fim para esse nó anterior.",
                        "Se a lista ficou vazia, Inicio também passa a ser null."
                    ]
                ],
                [
                    "titulo" => "Remoção no meio",
                    "passos" => [
                        "Percorrer a lista até encontrar o nó anterior ao que será removido.",
                        "Fazer Proximo do anterior apontar diretamente para o nó seguinte ao removido.",
                        "O nó removido deixa de fazer parte da cadeia.",
                        "Não é possível fazer isso em O(1) pois o anterior não está referenciado no nó."
                    ]
                ]
            ],

            "buscaPercurso" => [
                [
                    "titulo" => "Busca",
                    "descricao" => "Começa pelo Inicio e compara os valores até encontrar o procurado ou chegar ao fim.",
                    "complexidade" => "O(n)"
                ],
                [
                    "titulo" => "Percurso para frente",
                    "descricao" => "Começa em Inicio e utiliza Proximo em cada repetição até Proximo ser null.",
                    "complexidade" => "O(n)"
                ],
                [
                    "titulo" => "Percurso para trás",
                    "descricao" => "Não é possível de forma direta, pois não há referência para o anterior. Requer percorrer do início e guardar o caminho, ou usar uma lista duplamente encadeada.",
                    "complexidade" => "O(n) com estrutura auxiliar"
                ]
            ],

            "comparacao" => [
                [
                    "criterio" => "Referências por nó",
                    "simplesmente" => "Somente para o próximo",
                    "duplamente" => "Para o anterior e para o próximo"
                ],
                [
                    "criterio" => "Navegação",
                    "simplesmente" => "Apenas para frente",
                    "duplamente" => "Para frente e para trás"
                ],
                [
                    "criterio" => "Memória",
                    "simplesmente" => "Utiliza menos memória",
                    "duplamente" => "Utiliza mais memória"
                ],
                [
                    "criterio" => "Remoção",
                    "simplesmente" => "Exige percorrer para encontrar o anterior",
                    "duplamente" => "O anterior já está referenciado"
                ]
            ],

            "videos" => [
                [
                    "titulo" => "Videoaula sobre Lista Simplesmente Encadeada",
                    "descricao" => "Vídeo complementar sobre lista simplesmente encadeada para apoiar o estudo das operações.",
                    "fonte" => "YouTube - vídeo complementar",
                    "url" => "https://www.youtube.com/embed/WApQfQwDPSM",
                    "link" => "https://www.youtube.com/watch?v=WApQfQwDPSM"
                ]
            ],

            "orientacaoCodigo" => "Os exemplos seguem o mesmo raciocínio das operações: primeiro definimos o nó e a lista, depois inserimos, percorremos, buscamos e removemos. Os métodos manuais devem ser colocados dentro da classe ListaSimplesmente apresentada no Exemplo 3.",

            "exemplos" => [
                [
                    "titulo" => "Exemplo 1 - Estrutura de um nó",
                    "descricao" => "Cada nó armazena um valor e uma referência apenas para o próximo.",
                    "codigo" => <<<'CSHARP'
#nullable enable

// O nó é a unidade que será conectada aos outros elementos da lista.
public class No
{
    public string Valor { get; set; }

    // Se não houver próximo, a referência será null (fim da lista).
    public No? Proximo { get; set; }

    public No(string valor)
    {
        Valor = valor;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 2 - Usando LinkedList do C#",
                    "descricao" => "O C# possui LinkedList<T>, que implementa uma lista encadeada com operações prontas.",
                    "codigo" => <<<'CSHARP'
using System;
using System.Collections.Generic;

// LinkedList<T> já traz pronta a estrutura de lista encadeada.
LinkedList<string> musicas = new LinkedList<string>();

// Inserções podem ocorrer no início ou no final da lista.
musicas.AddLast("Música A");
musicas.AddLast("Música B");
musicas.AddFirst("Introdução");

// O foreach percorre os elementos do primeiro até o último.
foreach (string musica in musicas)
{
    Console.WriteLine(musica);
}

// Remove o primeiro nó que contenha o valor informado.
musicas.Remove("Música B");
CSHARP
                ],
                [
                    "titulo" => "Exemplo 3 - Inserção manual no final",
                    "descricao" => "Neste exemplo, criamos a operação de inserir sem utilizar uma coleção pronta.",
                    "codigo" => <<<'CSHARP'
#nullable enable

public class ListaSimplesmente
{
    public No? Inicio { get; private set; }
    public No? Fim { get; private set; }

    public void InserirNoFinal(string valor)
    {
        No novo = new No(valor);

        // Na primeira inserção, o mesmo nó é início e fim da lista.
        if (Inicio == null)
        {
            Inicio = novo;
            Fim = novo;
            return;
        }

        // O novo nó vem depois do antigo fim.
        // Como o nó só conhece o próximo, apenas uma ligação é feita.
        Fim!.Proximo = novo;
        Fim = novo;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 4 - Percorrendo do início ao fim",
                    "descricao" => "A lista simplesmente encadeada permite apenas a navegação para frente, usando Proximo.",
                    "codigo" => <<<'CSHARP'
public void ExibirDoInicio()
{
    No? atual = Inicio;

    // Avança usando Proximo até chegar ao fim (null).
    while (atual != null)
    {
        Console.WriteLine(atual.Valor);
        atual = atual.Proximo;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 5 - Inserção manual no início",
                    "descricao" => "O novo nó vira a cabeça e aponta para o antigo Inicio.",
                    "codigo" => <<<'CSHARP'
public void InserirNoInicio(string valor)
{
    No novo = new No(valor);

    // Uma lista vazia passa a ter um único nó nas duas extremidades.
    if (Inicio == null)
    {
        Inicio = novo;
        Fim = novo;
        return;
    }

    // O novo nó aponta para o antigo início. Apenas uma ligação é necessária.
    novo.Proximo = Inicio;
    Inicio = novo;
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 6 - Inserção ordenada no meio",
                    "descricao" => "Nomes são mantidos em ordem alfabética. A ligação é feita apenas para frente.",
                    "codigo" => <<<'CSHARP'
public void InserirOrdenado(string valor)
{
    // Caso o valor venha antes do atual Inicio, ele abre a lista.
    if (Inicio == null ||
        string.Compare(valor, Inicio.Valor,
            System.StringComparison.OrdinalIgnoreCase) <= 0)
    {
        InserirNoInicio(valor);
        return;
    }

    No atual = Inicio;

    // Localiza o nó após o qual o novo valor deverá entrar.
    while (atual.Proximo != null &&
           string.Compare(atual.Proximo.Valor, valor,
               System.StringComparison.OrdinalIgnoreCase) < 0)
    {
        atual = atual.Proximo;
    }

    // Se não existe próximo, a inserção acontece no final.
    if (atual.Proximo == null)
    {
        InserirNoFinal(valor);
        return;
    }

    // Insere entre dois nós. Apenas a referência Proximo é usada.
    No novo = new No(valor);
    novo.Proximo = atual.Proximo;
    atual.Proximo = novo;
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 7 - Buscar um valor",
                    "descricao" => "A busca percorre a lista para frente e devolve o nó encontrado.",
                    "codigo" => <<<'CSHARP'
public No? Buscar(string valor)
{
    No? atual = Inicio;

    // A busca termina ao encontrar o valor ou ao chegar ao final.
    while (atual != null)
    {
        if (atual.Valor == valor)
        {
            return atual;
        }

        atual = atual.Proximo;
    }

    return null;
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 8 - Remover um valor",
                    "descricao" => "É preciso percorrer a lista para encontrar o nó anterior ao que será removido.",
                    "codigo" => <<<'CSHARP'
public bool Remover(string valor)
{
    // Lista vazia: nada a fazer.
    if (Inicio == null) return false;

    // Caso especial: remover o primeiro nó.
    if (Inicio.Valor == valor)
    {
        Inicio = Inicio.Proximo;
        if (Inicio == null) Fim = null;
        return true;
    }

    // Percorre a lista procurando o nó anterior ao que será removido.
    No? anterior = Inicio;
    while (anterior.Proximo != null && anterior.Proximo.Valor != valor)
    {
        anterior = anterior.Proximo;
    }

    // Valor não encontrado.
    if (anterior.Proximo == null) return false;

    // Religa o anterior diretamente ao próximo do removido.
    No removido = anterior.Proximo;
    anterior.Proximo = removido.Proximo;

    // Se o removido era o fim, atualiza Fim.
    if (removido.Proximo == null) Fim = anterior;

    return true;
}
CSHARP
                ]
            ],

            "exercicios" => [
                "Desenhe uma lista com os valores 7, 10, 12 e 51, mostrando apenas o ponteiro Proximo em cada nó.",
                "Use InserirNoInicio e InserirNoFinal para criar uma lista de três disciplinas.",
                "Implemente RemoverNoInicio e RemoverNoFinal sem usar o método Buscar.",
                "Altere InserirOrdenado para armazenar números inteiros em ordem crescente.",
                "Implemente um método que percorra a lista ao contrário usando uma pilha auxiliar.",
                "Monte uma lista de tarefas e implemente um método que exiba apenas as tarefas de índice par.",
                "Explique por que a remoção de um nó no meio em uma lista simplesmente encadeada exige O(n) e não O(1)."
            ]
        ];
    }
}
?>