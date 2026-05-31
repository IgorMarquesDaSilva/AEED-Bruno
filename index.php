<?php 
require_once __DIR__ . '/Controller/HomeController.php';
require_once __DIR__ . '/Controller/EstruturaController.php';
require_once __DIR__ . '/Controller/LoginController.php';
require_once __DIR__ . '/Controller/CadastroController.php';
 
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : "home";

if ($pagina == "login") {
    $controller = new LoginController();
    $controller->login();
} elseif ($pagina == "logout") {
    $controller = new LoginController();
    $controller->logout();
} elseif ($pagina == "cadastro") {
    $controller = new CadastroController();
    $controller->cadastro();
} elseif ($pagina == "tad") {
    $controller = new EstruturaController();
    $controller->tad();
} elseif ($pagina == "lisimples") {
    $controller = new EstruturaController();
    $controller->lisimples();
} elseif ($pagina == "lisdupla") {
    $controller = new EstruturaController();
    $controller->lisdupla();
} else {
    $controller = new HomeController();
    $controller->index();
}
?>