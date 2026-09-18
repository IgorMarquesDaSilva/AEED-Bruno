<?php 
require_once __DIR__ . '/Controller/HomeController.php';
require_once __DIR__ . '/Controller/EstruturaController.php';
require_once __DIR__ . '/Controller/LoginController.php';
require_once __DIR__ . '/Controller/Cadastrocontroller.php';
require_once __DIR__ . '/Controller/PerfilController.php';
require_once __DIR__ . '/Controller/RecuperarSenhaController.php';
require_once __DIR__ . '/Controller/QuizController.php';
 
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
} elseif ($pagina == "perfil") {
    $controller = new PerfilController();
    $controller->perfil();
} elseif ($pagina == "quiz") {
    $controller = new QuizController();
    $controller->index();
} elseif ($pagina == "esqueciSenha") {
    $controller = new RecuperarSenhaController();
    $controller->esqueciSenha();
} elseif ($pagina == "redefinirSenha") {
    $controller = new RecuperarSenhaController();
    $controller->redefinirSenha();
} elseif ($pagina == "tad") {
    $controller = new EstruturaController();
    $controller->tad();
} elseif ($pagina == "lisimples") {
    $controller = new EstruturaController();
    $controller->lisimples();
} elseif ($pagina == "lisdupla") {
    $controller = new EstruturaController();
    $controller->lisdupla();
} elseif ($pagina == "fila") {
    $controller = new EstruturaController();
    $controller->fila();
} elseif ($pagina == "filaprioridade") {
    $controller = new EstruturaController();
    $controller->filaprioridade();
} else {
    $controller = new HomeController();
    $controller->index();
}
?>
