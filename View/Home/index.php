<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $titulo; ?></title>
        <link rel="stylesheet" href="View/Assets/css/style.css">
    </head>
    <body>
        <header>
            <h1><?php echo $titulo; ?></h1>
        </header>

        <main>
            <p><?php echo $descricao; ?></p>

            <h2>Conteudos iniciais</h2>
            <ul>
                <?php foreach ($estruturas as $estrutura){?>
                    <li><?php echo $estrutura; ?></li>
                <?php } ?>
            </ul>
        </main>
    </body>
</html>