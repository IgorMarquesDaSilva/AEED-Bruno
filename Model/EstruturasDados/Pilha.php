<?php
class Pilha{
    public function obterConteudo(){
        return [
            "titulo" => "Pilha",
            "definicao" => "Pilha e uma estrutura de dados em que o ultimo elemento inserido e o primeiro a sair.",
            "exemplo" => "Um exemplo simples e uma pilha de pratos.",
            "operacoes" => [
                "Push - inserir um elemento no topo",
                "Pop - remover o elemento do topo",
                "Peek - consultar o elemento do topo"
            ]
        ];
    }
}