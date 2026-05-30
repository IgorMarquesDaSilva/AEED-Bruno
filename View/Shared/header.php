<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo ?? 'Estruturas de Dados'); ?></title>
    <link rel="stylesheet" href="View/Assets/css/style.css">
    <link rel="stylesheet" href="View/Assets/css/home.css">
</head>
<body>
<header class="topo">
    <div class="topo-conteudo">
        <a class="logo" href="index.php">ED em C#</a>

        <nav class="menu">
            <a href="index.php">Início</a>
            <a href="index.php?pagina=tad">TAD</a>
            <a href="index.php?pagina=lisimples">Lista Simples</a>
            <a href="index.php?pagina=lisdupla">Lista Dupla</a>
            <a class="menu-sair" href="index.php?pagina=logout">Sair</a>
        </nav>
    </div>
</header>

<main class="container">
