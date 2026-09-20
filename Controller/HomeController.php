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
        $descricao = 'Entenda como organizar informações para buscar, inserir e remover dados com eficiência, usando TADs, listas, filas e pilhas em C#.';
        $estruturas = $conteudo->listarEstruturas();
        $bodyClass = 'pagina-home';
        $mainClass = 'container';
        $cssPagina = ['View/Assets/css/home.css'];

        require __DIR__ . '/../View/Home/index.php';
    }
}
?>
