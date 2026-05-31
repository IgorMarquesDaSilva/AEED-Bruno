<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Estruturas de Dados</title>

    <link rel="stylesheet" href="View/Assets/css/style.css">
    <link rel="stylesheet" href="View/Assets/css/cadastro.css">
</head>
<body class="pagina-cadastro">
    <main class="cadastro-container">
        <section class="cadastro-painel">
            <span class="cadastro-tag">Ambiente de Ensino</span>
            <h1>Criar conta</h1>
            <p>Cadastre um usuario para acessar as aulas de Estruturas de Dados.</p>

            <?php if (!empty($erro)) { ?>
                <div class="cadastro-erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php } ?>

            <?php if (!empty($sucesso)) { ?>
                <div class="cadastro-sucesso">
                    <?php echo htmlspecialchars($sucesso); ?>
                </div>
            <?php } ?>

            <form class="cadastro-formulario" method="POST" action="index.php?pagina=cadastro">
                <label for="nome">Nome</label>
                <input
                    type="text"
                    id="nome"
                    name="nome"
                    value="<?php echo htmlspecialchars(isset($nome) ? $nome : ''); ?>"
                    placeholder="Seu nome"
                    maxlength="100"
                    required
                >

                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo htmlspecialchars(isset($email) ? $email : ''); ?>"
                    placeholder="seuemail@exemplo.com"
                    maxlength="150"
                    required
                >

                <label for="senha">Senha</label>
                <input
                    type="password"
                    id="senha"
                    name="senha"
                    placeholder="Minimo de 6 caracteres"
                    minlength="6"
                    required
                >

                <label for="confirmar">Confirmar senha</label>
                <input
                    type="password"
                    id="confirmar"
                    name="confirmar"
                    placeholder="Digite a senha novamente"
                    minlength="6"
                    required
                >

                <button type="submit">Cadastrar</button>
            </form>

            <p class="cadastro-login">
                Ja tem conta?
                <a href="index.php?pagina=login">Entrar no site</a>
            </p>
        </section>
    </main>
</body>
</html>
