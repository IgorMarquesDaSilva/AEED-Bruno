<?php
class DicasQuiz
{
    public static function listar()
    {
        return [
            'tad-1' => 'Compare o comportamento que as duas filas oferecem, não a forma como guardam os dados.',
            'tad-2' => 'Pense em quem deve validar uma mudança antes que ela afete o estado da conta.',
            'tad-3' => 'Separe a especificação de um tipo de dados dos recursos concretos da linguagem.',
            'tad-4' => 'Calcule com os valores do produto depois de atualizar a quantidade.',
            'tad-5' => 'Observe se o método retorna antes ou depois de modificar o saldo.',
            'tad-6' => 'Os módulos precisam concordar no que as operações fazem, não na estrutura interna.',
            'tad-7' => 'Um invariante é uma regra sobre o estado que deve continuar verdadeira.',
            'tad-8' => 'Antes de remover, pergunte se existe algum elemento disponível.',
            'tad-9' => 'A condição dentro de Adicionar determina quais chamadas realmente mudam o estado.',
            'tad-10' => 'Acompanhe o caminho percorrido quando a quantidade pedida supera o saldo.',
            'tad-11' => 'Atribuir uma struct a outra variável copia seus dados, não cria uma referência compartilhada.',
            'tad-12' => 'A validação deve impedir tanto consumo inválido quanto consumo acima do disponível.',

            'lisimples-1' => 'Considere quais operações aproveitam diretamente as referências já disponíveis.',
            'lisimples-2' => 'Para retirar o nó do meio, ligue seu antecessor diretamente ao sucessor.',
            'lisimples-3' => 'Uma lista vazia não deve manter referências para o nó que saiu.',
            'lisimples-4' => 'Trace primeiro a inserção do novo início e depois a mudança de seu Proximo.',
            'lisimples-5' => 'Conte apenas os nós que satisfazem a condição do if, não todos os visitados.',
            'lisimples-6' => 'O novo nó precisa alcançar a lista antiga antes de virar Inicio.',
            'lisimples-7' => 'Para remover Fim, ainda é preciso encontrar quem aponta para ele.',
            'lisimples-8' => 'Um percurso termina ao alcançar null; imagine uma ligação que nunca permite isso.',
            'lisimples-9' => 'Desenhe as duas atribuições na ordem em que aparecem.',
            'lisimples-10' => 'Siga Proximo até null e acumule o Valor de cada nó visitado.',
            'lisimples-11' => 'Depois da atribuição, siga as referências a partir de Inicio e veja qual nó foi pulado.',
            'lisimples-12' => 'Na primeira inserção, ainda não existe um nó acessível por Inicio.',

            'lisdupla-1' => 'A remoção precisa preservar o caminho de ida e o de volta entre os vizinhos.',
            'lisdupla-2' => 'Com o nó já localizado, seus dois vizinhos estão acessíveis sem nova busca.',
            'lisdupla-3' => 'Compare quantas referências cada nó guarda e em quais sentidos é possível percorrer.',
            'lisdupla-4' => 'O laço parte de Fim e segue sempre a referência Anterior.',
            'lisdupla-5' => 'Depois da inserção, o antigo primeiro nó precisa reconhecer seu novo antecessor.',
            'lisdupla-6' => 'Pense em uma operação que aproveita diretamente a referência Fim.',
            'lisdupla-7' => 'Quando o único nó sai, nenhuma extremidade deve continuar apontando para ele.',
            'lisdupla-8' => 'Entre X e B, devem existir referências coerentes nos dois sentidos.',
            'lisdupla-9' => 'Siga Anterior a partir do último nó, sem inverter a direção do laço.',
            'lisdupla-10' => 'Antes de avançar Fim, conecte o antigo último nó ao novo.',
            'lisdupla-11' => 'A primeira atribuição corrige o percurso para frente; falta corrigir o percurso reverso.',
            'lisdupla-12' => 'Determine primeiro onde p está e depois consulte seus dois vizinhos.',

            'fila-1' => 'Após a primeira remoção, retire mentalmente o elemento mais antigo da sequência.',
            'fila-2' => 'FIFO mantém quem chegou antes à frente de quem acabou de entrar.',
            'fila-3' => 'Depois que o último elemento sai, confira as duas extremidades da fila.',
            'fila-4' => 'Escreva a fila após cada chamada, removendo sempre pelo início.',
            'fila-5' => 'O antigo Fim precisa alcançar o novo nó antes de Fim ser atualizado.',
            'fila-6' => 'Consultar e remover são operações diferentes: uma delas não muda a fila.',
            'fila-7' => 'Uma fila sem nós não pode manter uma referência válida para seu último elemento.',
            'fila-8' => 'Espiar não muda a ordem dos elementos que aguardam remoção.',
            'fila-9' => 'A remoção atinge o início; a nova inserção acontece no fim.',
            'fila-10' => 'Mesmo na primeira inserção, o novo nó também é o último.',
            'fila-11' => 'Após avançar Inicio, verifique se ainda resta algum nó.',
            'fila-12' => 'Proximo avança exatamente uma posição a partir de Inicio.',

            'filaprioridade-1' => 'Ordene pelas prioridades e preserve a ordem de chegada entre os empatados.',
            'filaprioridade-2' => 'A inserção procura uma posição; a remoção parte da extremidade já ordenada.',
            'filaprioridade-3' => 'Imagine que a prioridade deixa de diferenciar qualquer par de elementos.',
            'filaprioridade-4' => 'O laço deve atravessar também os elementos que empataram com o recém-chegado.',
            'filaprioridade-5' => 'Monte a ordem por prioridade após cada operação; em empate, mantenha a chegada.',
            'filaprioridade-6' => 'Quando as prioridades empatam, só a ordem de chegada decide.',
            'filaprioridade-7' => 'A ordenação coloca quem será atendido primeiro em uma das extremidades.',
            'filaprioridade-8' => 'Mudar a prioridade pode fazer o nó deixar de ocupar a posição correta.',
            'filaprioridade-9' => 'Compare os números das prioridades antes de considerar os nomes.',
            'filaprioridade-10' => 'Para entrar antes do primeiro, a nova prioridade precisa superar a maior atual.',
            'filaprioridade-11' => 'A maior prioridade vai à frente; o empate mantém a ordem de chegada.',
            'filaprioridade-12' => 'O operador deve incluir prioridades maiores e também iguais à nova.',

            'pilha-1' => 'Na regra LIFO, observe qual elemento entrou mais recentemente.',
            'pilha-2' => 'PUSH e POP são rápidos quando mexem apenas na referência Topo.',
            'pilha-3' => 'Após remover o único nó, não resta um elemento para Topo apontar.',
            'pilha-4' => 'Pense em uma ação recente que precisa ser revertida antes das antigas.',
            'pilha-5' => 'Desenhe dois nós consecutivos e observe o que continua acessível após retirar o primeiro.',
            'pilha-6' => 'Compare uma operação que apenas lê com outra que altera Topo.',
            'pilha-7' => 'A remoção pega o último valor que foi empilhado.',
            'pilha-8' => 'Trace a ligação do novo nó antes de atualizar Topo.',
            'pilha-9' => 'Topo.Proximo é o nó que passa a ocupar o topo após a remoção.',
            'pilha-10' => 'Antes de acessar Topo.Valor, verifique se Topo aponta para algum nó.',
            'pilha-11' => 'Retire os dois elementos mais recentes e veja quem permanece.',
            'pilha-12' => 'O laço segue Proximo até null e soma o Valor de cada nó.'
        ];
    }

    public static function obter($perguntaId)
    {
        $dicas = self::listar();
        if (!is_string($perguntaId) || !isset($dicas[$perguntaId])) {
            throw new DomainException('Esta questão não possui dica disponível.');
        }
        return $dicas[$perguntaId];
    }
}
