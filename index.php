<?php
 
require_once __DIR__ . '/Controller/HomeController.php';
require_once __DIR__ . '/Controller/EstruturaController.php';
 
if (isset($_GET["pagina"]) && $_GET["pagina"] == "tad") {
    $controller = new EstruturaController();
    $controller->tad();
} elseif (isset($_GET["pagina"]) && $_GET["pagina"] == "lisimples") {
    $controller = new EstruturaController();
    $controller->lisimples();
}
elseif (isset($_GET["pagina"]) && $_GET["pagina"] == "lisdupla") {
    $controller = new EstruturaController();
    $controller->lisdupla();
}
else {
    $controller = new HomeController();
    $controller->index();
}