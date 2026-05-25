<?php
require_once __DIR__ . '/../Model/EstruturasDados/Tad.php';
require_once __DIR__ . '/../Model/EstruturasDados/Lisimples.php';
require_once __DIR__ . '/../Model/EstruturasDados/Lisdupla.php';

class EstruturaController{
    public function tad(){
        $tad = new Tad();
        $conteudo = $tad->obterConteudo();

        require_once __DIR__ . '/../View/EstruturasDados/Tad.php';
    }

    public function lisimples(){
        $lisimples = new Lisimples();
        $conteudo = $lisimples->obterConteudo();

        require_once __DIR__ . '/../View/EstruturasDados/Lisimples.php';
    }
    
    public function lisdupla(){
        $lisdupla = new Lisdupla();
        $conteudo = $lisdupla->obterConteudo();

        require_once __DIR__ . '/../View/EstruturasDados/Lisdupla.php';
    }
}
?>