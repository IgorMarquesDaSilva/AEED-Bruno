<?php
require_once __DIR__ . '/../Model/EstruturasDados/Tad.php';
require_once __DIR__ . '/../Model/EstruturasDados/Lisimples.php';
require_once __DIR__ . '/../Model/EstruturasDados/Lisdupla.php';
require_once __DIR__ . '/../Model/EstruturasDados/Fila.php';
require_once __DIR__ . '/LoginController.php';

class EstruturaController{
    public function tad(){
        LoginController::verificarLogin();

        $tad = new Tad();
        $conteudo = $tad->obterConteudo();
        $titulo = $conteudo["titulo"];
        $bodyClass = 'pagina-tad';
        $mainClass = 'conteudo-aula';
        $cssPagina = ['View/Assets/css/tad.css'];

        require_once __DIR__ . '/../View/EstruturasDados/Tad.php';
    }

    public function lisimples(){
        LoginController::verificarLogin();

        $lisimples = new Lisimples();
        $conteudo = $lisimples->obterConteudo();
        $titulo = $conteudo["titulo"];
        $bodyClass = 'pagina-lisimples';
        $mainClass = 'conteudo-aula';
        $cssPagina = ['View/Assets/css/lisimples.css'];

        require_once __DIR__ . '/../View/EstruturasDados/Lisimples.php';
    }
    
    public function lisdupla(){
        LoginController::verificarLogin();

        $lisdupla = new Lisdupla();
        $conteudo = $lisdupla->obterConteudo();
        $titulo = $conteudo["titulo"];
        $bodyClass = 'pagina-lisdupla';
        $mainClass = 'conteudo-aula';
        $cssPagina = ['View/Assets/css/Lisdupla.css'];

        require_once __DIR__ . '/../View/EstruturasDados/Lisdupla.php';
    }

    public function fila(){
        LoginController::verificarLogin();

        $fila = new Fila();
        $conteudo = $fila->obterConteudo();
        $titulo = $conteudo["titulo"];
        $bodyClass = 'pagina-fila';
        $mainClass = 'conteudo-aula';
        $cssPagina = ['View/Assets/css/Fila.css'];

        require_once __DIR__ . '/../View/EstruturasDados/Fila.php';
    }
}
?>