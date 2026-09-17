<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha - Estruturas de Dados</title>

    <link rel="stylesheet" href="View/Assets/css/style.css">
    <link rel="stylesheet" href="View/Assets/css/login.css">
</head>
<body class="pagina-login">
    <main class="login-container">
        <section class="login-painel">
            <span class="login-tag">Ambiente de Ensino</span>
            <h1>Esqueci minha senha</h1>
            <p>Informe o e-mail cadastrado para receber as instruções de redefinição de senha.</p>

            <?php if (!empty($erro)) { ?>
                <div class="login-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php } ?>

            <?php if (!empty($sucesso)) { ?>
                <div class="cadastro-sucesso">
                    <?php echo htmlspecialchars($sucesso); ?>
                </div>

                <?php if (!empty($linkTeste)) { ?>
                    <div class="login-dev-aviso">
                        <strong>Modo de teste (sem servidor de e-mail configurado):</strong>
                        <p>Em produção este link seria enviado por e-mail. Para testar agora, acesse:</p>
                        <a href="<?php echo htmlspecialchars($linkTeste); ?>">
                            <?php echo htmlspecialchars($linkTeste); ?>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>

            <form class="login-formulario" method="POST" action="index.php?pagina=esqueciSenha">
                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo htmlspecialchars(isset($email) ? $email : ''); ?>"
                    placeholder="seuemail@exemplo.com"
                    required
                >

                <button type="submit">Enviar instruções</button>
            </form>

            <p class="login-cadastro">
                Lembrou sua senha?
                <a href="index.php?pagina=login">Voltar para o login</a>
            </p>
        </section>
    </main>
</body>
</html>