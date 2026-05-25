<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $titulo; ?></title>
        <link rel="stylesheet" href="View/Assets/css/style.css">
        <link rel="stylesheet" href="View/Assets/css/home.css">
    </head>
    <body>
        <header>
            <h1><?php echo $titulo; ?></h1>
        </header>

        <main>
            <p><?php echo $descricao; ?></p>

            <h2>Conteudos iniciais</h2>
            <ul class="lista-estruturas">
                <?php foreach ($estruturas as $estrutura){?>
                    <li><?php echo $estrutura; ?></li>
                <?php } ?>
            </ul>
            <a href="index.php?pagina=tad">TAD – Tipo Abstrato de Dados</a>
            <p>
            <a href="index.php?pagina=lisimples">Listas Simplesmente Encadeadas</a>
            </p>
            <p>
            <a href="index.php?pagina=lisdupla">Listas Duplamente Encadeadas</a>
            </p>
        </main>
    </body>
</html>