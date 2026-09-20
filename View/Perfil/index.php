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
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8'); ?>">

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

<div class="perfil-lateral">
<section class="perfil-avatar" aria-labelledby="avatar-titulo">
    <span class="perfil-tag">Meu personagem</span>
    <h2 id="avatar-titulo">Avatar</h2>
    <div class="perfil-avatar-palco"><?php echo desenharAvatar($avatarEquipado); ?></div>
    <?php if ($erroAvatar !== '') { ?>
        <p class="perfil-erro" role="alert"><?php echo htmlspecialchars($erroAvatar); ?></p>
    <?php } else { ?>
        <a class="perfil-link-quiz" href="index.php?pagina=loja&vista=armario">Personalizar avatar</a>
    <?php } ?>
</section>

<section id="moedas" class="perfil-moedas" aria-labelledby="moedas-titulo">
    <span class="perfil-tag">Minhas recompensas</span>
    <h2 id="moedas-titulo">Moedas</h2>
    <dl class="perfil-saldo">
        <dt>Saldo disponível</dt>
        <dd><?php echo number_format($saldoMoedas, 0, ',', '.'); ?> <span>moedas</span></dd>
    </dl>
    <h3>Últimas rodadas</h3>
    <?php if ($erroMoedas !== '') { ?>
        <p class="perfil-erro" role="alert"><?php echo htmlspecialchars($erroMoedas); ?></p>
    <?php } elseif (!$historicoMoedas) { ?>
        <p class="perfil-nota">Nenhuma rodada concluída.</p>
    <?php } else { ?>
        <ul class="perfil-historico">
            <?php foreach ($historicoMoedas as $registro) { ?>
                <li>
                    <div>
                        <strong><?php echo htmlspecialchars($temasQuiz[$registro['tema']] ?? 'Quiz'); ?></strong>
                        <span><?php echo htmlspecialchars($registro['data_local']); ?></span>
                    </div>
                    <span class="perfil-ganho">+<?php echo (int) $registro['moedas_ganhas']; ?> moedas</span>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
    <a class="perfil-link-quiz" href="index.php?pagina=quiz">Ir para o quiz</a>
</section>
</div>

<?php require_once "View/Shared/footer.php"; ?>
