<?php

class Perguntas
{
    public static function listar()
    {
        return [
            'tad-1' => [
                'tema' => 'tad', 'tipo' => 'Teoria',
                'enunciado' => 'Duas equipes implementam uma fila: uma usa um vetor e outra usa nós encadeados. Ambas oferecem as mesmas operações e respeitam o FIFO. O que permite tratá-las como o mesmo TAD?',
                'alternativas' => ['A mesma disposição dos dados na memória.', 'O mesmo contrato de operações e comportamento, independentemente da implementação.', 'A presença obrigatória de uma classe chamada No.', 'O uso de atributos públicos nas duas implementações.'],
                'correta' => 1,
                'explicacao' => 'O TAD descreve os valores, as operações e seu comportamento. Vetores e nós encadeados são maneiras diferentes de implementar esse contrato.'
            ],
            'tad-2' => [
                'tema' => 'tad', 'tipo' => 'Teoria',
                'enunciado' => 'Um TAD Conta oferece Depositar e Sacar. Por que impedir a alteração direta do saldo pode ser importante?',
                'alternativas' => ['Porque todo atributo privado ocupa menos memória.', 'Porque elimina a necessidade de métodos.', 'Porque permite que as operações controlem regras, como impedir um saque maior que o saldo.', 'Porque transforma qualquer operação em O(1).'],
                'correta' => 2,
                'explicacao' => 'Encapsular o saldo permite que as operações validem as mudanças e preservem as regras da conta. Isso não determina, por si só, o custo das operações.'
            ],
            'tad-3' => [
                'tema' => 'tad', 'tipo' => 'Teoria',
                'enunciado' => 'Qual alternativa distingue corretamente um TAD de uma struct em C#?',
                'alternativas' => ['TAD é uma especificação abstrata; struct é um recurso da linguagem que pode participar de sua implementação.', 'TAD e struct são sempre a mesma coisa.', 'Uma struct só pode armazenar números, enquanto um TAD armazena textos.', 'Todo TAD precisa ser implementado obrigatoriamente com struct.'],
                'correta' => 0,
                'explicacao' => 'O TAD pertence ao nível da especificação. Uma struct é uma construção concreta de C#; classes também podem ser usadas para implementar TADs.'
            ],
            'tad-4' => [
                'tema' => 'tad', 'tipo' => 'Código',
                'enunciado' => 'Considere a struct Produto abaixo. Qual valor será exibido?',
                'codigo' => "public struct Produto\n{\n    public int Preco;\n    public int Quantidade;\n\n    public int CalcularTotal() => Preco * Quantidade;\n}\n\n// Dentro do método Main:\nProduto p = new Produto { Preco = 12, Quantidade = 3 };\np.Quantidade += 2;\nConsole.WriteLine(p.CalcularTotal());",
                'alternativas' => ['36', '14', '60', '17'], 'correta' => 2,
                'explicacao' => 'A quantidade passa de 3 para 5. CalcularTotal usa o estado atual do produto: 12 × 5 = 60.'
            ],
            'tad-5' => [
                'tema' => 'tad', 'tipo' => 'Código',
                'enunciado' => 'O método Sacar pertence a um TAD Conta. Com saldo inicial de 50, qual será a saída?',
                'codigo' => "private int saldo = 50;\n\npublic bool Sacar(int valor)\n{\n    if (valor <= 0 || valor > saldo) return false;\n    saldo -= valor;\n    return true;\n}\n\n// Dentro de um método da mesma classe:\nConsole.WriteLine(Sacar(70));\nConsole.WriteLine(saldo);",
                'alternativas' => ["True e -20", 'False e 50', 'False e -20', 'True e 50'], 'correta' => 1,
                'explicacao' => 'O saque de 70 ultrapassa o saldo de 50. O método retorna false antes de modificar o saldo, preservando a regra do TAD.'
            ],
            'lisimples-1' => [
                'tema' => 'lisimples', 'tipo' => 'Teoria',
                'enunciado' => 'Uma lista simplesmente encadeada mantém referências Inicio e Fim. Qual operação pode ser O(1), mesmo quando a lista possui muitos nós?',
                'alternativas' => ['Buscar um valor desconhecido.', 'Acessar o elemento de índice 50 sem percorrer a lista.', 'Remover o último nó sem conhecer seu anterior.', 'Inserir um novo nó no final usando Fim.'], 'correta' => 3,
                'explicacao' => 'Com Fim disponível, basta ligar o último nó ao novo e atualizar Fim. Busca e acesso por posição exigem percurso; remover o último exige encontrar seu anterior.'
            ],
            'lisimples-2' => [
                'tema' => 'lisimples', 'tipo' => 'Teoria',
                'enunciado' => 'Na lista A → B → C → null, você já possui uma referência para A e deseja remover B. Qual ligação deve ser alterada?',
                'alternativas' => ['A.Proximo deve passar a apontar para C.', 'C.Proximo deve apontar para A.', 'Inicio deve obrigatoriamente passar a apontar para C.', 'A.Proximo deve continuar apontando para B.'], 'correta' => 0,
                'explicacao' => 'O nó anterior ao removido precisa apontar para seu sucessor. Conhecendo A, a religação é A.Proximo = A.Proximo.Proximo.'
            ],
            'lisimples-3' => [
                'tema' => 'lisimples', 'tipo' => 'Teoria',
                'enunciado' => 'Após remover o único nó de uma lista que mantém Inicio e Fim, qual estado representa corretamente a lista vazia?',
                'alternativas' => ['Inicio é null, mas Fim continua apontando para o nó removido.', 'Fim é null, mas Inicio continua apontando para o nó removido.', 'Inicio e Fim são null.', 'Inicio e Fim apontam para um novo nó com valor zero.'], 'correta' => 2,
                'explicacao' => 'As duas extremidades devem indicar ausência de nós. Manter Fim apontando para um nó removido deixa o estado da lista inconsistente.'
            ],
            'lisimples-4' => [
                'tema' => 'lisimples', 'tipo' => 'Código',
                'enunciado' => 'Inicio aponta para a lista 10 → 20 → 30 → null. Após este trecho, qual sequência será alcançada a partir de Inicio?',
                'codigo' => "No novo = new No(\"5\");\nnovo.Proximo = Inicio;\nInicio = novo;\nInicio.Proximo = Inicio.Proximo.Proximo;",
                'alternativas' => ['5 → 10 → 20 → 30', '5 → 20 → 30', '10 → 20 → 30 → 5', '5 → 30'], 'correta' => 1,
                'explicacao' => 'O nó 5 vira o início. Depois, seu Proximo deixa de apontar para 10 e passa a apontar para 20. A sequência alcançável é 5, 20, 30.'
            ],
            'lisimples-5' => [
                'tema' => 'lisimples', 'tipo' => 'Código',
                'enunciado' => 'Nesta lista, No.Valor é do tipo int, e Inicio aponta para 4 → 7 → 9 → null. O que o percurso abaixo imprime?',
                'codigo' => "No atual = Inicio;\nint total = 0;\nwhile (atual != null)\n{\n    if (atual.Valor > 5) total++;\n    atual = atual.Proximo;\n}\nConsole.WriteLine(total);",
                'alternativas' => ['20', '3', '1', '2'], 'correta' => 3,
                'explicacao' => 'O laço visita os três nós, mas incrementa total apenas para 7 e 9. Portanto, conta dois valores maiores que 5.'
            ],
            'lisdupla-1' => [
                'tema' => 'lisdupla', 'tipo' => 'Teoria',
                'enunciado' => 'Na lista dupla A ↔ B ↔ C, B é um nó do meio. Para removê-lo sem quebrar o percurso em nenhum sentido, quais referências devem mudar?',
                'alternativas' => ['Somente A.Proximo.', 'Somente C.Anterior.', 'A.Proximo passa a C e C.Anterior passa a A.', 'A.Anterior passa a C e C.Proximo passa a A.'], 'correta' => 2,
                'explicacao' => 'A ligação para frente e a ligação para trás precisam ser atualizadas. Alterar só uma delas deixa o percurso inverso inconsistente.'
            ],
            'lisdupla-2' => [
                'tema' => 'lisdupla', 'tipo' => 'Teoria',
                'enunciado' => 'Você já possui uma referência para um nó do meio de uma lista dupla. Por que a remoção desse nó pode ser O(1)?',
                'alternativas' => ['Porque todo acesso por índice em lista dupla é direto.', 'Porque suas referências Anterior e Proximo permitem religar os vizinhos sem buscar o anterior.', 'Porque a lista dupla não usa memória para referências.', 'Porque o valor do nó determina automaticamente sua posição.'], 'correta' => 1,
                'explicacao' => 'Com o nó já localizado, seus dois vizinhos estão acessíveis. Se antes for necessário buscar o nó pelo valor, essa busca ainda pode custar O(n).'
            ],
            'lisdupla-3' => [
                'tema' => 'lisdupla', 'tipo' => 'Teoria',
                'enunciado' => 'Qual é uma diferença entre uma lista simplesmente encadeada e uma duplamente encadeada?',
                'alternativas' => ['A dupla usa uma referência adicional por nó e permite percorrer nos dois sentidos.', 'A dupla sempre ocupa menos memória por nó.', 'A simples permite voltar diretamente ao anterior de qualquer nó.', 'A dupla só permite inserir no início.'], 'correta' => 0,
                'explicacao' => 'A referência Anterior permite navegar para trás, mas acrescenta armazenamento por nó em relação à lista simples equivalente.'
            ],
            'lisdupla-4' => [
                'tema' => 'lisdupla', 'tipo' => 'Código',
                'enunciado' => 'A lista dupla é 2 ↔ 4 ↔ 6, e Fim aponta para 6. Qual sequência será impressa?',
                'codigo' => "No atual = Fim;\nwhile (atual != null)\n{\n    Console.Write(atual.Valor + \" \" );\n    atual = atual.Anterior;\n}",
                'alternativas' => ['2 4 6', '6 2 4', '4 2', '6 4 2'], 'correta' => 3,
                'explicacao' => 'O percurso começa no fim e segue Anterior: visita 6, depois 4 e finalmente 2.'
            ],
            'lisdupla-5' => [
                'tema' => 'lisdupla', 'tipo' => 'Código',
                'enunciado' => 'A lista dupla não está vazia. Qual instrução falta para inserir corretamente um nó antes do Inicio atual?',
                'codigo' => "No novo = new No(\"8\");\nnovo.Proximo = Inicio;\nnovo.Anterior = null;\n// Instrução que falta\nInicio = novo;",
                'alternativas' => ['Fim = null;', 'Inicio.Anterior = novo;', 'novo.Proximo = null;', 'Inicio.Proximo = novo;'], 'correta' => 1,
                'explicacao' => 'O antigo início precisa apontar para o novo nó por Anterior. Depois, Inicio é atualizado para o novo nó.'
            ],
            'fila-1' => [
                'tema' => 'fila', 'tipo' => 'Teoria',
                'enunciado' => 'Uma fila está vazia. Enfileiramos A, B e C, desenfileiramos uma vez e enfileiramos D. Quem será o próximo a sair?',
                'alternativas' => ['D', 'C', 'B', 'A'], 'correta' => 2,
                'explicacao' => 'A primeira remoção retira A. A fila fica B, C, D, portanto B é o próximo pelo critério FIFO.'
            ],
            'fila-2' => [
                'tema' => 'fila', 'tipo' => 'Teoria',
                'enunciado' => 'Uma fila encadeada mantém referências para início e fim. Onde ocorrem as operações para preservar o FIFO?',
                'alternativas' => ['Insere no fim e remove no início.', 'Insere e remove no início.', 'Insere e remove no fim.', 'Remove sempre o maior valor, independentemente da chegada.'], 'correta' => 0,
                'explicacao' => 'Novos elementos entram atrás dos anteriores, e a remoção retira o mais antigo. Com início e fim, ambas as operações podem ser O(1).'
            ],
            'fila-3' => [
                'tema' => 'fila', 'tipo' => 'Teoria',
                'enunciado' => 'Após desenfileirar o último elemento, por que também devemos definir fim como null?',
                'alternativas' => ['Para ordenar os valores restantes.', 'Para transformar a fila em lista dupla.', 'Para preservar uma referência ao elemento removido.', 'Para que início e fim representem corretamente a fila vazia.'], 'correta' => 3,
                'explicacao' => 'Não resta nenhum elemento. Manter uma das extremidades apontando para o nó removido pode comprometer inserções posteriores.'
            ],
            'fila-4' => [
                'tema' => 'fila', 'tipo' => 'Código',
                'enunciado' => 'Considere os métodos de enfileirar e desenfileirar estudados na aula. Qual é a fila final, do início para o fim?',
                'codigo' => "Fila fila = new Fila();\nfila.inserirEnfileirar(12);\nfila.inserirEnfileirar(7);\nfila.removerDesenfileirar();\nfila.inserirEnfileirar(20);\nfila.inserirEnfileirar(5);\nfila.removerDesenfileirar();",
                'alternativas' => ['12 → 7', '20 → 5', '5 → 20', '7 → 20 → 5'], 'correta' => 1,
                'explicacao' => 'A primeira remoção retira 12. Depois das inserções, a fila é 7, 20, 5. A segunda remoção retira 7, restando 20, 5.'
            ],
            'fila-5' => [
                'tema' => 'fila', 'tipo' => 'Código',
                'enunciado' => 'A fila não está vazia e novo.prox é null. Qual instrução completa a inserção no final?',
                'codigo' => "No novo = new No(30);\n// Instrução que falta\nfim = novo;",
                'alternativas' => ['inicio = null;', 'novo.prox = inicio;', 'fim.prox = novo;', 'fim.prox = null;'], 'correta' => 2,
                'explicacao' => 'Antes de atualizar fim, o antigo último nó precisa apontar para novo. Caso contrário, o percurso a partir de inicio não alcançará o novo elemento.'
            ],
            'filaprioridade-1' => [
                'tema' => 'filaprioridade', 'tipo' => 'Teoria',
                'enunciado' => 'Quanto maior o número, maior a prioridade. Chegam A(2), B(5), C(5) e D(1), nessa ordem. Qual será a ordem de remoção?',
                'alternativas' => ['B, C, A, D', 'A, B, C, D', 'C, B, A, D', 'D, A, B, C'], 'correta' => 0,
                'explicacao' => 'B e C têm a maior prioridade. Como B chegou antes de C, sai primeiro no desempate FIFO. Depois saem A e D.'
            ],
            'filaprioridade-2' => [
                'tema' => 'filaprioridade', 'tipo' => 'Teoria',
                'enunciado' => 'Na implementação encadeada ordenada por prioridade estudada no site, qual é o custo no pior caso da inserção e da remoção no início?',
                'alternativas' => ['Inserção O(1) e remoção O(n).', 'Ambas O(1), independentemente da posição de inserção.', 'Ambas O(n²).', 'Inserção O(n) e remoção O(1).'], 'correta' => 3,
                'explicacao' => 'A inserção pode percorrer todos os nós para achar sua posição. A remoção usa diretamente o início, onde está a maior prioridade.'
            ],
            'filaprioridade-3' => [
                'tema' => 'filaprioridade', 'tipo' => 'Teoria',
                'enunciado' => 'Em que situação a fila de prioridades desta aula se comporta como uma fila FIFO comum?',
                'alternativas' => ['Quando todos os valores são negativos.', 'Quando todos os elementos possuem a mesma prioridade.', 'Quando a fila deixa de ter uma referência para o início.', 'Quando cada novo elemento é inserido antes dos demais de mesma prioridade.'], 'correta' => 1,
                'explicacao' => 'Com prioridades iguais, apenas a ordem de chegada decide o atendimento. Inserir depois dos elementos empatados preserva o FIFO.'
            ],
            'filaprioridade-4' => [
                'tema' => 'filaprioridade', 'tipo' => 'Código',
                'enunciado' => 'Durante a inserção ordenada, por que o laço usa >= em vez de apenas >?',
                'codigo' => "while (atual.prox != null &&\n       atual.prox.prioridade >= novaPrioridade)\n{\n    atual = atual.prox;\n}\nnovo.prox = atual.prox;\natual.prox = novo;",
                'alternativas' => ['Para colocar o novo elemento antes de todos os empatados.', 'Para remover os nós de menor prioridade.', 'Para passar pelos empatados e inserir o novo depois deles, preservando o FIFO.', 'Para impedir a existência de prioridades repetidas.'], 'correta' => 2,
                'explicacao' => 'O >= faz o percurso avançar também por nós de mesma prioridade. Assim, quem acabou de chegar fica atrás dos que já estavam esperando.'
            ],
            'filaprioridade-5' => [
                'tema' => 'filaprioridade', 'tipo' => 'Código',
                'enunciado' => 'Os parâmetros são (valor, prioridade), e números maiores têm maior prioridade. Qual será a fila final?',
                'codigo' => "FilaPrioridade fila = new FilaPrioridade();\nfila.inserirOrdenado(10, 2);\nfila.inserirOrdenado(20, 5);\nfila.inserirOrdenado(30, 5);\nfila.removerDesenfileirar();\nfila.inserirOrdenado(40, 3);",
                'alternativas' => ['30(5) → 40(3) → 10(2)', '10(2) → 30(5) → 40(3)', '20(5) → 30(5) → 40(3)', '40(3) → 30(5) → 10(2)'], 'correta' => 0,
                'explicacao' => 'A fila inicialmente fica 20(5), 30(5), 10(2). A remoção retira 20; o valor 40 com prioridade 3 entra entre 30 e 10.'
            ]
        ];
    }
}
