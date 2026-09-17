<?php require_once "View/Shared/header.php"; ?>

<section class="perfil-painel">

    <span class="perfil-tag">Minha conta</span>
    <h1>Meu Perfil</h1>
    <p>Atualize seus dados de cadastro ou altere sua senha de acesso.</p>

    <?php if (!empty($erro)) { ?>
        <div class="perfil-erro">
            <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php } ?>

    <?php if (!empty($sucesso)) { ?>
        <div class="perfil-sucesso">
            <?php echo htmlspecialchars($sucesso); ?>
        </div>
    <?php } ?>

    <form class="perfil-formulario" method="POST" action="index.php?pagina=perfil">

        <h2>Dados pessoais</h2>

        <label for="nome">Nome</label>
        <input
            type="text"
            id="nome"
            name="nome"
            value="<?php echo htmlspecialchars($nome); ?>"
            maxlength="100"
            required
        >

        <label for="email">E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            value="<?php echo htmlspecialchars($email); ?>"
            maxlength="150"
            required
        >

        <h2>Alterar senha</h2>
        <p class="perfil-nota">Preencha os campos abaixo apenas se quiser trocar sua senha. Deixe em branco para manter a senha atual.</p>

        <label for="senha_atual">Senha atual</label>
        <input
            type="password"
            id="senha_atual"
            name="senha_atual"
            placeholder="Digite sua senha atual"
        >

        <label for="nova_senha">Nova senha</label>
        <input
            type="password"
            id="nova_senha"
            name="nova_senha"
            placeholder="Minimo de 6 caracteres"
        >

        <label for="confirmar_senha">Confirmar nova senha</label>
        <input
            type="password"
            id="confirmar_senha"
            name="confirmar_senha"
            placeholder="Repita a nova senha"
        >

        <button type="submit">Salvar alterações</button>
    </form>

</section>

<?php require_once "View/Shared/footer.php"; ?>