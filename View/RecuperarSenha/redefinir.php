<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir senha - Estruturas de Dados</title>

    <link rel="stylesheet" href="View/Assets/css/style.css">
    <link rel="stylesheet" href="View/Assets/css/login.css">
</head>
<body class="pagina-login">
    <main class="login-container">
        <section class="login-painel">
            <span class="login-tag">Ambiente de Ensino</span>
            <h1>Redefinir senha</h1>

            <?php if (!empty($erro)) { ?>
                <div class="login-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php } ?>

            <?php if (!empty($sucesso)) { ?>
                <div class="cadastro-sucesso">
                    <?php echo htmlspecialchars($sucesso); ?>
                </div>
            <?php } ?>

            <?php if ($tokenValido) { ?>
                <p>Escolha uma nova senha para acessar sua conta.</p>

                <form class="login-formulario" method="POST" action="index.php?pagina=redefinirSenha">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                    <label for="nova_senha">Nova senha</label>
                    <input
                        type="password"
                        id="nova_senha"
                        name="nova_senha"
                        placeholder="Minimo de 6 caracteres"
                        required
                    >

                    <label for="confirmar_senha">Confirmar nova senha</label>
                    <input
                        type="password"
                        id="confirmar_senha"
                        name="confirmar_senha"
                        placeholder="Repita a nova senha"
                        required
                    >

                    <button type="submit">Redefinir senha</button>
                </form>
            <?php } ?>

            <p class="login-cadastro">
                <a href="index.php?pagina=login">Voltar para o login</a>
                <?php if (!$tokenValido && empty($sucesso)) { ?>
                    &middot; <a href="index.php?pagina=esqueciSenha">Solicitar novo link</a>
                <?php } ?>
            </p>
        </section>
    </main>
</body>
</html>