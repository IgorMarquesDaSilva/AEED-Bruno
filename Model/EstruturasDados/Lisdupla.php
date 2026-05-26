<?php

class Lisdupla
{
    public function obterConteudo()
    {
        return [
            "titulo" => "Lista Duplamente Encadeada",

            "introducao" => "Uma lista duplamente encadeada organiza elementos em nós conectados. Diferente da lista simplesmente encadeada, cada nó conhece o elemento anterior e o próximo elemento.",

            "objetivos" => [
                "Entender como os nós se conectam em dois sentidos.",
                "Aprender as principais operações de inserção e remoção.",
                "Comparar lista simples e lista dupla.",
                "Visualizar exemplos implementados em C#."
            ],

            "definicao" => "Uma lista duplamente encadeada é uma estrutura de dados linear e dinâmica. Cada nó armazena um valor e duas referências: uma aponta para o nó anterior e outra aponta para o próximo nó.",

            "contexto" => [
                "Listas aparecem no cotidiano quando organizamos compras, contatos, músicas ou páginas visitadas. Em programação, a ideia é armazenar elementos e permitir operações como inserir, buscar, percorrer e remover.",
                "Em um vetor, os elementos ocupam posições consecutivas e o tamanho costuma precisar ser planejado. Em uma lista encadeada, os nós são criados conforme a necessidade e ficam conectados por referências.",
                "Na lista simplesmente encadeada vista em aula, cada nó aponta apenas para o próximo. Na lista dupla, acrescentamos a referência anterior, permitindo caminhar nos dois sentidos."
            ],

            "representacao" => "null <- [Anterior | Valor | Próximo] <-> [Anterior | Valor | Próximo] <-> [Anterior | Valor | Próximo] -> null",

            "anatomia" => [
                [
                    "termo" => "Nó",
                    "explicacao" => "Elemento da lista que guarda um valor, uma referência para o anterior e uma para o próximo."
                ],
                [
                    "termo" => "Cabeça ou Início",
                    "explicacao" => "Primeiro nó da lista. Sua referência Anterior sempre deve ser null."
                ],
                [
                    "termo" => "Cauda ou Fim",
                    "explicacao" => "Último nó da lista. Sua referência Proximo sempre deve ser null."
                ],
                [
                    "termo" => "Ligações",
                    "explicacao" => "Dois nós vizinhos precisam concordar: um aponta para frente e o outro aponta de volta."
                ]
            ],

            "comoFunciona" => [
                "O primeiro nó é chamado de início ou cabeça da lista.",
                "O último nó é chamado de fim ou cauda da lista.",
                "O primeiro nó não possui anterior.",
                "O último nó não possui próximo.",
                "A navegação pode acontecer do início para o fim ou do fim para o início."
            ],

            "importancia" => "A lista dupla é importante quando o sistema precisa navegar para frente e para trás ou remover elementos com facilidade depois que o nó foi encontrado.",

            "aplicacoes" => [
                "Histórico de páginas visitadas em um navegador.",
                "Lista de músicas com botões anterior e próxima.",
                "Sistemas de desfazer e refazer ações.",
                "Galerias de imagens com navegação nos dois sentidos."
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
                    "complexidade" => "O(1)"
                ],
                [
                    "nome" => "Buscar um valor",
                    "descricao" => "Os nós são percorridos até encontrar o valor desejado.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Remover um nó conhecido",
                    "descricao" => "O nó anterior e o próximo passam a apontar um para o outro.",
                    "complexidade" => "O(1)"
                ]
            ],

            "insercoes" => [
                [
                    "titulo" => "Inserção no início",
                    "complexidade" => "O(1)",
                    "passos" => [
                        "Criar o novo nó com o valor informado.",
                        "Fazer Proximo do novo nó apontar para o Inicio atual.",
                        "Se a lista não estiver vazia, fazer Anterior do antigo Inicio apontar para o novo nó.",
                        "Atualizar Inicio. Se era a primeira inserção, atualizar também Fim."
                    ]
                ],
                [
                    "titulo" => "Inserção no final",
                    "complexidade" => "O(1)",
                    "passos" => [
                        "Criar o novo nó.",
                        "Fazer Anterior do novo nó apontar para o Fim atual.",
                        "Se a lista não estiver vazia, fazer Proximo do antigo Fim apontar para o novo nó.",
                        "Atualizar Fim. Se a lista estava vazia, Inicio recebe o mesmo nó."
                    ]
                ],
                [
                    "titulo" => "Inserção no meio ou ordenada",
                    "complexidade" => "O(n)",
                    "passos" => [
                        "Percorrer a lista até localizar a posição correta.",
                        "Ligar o novo nó ao nó anterior e ao próximo nó.",
                        "Alterar Proximo do anterior para o novo nó.",
                        "Alterar Anterior do próximo para o novo nó."
                    ]
                ]
            ],

            "remocoes" => [
                [
                    "titulo" => "Remoção no início",
                    "passos" => [
                        "Guardar ou localizar o primeiro nó.",
                        "Fazer Inicio apontar para o segundo nó.",
                        "Se existir novo Inicio, remover sua ligação Anterior.",
                        "Se a lista ficou vazia, Fim também passa a ser null."
                    ]
                ],
                [
                    "titulo" => "Remoção no final",
                    "passos" => [
                        "Usar a referência Fim para localizar o último nó.",
                        "Fazer Fim apontar para o nó anterior.",
                        "Se existir novo Fim, remover sua ligação Proximo.",
                        "Se a lista ficou vazia, Inicio também passa a ser null."
                    ]
                ],
                [
                    "titulo" => "Remoção no meio",
                    "passos" => [
                        "Buscar o nó que possui o valor desejado.",
                        "Ligar o nó anterior diretamente ao próximo.",
                        "Ligar o nó próximo diretamente ao anterior.",
                        "O nó removido deixa de fazer parte da cadeia."
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
                    "descricao" => "Começa em Inicio e utiliza Proximo em cada repetição.",
                    "complexidade" => "O(n)"
                ],
                [
                    "titulo" => "Percurso para trás",
                    "descricao" => "Começa em Fim e utiliza Anterior, possibilidade que diferencia a lista dupla.",
                    "complexidade" => "O(n)"
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
                    "criterio" => "Memória",
                    "simples" => "Utiliza menos memória",
                    "dupla" => "Utiliza mais memória"
                ],
                [
                    "criterio" => "Remoção",
                    "simples" => "Pode exigir procurar o anterior",
                    "dupla" => "O anterior já está referenciado"
                ]
            ],

            "videos" => [
                [
                    "titulo" => "Videoaula sobre Lista Duplamente Encadeada",
                    "descricao" => "Vídeo complementar sobre lista duplamente encadeada para apoiar o estudo das operações.",
                    "fonte" => "YouTube - vídeo complementar",
                    "url" => "https://www.youtube.com/embed/WApQfQwDPSM",
                    "link" => "https://www.youtube.com/watch?v=WApQfQwDPSM"
                ]
            ],

            "orientacaoCodigo" => "Os exemplos seguem o mesmo raciocínio das operações: primeiro definimos o nó e a lista, depois inserimos, percorremos, buscamos e removemos. Os métodos manuais devem ser colocados dentro da classe ListaDupla apresentada no Exemplo 3.",

            "exemplos" => [
                [
                    "titulo" => "Exemplo 1 - Estrutura de um nó",
                    "descricao" => "Cada nó armazena um valor e referências para os dois vizinhos.",
                    "codigo" => <<<'CSHARP'
#nullable enable

// O nó é a unidade que será conectada aos outros elementos da lista.
public class No
{
    public string Valor { get; set; }

    // Se não houver vizinho em alguma direção, a referência será null.
    public No? Anterior { get; set; }
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
                    "descricao" => "O C# possui LinkedList<T>, que implementa uma lista duplamente encadeada.",
                    "codigo" => <<<'CSHARP'
using System;
using System.Collections.Generic;

// LinkedList<T> já traz pronta a estrutura de lista duplamente encadeada.
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

public class ListaDupla
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

        // O novo nó vem depois do antigo fim, ligando as duas direções.
        novo.Anterior = Fim;
        Fim!.Proximo = novo;
        Fim = novo;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 4 - Percorrendo nos dois sentidos",
                    "descricao" => "Uma vantagem da lista dupla é poder exibir os dados de frente para trás e de trás para frente.",
                    "codigo" => <<<'CSHARP'
public void ExibirDoInicio()
{
    No? atual = Inicio;

    // Avança usando Proximo até chegar depois do fim.
    while (atual != null)
    {
        Console.WriteLine(atual.Valor);
        atual = atual.Proximo;
    }
}

public void ExibirDoFim()
{
    No? atual = Fim;

    // Retorna usando Anterior até passar do início.
    while (atual != null)
    {
        Console.WriteLine(atual.Valor);
        atual = atual.Anterior;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 5 - Inserção manual no início",
                    "descricao" => "O novo nó vira a cabeça e o antigo Inicio recebe a ligação de volta.",
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

    // O antigo início passa a reconhecer o novo nó como anterior.
    novo.Proximo = Inicio;
    Inicio.Anterior = novo;
    Inicio = novo;
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 6 - Inserção ordenada no meio",
                    "descricao" => "Neste exemplo, nomes são mantidos em ordem alfabética e as duas ligações são atualizadas.",
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

    // Insere entre dois nós e mantém os dois sentidos conectados.
    No novo = new No(valor);
    novo.Anterior = atual;
    novo.Proximo = atual.Proximo;
    atual.Proximo.Anterior = novo;
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
                    "descricao" => "Depois da busca, basta religar os vizinhos do nó removido.",
                    "codigo" => <<<'CSHARP'
public bool Remover(string valor)
{
    No? removido = Buscar(valor);

    // Se o valor não foi encontrado, nenhuma alteração é feita.
    if (removido == null)
    {
        return false;
    }

    // Religa o lado esquerdo ou atualiza o início da lista.
    if (removido.Anterior != null)
    {
        removido.Anterior.Proximo = removido.Proximo;
    }
    else
    {
        Inicio = removido.Proximo;
    }

    // Religa o lado direito ou atualiza o fim da lista.
    if (removido.Proximo != null)
    {
        removido.Proximo.Anterior = removido.Anterior;
    }
    else
    {
        Fim = removido.Anterior;
    }

    return true;
}
CSHARP
                ]
            ],

            "exercicios" => [
                "Desenhe uma lista com os valores 7, 10, 12 e 51, mostrando Anterior e Proximo em cada nó.",
                "Use InserirNoInicio e InserirNoFinal para criar uma lista de três disciplinas.",
                "Implemente RemoverNoInicio e RemoverNoFinal usando as referências Inicio e Fim.",
                "Altere InserirOrdenado para armazenar números inteiros em ordem crescente.",
                "Implemente um método que remova um valor informado pelo usuário.",
                "Monte uma lista de páginas visitadas com as opções anterior e próxima.",
                "Explique por que a lista dupla utiliza mais memória que a lista simples."
            ]
        ];
    }
}
