<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Usuarios/RecuperacaoSenha.php';
set_error_handler(function ($nivel, $mensagem, $arquivo, $linha) {
    throw new ErrorException($mensagem, 0, $nivel, $arquivo, $linha);
});

$verificacoes = 0;
function verificarRecuperacao($condicao, $mensagem)
{
    global $verificacoes;
    $verificacoes++;
    if (!$condicao) throw new RuntimeException($mensagem);
}
function rejeitarSenha($callback)
{
    try { $callback(); } catch (DomainException $exception) {
        verificarRecuperacao(true, 'Entrada rejeitada.');
        return;
    }
    verificarRecuperacao(false, 'A entrada deveria ser rejeitada.');
}

$emailTeste = new class {
    public $tokens = [];
    public $confirmacoes = 0;
    public $falhar = false;
    public function validarConfiguracao() {}
    public function enviarRecuperacao($email, $token) {
        if ($this->falhar) throw new RuntimeException('Falha SMTP simulada.');
        $this->tokens[] = $token;
    }
    public function enviarConfirmacao($email) { $this->confirmacoes++; }
};
$semLimite = new class { public function permitir($email, $ip) { return true; } };
$usuarios = new Usuario();
$servico = new RecuperacaoSenha($usuarios, $emailTeste, $semLimite);
$pdo = Conexao::conectar();
$email = 'teste-recuperacao-' . bin2hex(random_bytes(8)) . '@example.invalid';
$pdo->beginTransaction();
try {
    $id = $usuarios->cadastrar('Teste de recuperacao', $email, 'SenhaAntiga123');
    $servico->solicitar($email, '127.0.0.1');
    $primeiro = $emailTeste->tokens[0];
    $stmt = $pdo->prepare('SELECT reset_token, TIMESTAMPDIFF(SECOND, UTC_TIMESTAMP(), reset_expira) AS validade FROM usuarios WHERE id = ?');
    $stmt->execute([$id]);
    $registro = $stmt->fetch();
    verificarRecuperacao($registro['reset_token'] === hash('sha256', $primeiro), 'Somente o hash fica no banco.');
    verificarRecuperacao($registro['validade'] > 1790 && $registro['validade'] <= 1800, 'Expiracao em 30 minutos.');
    verificarRecuperacao($servico->tokenValido($primeiro), 'Token ativo.');
    foreach (['', [], null, str_repeat('z', 64), str_repeat('a', 63)] as $token) {
        verificarRecuperacao(!$servico->tokenValido($token), 'Token malformado rejeitado.');
    }
    $servico->solicitar('ausente-' . $email, '127.0.0.1');
    verificarRecuperacao(count($emailTeste->tokens) === 1, 'Nao enviar para conta inexistente.');
    $servico->solicitar($email, '127.0.0.1');
    $segundo = $emailTeste->tokens[1];
    verificarRecuperacao(!$servico->tokenValido($primeiro), 'Novo link invalida o anterior.');
    verificarRecuperacao(!$usuarios->redefinirSenhaPorToken($primeiro, 'OutraSenha123'), 'Token antigo nao muda senha.');
    rejeitarSenha(function () use ($servico, $segundo) { $servico->redefinir($segundo, '123', '123'); });
    rejeitarSenha(function () use ($servico, $segundo) { $servico->redefinir($segundo, 'SenhaNova123', 'Diferente123'); });
    rejeitarSenha(function () use ($servico, $segundo) { $servico->redefinir($segundo, [], []); });
    rejeitarSenha(function () use ($servico, $segundo) { $servico->redefinir($segundo, str_repeat('x', 73), str_repeat('x', 73)); });
    rejeitarSenha(function () use ($servico, $segundo) { $servico->redefinir($segundo, "abc\0def", "abc\0def"); });
    verificarRecuperacao($servico->tokenValido($segundo), 'Validacao nao consome token.');
    $usuarios->salvarTokenLogin($id, 'lembrar-teste', date('Y-m-d H:i:s', time() + 3600), 0);
    verificarRecuperacao($servico->redefinir($segundo, 'SenhaNova123', 'SenhaNova123'), 'Senha redefinida.');
    verificarRecuperacao(password_verify('SenhaNova123', $usuarios->buscarSenhaPorId($id)), 'Nova senha aceita.');
    verificarRecuperacao(!password_verify('SenhaAntiga123', $usuarios->buscarSenhaPorId($id)), 'Senha antiga rejeitada.');
    verificarRecuperacao(!$servico->redefinir($segundo, 'OutraSenha123', 'OutraSenha123'), 'Token de uso unico.');
    verificarRecuperacao((int) $usuarios->buscarPorId($id)['sessao_versao'] === 1, 'Sessoes antigas revogadas.');
    verificarRecuperacao(!$usuarios->buscarPorTokenLogin($id, 'lembrar-teste'), 'Cookie antigo revogado.');
    verificarRecuperacao(!$usuarios->salvarTokenLogin($id, 'cookie-atrasado', date('Y-m-d H:i:s', time() + 3600), 0), 'Login anterior ao reset nao pode recriar cookie depois dele.');
    verificarRecuperacao($emailTeste->confirmacoes === 1, 'Notificacao de alteracao.');
    $usuarios->salvarTokenReset($email, $primeiro);
    $pdo->prepare('UPDATE usuarios SET reset_expira = DATE_SUB(UTC_TIMESTAMP(), INTERVAL 1 SECOND) WHERE id = ?')->execute([$id]);
    verificarRecuperacao(!$servico->tokenValido($primeiro), 'Link expirado rejeitado.');
    verificarRecuperacao(!$usuarios->redefinirSenhaPorToken($primeiro, 'OutraSenha123'), 'Expiracao validada no UPDATE atomico.');
    $usuarios->salvarTokenReset($email, $primeiro);
    $usuarios->atualizarSenha($id, 'SenhaPerfil123');
    verificarRecuperacao(!$servico->tokenValido($primeiro), 'Troca pelo perfil invalida reset pendente.');
    $usuarios->salvarTokenReset($email, $primeiro);
    $usuarios->atualizarPerfil($id, 'Teste atualizado', $email);
    verificarRecuperacao(!$servico->tokenValido($primeiro), 'Edicao do perfil invalida reset pendente.');
    $emailTeste->falhar = true;
    $servico->solicitar($email, '127.0.0.1');
    $stmt = $pdo->prepare('SELECT reset_token FROM usuarios WHERE id = ?');
    $stmt->execute([$id]);
    verificarRecuperacao($stmt->fetchColumn() === null, 'Falha de envio invalida o token criado.');
    $pdo->prepare('UPDATE usuarios SET ativo = 0 WHERE id = ?')->execute([$id]);
    verificarRecuperacao(!$usuarios->salvarTokenReset($email, $primeiro), 'Conta desativada nao recebe token.');
} finally {
    $pdo->rollBack();
}

$limite = new LimiteRecuperacao();
$ip = 'teste-' . bin2hex(random_bytes(8));
$emails = [$email, 'segundo-' . $email];
$chaves = [hash('sha256', 'ip:' . $ip)];
foreach ($emails as $item) $chaves[] = hash('sha256', 'email:' . strtolower($item));
try {
    for ($i = 0; $i < 3; $i++) verificarRecuperacao($limite->permitir($email, $ip), 'Dentro do limite.');
    verificarRecuperacao(!(new LimiteRecuperacao())->permitir(strtoupper($email), $ip), 'Limite por email persiste e ignora caixa.');
    $pdo->prepare('UPDATE recuperacao_limites SET tentativas = 10 WHERE chave = ?')->execute([$chaves[0]]);
    verificarRecuperacao(!$limite->permitir($emails[1], $ip), 'Limite por IP.');
    $pdo->prepare('UPDATE recuperacao_limites SET inicio = DATE_SUB(UTC_TIMESTAMP(), INTERVAL 2 HOUR) WHERE chave IN (?, ?, ?)')->execute($chaves);
    verificarRecuperacao($limite->permitir($email, $ip), 'Nova janela libera tentativas.');
} finally {
    $pdo->prepare('DELETE FROM recuperacao_limites WHERE chave IN (?, ?, ?)')->execute($chaves);
}

$config = require __DIR__ . '/../config/email.example.php';
$config = array_replace($config, ['host' => '127.0.0.1', 'port' => 1025, 'encryption' => '', 'from_email' => 'teste@example.invalid']);
(new Email($config))->validarConfiguracao();
verificarRecuperacao(true, 'SMTP local de teste permitido.');
foreach ([['host' => 'smtp.example.com'], ['app_url' => 'http://example.com'], ['app_url' => 'https://example.com/?token=1'], ['app_url' => 'https://user:pass@example.com']] as $alteracao) {
    try { (new Email(array_replace($config, $alteracao)))->validarConfiguracao(); }
    catch (RuntimeException $exception) { verificarRecuperacao(true, 'Configuracao insegura rejeitada.'); continue; }
    verificarRecuperacao(false, 'Configuracao deveria ser rejeitada.');
}
echo "$verificacoes verificacoes de recuperacao passaram.\n";
