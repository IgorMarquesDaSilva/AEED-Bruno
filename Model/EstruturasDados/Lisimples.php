<?php

class Lisimples
{
    public function obterConteudo()
    {
        return [
            "titulo" => "Lista Simplesmente Encadeada",

            "introducao" => "Uma lista simplesmente encadeada organiza elementos em nós conectados por uma única direção. Cada nó armazena um valor e uma referência para o próximo nó. Diferente de um array, os elementos não ocupam posições contíguas na memória — eles crescem e encolhem dinamicamente conforme a necessidade.",

            "objetivos" => [
                "Compreender o que é uma lista simplesmente encadeada e como ela difere de um array convencional.",
                "Entender a estrutura de um nó e os papéis da cabeça (início) e da cauda (fim) da lista.",
                "Implementar as operações de inserção, remoção e busca com controle correto dos ponteiros.",
                "Analisar a complexidade de tempo (Big O) de cada operação e seus impactos práticos.",
                "Comparar a lista simplesmente encadeada com a lista duplamente encadeada e identificar quando usar cada uma.",
                "Escrever e interpretar código C# com implementação real de lista encadeada genérica."
            ],

            "definicao" => "Uma lista simplesmente encadeada é uma estrutura de dados linear e dinâmica formada por uma sequência de nós. Cada nó armazena um valor e uma única referência: ela aponta apenas para o próximo nó. O acesso é sempre a partir do início (cabeça) em direção ao fim, seguindo os ponteiros Proximo.",

            "contexto" => [
                "Listas aparecem no cotidiano quando organizamos compras, contatos, músicas ou páginas visitadas. Em programação, a ideia é armazenar elementos e permitir operações como inserir, buscar, percorrer e remover.",
                "Em um vetor, os elementos ocupam posições consecutivas na memória e o tamanho costuma precisar ser planejado com antecedência. Em uma lista encadeada, os nós são criados conforme a necessidade e ficam conectados por referências — não precisam estar próximos na memória.",
                "Na lista simplesmente encadeada, cada nó aponta apenas para o próximo. Na lista duplamente encadeada, acrescentamos a referência anterior, permitindo caminhar nos dois sentidos. A versão simples usa menos memória, mas perde a navegação inversa."
            ],

            "representacao" => "[Valor | Próximo] -> [Valor | Próximo] -> [Valor | Próximo] -> null",

            "anatomia" => [
                [
                    "termo" => "Nó",
                    "explicacao" => "Elemento da lista que guarda um valor e uma referência para o próximo nó. É o bloco construtivo da estrutura. Quando não há próximo, a referência é null."
                ],
                [
                    "termo" => "Cabeça ou Início",
                    "explicacao" => "Primeiro nó da lista. É o ponto de entrada obrigatório para qualquer operação. Se a lista estiver vazia, o início é null."
                ],
                [
                    "termo" => "Cauda ou Fim",
                    "explicacao" => "Último nó da lista. Sua referência Proximo sempre deve ser null, sinalizando o término da cadeia. Mantê-la permite inserção no final em O(1)."
                ],
                [
                    "termo" => "Ligação (Proximo)",
                    "explicacao" => "Cada nó aponta para o próximo usando a referência Proximo. A navegação é sempre em um único sentido — do início para o fim. Não há como voltar sem percorrer a lista desde o início novamente."
                ]
            ],

            "comoFunciona" => [
                "O primeiro nó é chamado de início ou cabeça da lista.",
                "O último nó é chamado de fim ou cauda da lista.",
                "O primeiro nó não possui anterior — a lista não guarda essa referência.",
                "O último nó não possui próximo: sua referência Proximo é null.",
                "A navegação acontece sempre do início para o fim, seguindo os ponteiros Proximo.",
                "Não é possível acessar um elemento diretamente por índice como em um array — é preciso percorrer desde o início."
            ],

            "importancia" => "A lista simplesmente encadeada é importante quando o sistema precisa inserir e remover elementos dinamicamente sem desperdício de memória, e a navegação em um único sentido é suficiente. Ela serve de base para pilhas, filas e outras estruturas mais complexas.",

            "aplicacoes" => [
                "Filas de impressão ou de processos do sistema operacional.",
                "Histórico de ações com desfazer (pilha implementada como lista).",
                "Listas de tarefas percorridas sempre do início ao fim.",
                "Implementação de pilhas e filas como estruturas de alto nível.",
                "Gerenciamento de memória livre em sistemas embarcados.",
                "Representação de adjacências em grafos (lista de adjacência)."
            ],

            "operacoes" => [
                [
                    "nome" => "Inserir no início",
                    "descricao" => "O novo nó passa a ser o primeiro e aponta para o antigo início. Não é necessário percorrer nada.",
                    "complexidade" => "O(1)"
                ],
                [
                    "nome" => "Inserir no final",
                    "descricao" => "Mantendo uma referência para o fim, o novo nó é conectado diretamente ao último. Sem essa referência, é necessário percorrer a lista inteira.",
                    "complexidade" => "O(1) com ref. ao fim"
                ],
                [
                    "nome" => "Inserir no meio",
                    "descricao" => "Percorre a lista até a posição desejada e ajusta os ponteiros ao redor do novo nó. O custo vem do percurso.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Remover do início",
                    "descricao" => "Avança o início para o segundo nó. É a operação de remoção mais eficiente da lista.",
                    "complexidade" => "O(1)"
                ],
                [
                    "nome" => "Remover do final",
                    "descricao" => "Exige percorrer até o penúltimo nó para desconectar o fim. Mesmo com referência ao tail, o custo é linear.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Remover por valor",
                    "descricao" => "Percorre a lista comparando valores até encontrar o alvo e religa o nó anterior diretamente ao seguinte.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Buscar um valor",
                    "descricao" => "Os nós são percorridos desde o início até encontrar o valor desejado. Não há acesso aleatório — busca binária não é possível.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Percorrer a lista",
                    "descricao" => "Visita todos os nós do início ao fim para exibir, somar, contar ou qualquer operação que dependa de todos os elementos.",
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
                        "Se a lista estava vazia, atualizar também Fim para o mesmo nó."
                    ]
                ],
                [
                    "titulo" => "Inserção no final",
                    "complexidade" => "O(1) com referência ao fim",
                    "passos" => [
                        "Criar o novo nó com o valor informado.",
                        "Fazer Proximo do antigo Fim apontar para o novo nó.",
                        "Atualizar Fim para o novo nó.",
                        "Se a lista estava vazia, Inicio e Fim recebem o mesmo nó."
                    ]
                ],
                [
                    "titulo" => "Inserção no meio ou ordenada",
                    "complexidade" => "O(n)",
                    "passos" => [
                        "Percorrer a lista até localizar o nó anterior à posição desejada.",
                        "Fazer Proximo do novo nó apontar para o nó seguinte ao anterior.",
                        "Fazer Proximo do nó anterior apontar para o novo nó.",
                        "Se o novo nó ficou após o último, atualizar Fim."
                    ]
                ]
            ],

            "remocoes" => [
                [
                    "titulo" => "Remoção no início",
                    "passos" => [
                        "Guardar o valor do primeiro nó, se necessário.",
                        "Fazer Inicio apontar para o segundo nó (Inicio.Proximo).",
                        "Se a lista ficou vazia (Inicio virou null), Fim também passa a ser null.",
                        "O antigo primeiro nó deixa de ser referenciado e é coletado pelo GC."
                    ]
                ],
                [
                    "titulo" => "Remoção no final",
                    "passos" => [
                        "Percorrer a lista até o nó anterior ao último (nó cujo Proximo == Fim).",
                        "Fazer Proximo desse nó anterior receber null.",
                        "Atualizar Fim para esse nó anterior.",
                        "Se a lista ficou com apenas um nó e ele foi removido, Inicio também passa a ser null."
                    ]
                ],
                [
                    "titulo" => "Remoção no meio por valor",
                    "passos" => [
                        "Percorrer a lista até encontrar o nó anterior ao que será removido.",
                        "Fazer Proximo do anterior apontar diretamente para o nó seguinte ao removido.",
                        "O nó removido deixa de fazer parte da cadeia.",
                        "Não é possível fazer isso em O(1) pois o anterior não está referenciado no próprio nó — é a principal limitação frente à lista duplamente encadeada."
                    ]
                ]
            ],

            "buscaPercurso" => [
                [
                    "titulo" => "Busca por valor",
                    "descricao" => "Começa pelo Inicio e compara os valores nó a nó até encontrar o procurado ou chegar ao fim da lista. Retorna o nó ou null se não encontrar.",
                    "complexidade" => "O(n)"
                ],
                [
                    "titulo" => "Percurso para frente",
                    "descricao" => "Começa em Inicio e utiliza Proximo em cada iteração até Proximo ser null. Usado para exibir, contar, somar ou qualquer operação sobre todos os elementos.",
                    "complexidade" => "O(n)"
                ],
                [
                    "titulo" => "Percurso para trás",
                    "descricao" => "Não é possível de forma direta, pois não há referência para o anterior. Requer percorrer do início guardando o caminho em uma pilha auxiliar, ou utilizar uma lista duplamente encadeada.",
                    "complexidade" => "O(n) com estrutura auxiliar"
                ]
            ],

            "comparacao" => [
                [
                    "criterio" => "Referências por nó",
                    "simples" => "Somente para o próximo",
                    "dupla" => "Para o anterior e para o próximo"
                ],
                [
                    "criterio" => "Navegação",
                    "simples" => "Apenas para frente",
                    "dupla" => "Para frente e para trás"
                ],
                [
                    "criterio" => "Uso de memória",
                    "simples" => "Menor — um ponteiro por nó",
                    "dupla" => "Maior — dois ponteiros por nó"
                ],
                [
                    "criterio" => "Remoção no meio",
                    "simples" => "Exige percorrer para encontrar o nó anterior: O(n)",
                    "dupla" => "O anterior já está referenciado no próprio nó: O(1) após localizar"
                ],
                [
                    "criterio" => "Inserção no início",
                    "simples" => "O(1)",
                    "dupla" => "O(1)"
                ],
                [
                    "criterio" => "Complexidade de implementação",
                    "simples" => "Menor — menos ponteiros para gerenciar",
                    "dupla" => "Maior — dois ponteiros precisam ser atualizados em cada operação"
                ]
            ],

            "videos" => [
                [
                    "titulo" => "Videoaula sobre Lista Simplesmente Encadeada",
                    "descricao" => "Vídeo complementar sobre lista simplesmente encadeada para apoiar o estudo das operações.",
                    "fonte" => "YouTube - vídeo complementar",
                    "url" => "https://www.youtube.com/watch?v=Uk8v7gB2rHk",
                    "link" => "https://youtu.be/Uk8v7gB2rHk?si=ZAxxiHEFQIZB05bw"
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
                "Desenhe uma lista com os valores 7, 10, 12 e 51, representando os nós com [Valor | Proximo] e mostrando que o último aponta para null.",
                "Use InserirNoInicio e InserirNoFinal para criar uma lista de três disciplinas e exiba o resultado percorrendo com ExibirDoInicio.",
                "Implemente RemoverNoInicio e RemoverNoFinal sem usar o método Buscar. Teste com uma lista de cinco elementos.",
                "Altere InserirOrdenado para armazenar números inteiros em ordem crescente em vez de strings.",
                "Implemente um método ContarNos que percorra a lista e retorne o número de elementos sem usar nenhuma propriedade de tamanho.",
                "Implemente um método que percorra a lista ao contrário usando uma pilha auxiliar (Stack<string>) e exiba os valores em ordem inversa.",
                "Explique por escrito por que a remoção de um nó no meio em uma lista simplesmente encadeada exige O(n) e como a lista duplamente encadeada resolve esse problema."
            ]
        ];
    }
}
?>