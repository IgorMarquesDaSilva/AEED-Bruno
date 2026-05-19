<?php

require_once __DIR__ . '/../Model/Conteudo/Conteudo.php';

class HomeController
{
    public function index(): void
    {
        $titulo = 'Estruturas de Dados em C#';
        $descricao = 'Projeto inicial para apresentar conceitos basicos de estruturas de dados usando o padrao MVC.';
        $estruturas = Conteudo::listarEstruturasIniciais();

        require __DIR__ . '/../View/Home/index.php';
    }
}
