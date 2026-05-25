<?php
require_once __DIR__ . '/../Model/EstruturasDados/Pilha.php';

class EstruturaController{
    public function pilha(){
        $pilha = new Pilha();
        $conteudo = $pilha->obterConteudo();

        require_once __DIR__ . '/../View/EstruturasDados/pilha.php';
    }
}
?>