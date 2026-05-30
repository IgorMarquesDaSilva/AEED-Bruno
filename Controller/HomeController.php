<?php
require_once __DIR__ . '/../Model/Conteudo/Conteudo.php';
require_once __DIR__ . '/LoginController.php';

class HomeController
{
    public function index()
    {
        LoginController::verificarLogin();

        $conteudo = new Conteudo();
        $titulo = 'Estruturas de Dados em C#';
        $descricao = 'Projeto inicial para apresentar conceitos basicos de estruturas de dados usando o padrao MVC.';
        $estruturas = $conteudo->listarEstruturas();

        require __DIR__ . '/../View/Home/index.php';
    }
}
?>
