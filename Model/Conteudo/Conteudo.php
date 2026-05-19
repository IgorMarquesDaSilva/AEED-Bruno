<?php

class Conteudo
{
    public static function listarEstruturasIniciais(): array
    {
        return [
            [
                'nome' => 'Pilha',
                'descricao' => 'Estrutura em que o ultimo elemento inserido e o primeiro a sair.',
            ],
            [
                'nome' => 'Fila',
                'descricao' => 'Estrutura em que o primeiro elemento inserido e o primeiro a sair.',
            ],
            [
                'nome' => 'Lista',
                'descricao' => 'Estrutura usada para organizar elementos em sequencia.',
            ],
        ];
    }
}
