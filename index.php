<?php

require_once __DIR__ . '/Controller/HomeController.php';
require_once __DIR__ . '/Controller/EstruturaController.php';

if (isset($_GET["pagina"]) && $_GET["pagina"] == "pilha") {
    $controller = new EstruturaController();
    $controller->pilha();
} else {
    $controller = new HomeController();
    $controller->index();
}