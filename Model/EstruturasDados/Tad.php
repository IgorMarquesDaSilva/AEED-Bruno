<?php

class Tad
{
    public function obterConteudo()
    {
        return [
            "titulo" => "TAD - Tipo Abstrato de Dados",

            "introducao" => "Um Tipo Abstrato de Dados organiza uma ideia em duas partes principais: os dados que serão armazenados e as operações que podem ser realizadas sobre esses dados.",

            "objetivos" => [
                "Entender o conceito de Tipo Abstrato de Dados.",
                "Compreender a relação entre dados e operações.",
                "Perceber como o TAD ajuda a esconder detalhes internos de implementação.",
                "Relacionar TAD com struct em C#.",
                "Visualizar exemplos práticos usando um TAD de Cliente."
            ],

            "definicao" => "TAD, ou Tipo Abstrato de Dados, é uma estrutura que encapsula os dados que podem ser armazenados e as operações possíveis de serem realizadas sobre eles.",

            "contexto" => [
                "Em Estrutura de Dados, não basta guardar informações. Também é necessário definir quais ações podem ser feitas com essas informações.",
                "Por exemplo, um Cliente possui dados como nome, CPF, data de nascimento e e-mail. Porém, também pode ter operações, como imprimir seus dados na tela.",
                "A ideia do TAD é separar o que o usuário pode fazer com a estrutura dos detalhes internos de como ela foi implementada."
            ],

            "representacao" => "TAD = Dados + Operações",

            "componentes" => [
                [
                    "termo" => "Dados",
                    "explicacao" => "São as informações armazenadas pelo TAD, como nome, CPF, e-mail ou qualquer outro atributo necessário."
                ],
                [
                    "termo" => "Operações",
                    "explicacao" => "São as ações que podem ser executadas com os dados, como cadastrar, alterar, imprimir, buscar ou remover."
                ],
                [
                    "termo" => "Encapsulamento",
                    "explicacao" => "É a organização dos dados e operações dentro de uma mesma estrutura, protegendo a lógica interna."
                ],
                [
                    "termo" => "Abstração",
                    "explicacao" => "Permite usar uma estrutura sem precisar conhecer todos os detalhes de sua implementação."
                ]
            ],

            "comoFunciona" => [
                "Primeiro são definidos os dados que a estrutura precisa guardar.",
                "Depois são definidas as operações que podem manipular esses dados.",
                "O usuário do TAD utiliza as operações disponíveis, sem precisar mexer diretamente na lógica interna.",
                "O mesmo conceito pode ser implementado de diferentes formas, desde que mantenha os mesmos dados e operações.",
                "Em C#, uma struct pode ser usada para representar um TAD simples."
            ],

            "importancia" => "O TAD é importante porque melhora a organização do código, facilita a manutenção e permite criar estruturas reutilizáveis em diferentes programas.",

            "aplicacoes" => [
                "Cadastro de clientes em um sistema.",
                "Controle de contas bancárias.",
                "Representação de produtos em estoque.",
                "Estruturas como pilhas, filas, listas e árvores.",
                "Organização de dados em sistemas acadêmicos, comerciais e financeiros."
            ],

            "operacoes" => [
                [
                    "nome" => "Criar",
                    "descricao" => "Inicializa uma variável ou estrutura com seus dados básicos.",
                    "complexidade" => "Depende do TAD"
                ],
                [
                    "nome" => "Atribuir valores",
                    "descricao" => "Preenche os campos internos com informações válidas.",
                    "complexidade" => "O(1) por campo"
                ],
                [
                    "nome" => "Imprimir",
                    "descricao" => "Retorna ou exibe os dados armazenados no TAD.",
                    "complexidade" => "O(n)"
                ],
                [
                    "nome" => "Alterar",
                    "descricao" => "Modifica um ou mais dados já cadastrados na estrutura.",
                    "complexidade" => "Depende da operação"
                ]
            ],

            "etapas" => [
                [
                    "titulo" => "1. Definir o problema",
                    "passos" => [
                        "Identificar qual entidade será representada.",
                        "Exemplo: Cliente, Produto, Conta, Aluno ou Livro.",
                        "Entender quais informações precisam ser guardadas."
                    ]
                ],
                [
                    "titulo" => "2. Escolher os dados",
                    "passos" => [
                        "Listar os atributos principais da estrutura.",
                        "No exemplo do slide, o Cliente possui nome, CPF, data de nascimento e e-mail.",
                        "Cada dado deve ter um tipo adequado, como string, int ou double."
                    ]
                ],
                [
                    "titulo" => "3. Definir as operações",
                    "passos" => [
                        "Criar funções ou métodos que trabalham com os dados.",
                        "Evitar repetir código fora da estrutura.",
                        "No exemplo do Cliente, a operação Imprimir() mostra os dados cadastrados."
                    ]
                ],
                [
                    "titulo" => "4. Usar o TAD no programa",
                    "passos" => [
                        "Declarar uma variável do tipo criado.",
                        "Atribuir valores aos seus campos.",
                        "Chamar as operações disponíveis para utilizar a estrutura."
                    ]
                ]
            ],

            "memoria" => [
                [
                    "titulo" => "Stack",
                    "descricao" => "Área de memória mais rápida, porém com espaço menor. No conteúdo do slide, as struct são associadas ao armazenamento no Stack."
                ],
                [
                    "titulo" => "Heap",
                    "descricao" => "Área de memória menos rápida, porém com espaço maior. Normalmente é usada para objetos e estruturas que precisam de mais flexibilidade."
                ],
                [
                    "titulo" => "Struct em C#",
                    "descricao" => "Uma struct agrupa variáveis relacionadas em um único bloco e pode ser usada para criar um TAD simples."
                ]
            ],

            "comparacao" => [
                [
                    "criterio" => "Foco",
                    "tad" => "Define dados e operações de forma abstrata",
                    "struct" => "Implementa uma estrutura concreta em C#"
                ],
                [
                    "criterio" => "Uso",
                    "tad" => "Conceito usado para organizar estruturas de dados",
                    "struct" => "Recurso da linguagem para agrupar dados relacionados"
                ],
                [
                    "criterio" => "Operações",
                    "tad" => "Sempre considera as ações possíveis sobre os dados",
                    "struct" => "Pode possuir métodos, como Imprimir()"
                ],
                [
                    "criterio" => "Abstração",
                    "tad" => "Mostra o que a estrutura faz",
                    "struct" => "Mostra como uma implementação pode ser escrita"
                ]
            ],

            "videos" => [
                [
                    "titulo" => "Videoaula sobre TAD",
                    "descricao" => "Vídeo complementar para reforçar o conceito de Tipo Abstrato de Dados e sua relação com dados e operações.",
                    "fonte" => "YouTube - vídeo complementar",
                    "url" => "https://www.youtube.com/embed/LU9mHjzxR2M",
                    "link" => "https://www.youtube.com/results?search_query=tipo+abstrato+de+dados+tad"
                ]
            ],

            "orientacaoCodigo" => "Os exemplos seguem a ideia apresentada no slide: primeiro criamos uma struct Cliente com dados, depois adicionamos uma operação Imprimir() e usamos esse TAD dentro do método Main.",

            "exemplos" => [
                [
                    "titulo" => "Exemplo 1 - Criando uma struct Cliente",
                    "descricao" => "A struct agrupa os dados relacionados a um cliente em uma única estrutura.",
                    "codigo" => <<<'CSHARP'
namespace Struct;

public struct Cliente
{
    public string nome;
    public string cpf;
    public string dataNascimento;
    public string email;
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 2 - Adicionando uma operação ao TAD",
                    "descricao" => "Além dos dados, o TAD também possui operações. Aqui, Imprimir() retorna os dados do cliente.",
                    "codigo" => <<<'CSHARP'
namespace Struct;

public struct Cliente
{
    public string nome;
    public string cpf;
    public string dataNascimento;
    public string email;

    public string Imprimir()
    {
        return "\nNome: " + this.nome +
               "\nCPF: " + this.cpf +
               "\nData de nascimento: " + this.dataNascimento +
               "\nE-mail: " + this.email;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 3 - Usando o TAD no programa",
                    "descricao" => "Depois de criar a struct, podemos declarar uma variável do tipo Cliente e preencher seus dados.",
                    "codigo" => <<<'CSHARP'
using System;
using Struct;

namespace TAD
{
    class Program
    {
        static void Main(string[] args)
        {
            Cliente cliente1 = new();

            cliente1.nome = "Luke";
            cliente1.cpf = "111.111.111-11";
            cliente1.dataNascimento = "01/01/2001";
            cliente1.email = "luke@gmail.com";

            Console.WriteLine(cliente1.Imprimir());
        }
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 4 - Criando um construtor",
                    "descricao" => "O construtor facilita a criação do TAD, pois já recebe todos os dados necessários.",
                    "codigo" => <<<'CSHARP'
namespace Struct;

public struct Cliente
{
    public string nome;
    public string cpf;
    public string dataNascimento;
    public string email;

    public Cliente(string nome, string cpf, string dataNascimento, string email)
    {
        this.nome = nome;
        this.cpf = cpf;
        this.dataNascimento = dataNascimento;
        this.email = email;
    }

    public string Imprimir()
    {
        return "\nNome: " + this.nome +
               "\nCPF: " + this.cpf +
               "\nData de nascimento: " + this.dataNascimento +
               "\nE-mail: " + this.email;
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 5 - Criando o cliente com construtor",
                    "descricao" => "Agora o objeto já nasce preenchido, deixando o código principal mais limpo.",
                    "codigo" => <<<'CSHARP'
using System;
using Struct;

namespace TAD
{
    class Program
    {
        static void Main(string[] args)
        {
            Cliente cliente1 = new Cliente(
                "Luke",
                "111.111.111-11",
                "01/01/2001",
                "luke@gmail.com"
            );

            Console.WriteLine(cliente1.Imprimir());
        }
    }
}
CSHARP
                ],
                [
                    "titulo" => "Exemplo 6 - Outro TAD simples: Produto",
                    "descricao" => "O mesmo raciocínio pode ser aplicado a outras entidades, como um produto de estoque.",
                    "codigo" => <<<'CSHARP'
public struct Produto
{
    public string nome;
    public double preco;
    public int quantidade;

    public double CalcularTotal()
    {
        return preco * quantidade;
    }

    public string Imprimir()
    {
        return "Produto: " + nome +
               "\nPreço: R$ " + preco +
               "\nQuantidade: " + quantidade +
               "\nTotal: R$ " + CalcularTotal();
    }
}
CSHARP
                ]
            ],

            "exercicios" => [
                "Explique com suas palavras o que significa TAD.",
                "Mostre a diferença entre dados e operações usando o exemplo Cliente.",
                "Crie uma struct Aluno com nome, RA, curso e e-mail.",
                "Adicione uma operação Imprimir() na struct Aluno.",
                "Crie uma struct Produto com nome, preço e quantidade.",
                "Adicione uma operação que calcule o valor total do produto em estoque.",
                "Explique por que TAD ajuda a organizar melhor o código."
            ]
        ];
    }
}
