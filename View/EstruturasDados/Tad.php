<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $conteudo["titulo"]; ?></title>
        <link rel="stylesheet" href="View/Assets/css/style.css">
        <link rel="stylesheet" href="View/Assets/css/tad.css">
    </head>
    <body>
        <header>
            <h1><?php echo $conteudo["titulo"]; ?></h1>
        </header>
        
        <main class="conteudo-tad">
            <a href="index.php">Voltar para o Inicio</a>

            <h2>Definicao</h2>
            <p><?php echo $conteudo["definicao"]; ?></p>

            <h2>Operações Principais</h2>

            <ul class="lista-operacoes">
                <?php foreach ($conteudo["operacoes"] as $operacao) { ?>
                    <li><?php echo $operacao; ?></li>
                <?php } ?>
            </ul>
        </main>
    </body>
</html>