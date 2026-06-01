<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo ?? 'Estruturas de Dados'); ?></title>

    <?php
        $cssBase = 'View/Assets/css/style.css';
        $caminhoCssBase = __DIR__ . '/../../' . $cssBase;
        $versaoCssBase = file_exists($caminhoCssBase) ? filemtime($caminhoCssBase) : 1;
    ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($cssBase . '?v=' . $versaoCssBase); ?>">

    <?php foreach (($cssPagina ?? []) as $css) { ?>
        <?php
            $caminhoCssPagina = __DIR__ . '/../../' . $css;
            $versaoCssPagina = file_exists($caminhoCssPagina) ? filemtime($caminhoCssPagina) : 1;
        ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($css . '?v=' . $versaoCssPagina); ?>">
    <?php } ?>
</head>
<body class="<?php echo htmlspecialchars($bodyClass ?? ''); ?>">

<header class="topo">
    <div class="topo-conteudo">

        <a class="logo" href="index.php">
            <span class="logo-sigla">ED</span>
            <span class="logo-texto">ED em C#</span>
            <span class="logo-sep"></span>
            <span class="logo-subtitulo">Estruturas de Dados</span>
        </a>

        <nav class="menu">
            <a href="index.php">Início</a>
            <a href="index.php?pagina=tad">TAD</a>
            <a href="index.php?pagina=lisimples">Lista Simples</a>
            <a href="index.php?pagina=lisdupla">Lista Dupla</a>
            <a class="menu-sair" href="index.php?pagina=logout">Sair</a>
        </nav>

    </div>
</header>

<main class="<?php echo htmlspecialchars($mainClass ?? 'container'); ?>">