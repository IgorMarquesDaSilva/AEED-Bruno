<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Estruturas de Dados</title>

    <link rel="stylesheet" href="View/Assets/css/style.css">
    <link rel="stylesheet" href="View/Assets/css/login.css">
</head>
<body class="pagina-login">
    <main class="login-container">
        <section class="login-painel">
            <span class="login-tag">Ambiente de Ensino</span>
            <h1>Entrar no site</h1>
            <p>Acesse o conteudo de Estruturas de Dados com seu usuario cadastrado.</p>

            <?php if (!empty($erro)) { ?>
                <div class="login-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php } ?>

            <form class="login-formulario" method="POST" action="index.php?pagina=login">
                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                   value="<?php echo htmlspecialchars(isset($email) ? $email : ''); ?>"
                    placeholder="admin@aeed.com"
                    required
                >

                <label for="senha">Senha</label>
                <input
                    type="password"
                    id="senha"
                    name="senha"
                    placeholder="Digite sua senha"
                    required
                >

                <button type="submit">Entrar</button>
            </form>

            <p class="login-cadastro">
                Ainda nao tem conta?
                <a href="index.php?pagina=cadastro">Criar cadastro</a>
            </p>
        </section>
    </main>
</body>
</html>
