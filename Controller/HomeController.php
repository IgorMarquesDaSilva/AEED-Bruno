<?php
require_once __DIR__ . '/../Model/Conteudo/Conteudo.php';
class HomeController{
    public function index(){
        $conteudo = new Conteudo();

        $titulo = "Estrutura de Dados em C#";
        $descricao = "Aprenda os conceitos iniciais de estrutura de dados.";
        $estruturas = $conteudo->listarEstruturas();
        
        require_once __DIR__ . '/../View/Home/index.php';
    }
}
?>