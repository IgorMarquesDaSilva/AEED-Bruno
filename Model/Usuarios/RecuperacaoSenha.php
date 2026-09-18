<?php
require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/LimiteRecuperacao.php';
require_once __DIR__ . '/../Email/Email.php';

class RecuperacaoSenha
{
    private $usuarios;
    private $email;
    private $limite;

    public function __construct($usuarios = null, $email = null, $limite = null)
    {
        $this->usuarios = $usuarios ?? new Usuario();
        $this->email = $email ?? new Email();
        $this->limite = $limite ?? new LimiteRecuperacao();
    }

    public function solicitar($email, $ip)
    {
        $this->email->validarConfiguracao();
        if (!$this->limite->permitir($email, $ip)) return;
        $token = bin2hex(random_bytes(32));
        if (!$this->usuarios->salvarTokenReset($email, $token)) return;
        try {
            $this->email->enviarRecuperacao($email, $token);
        } catch (Throwable $exception) {
            $this->usuarios->invalidarTokenReset($token);
            // Nao registrar token, destinatario ou credenciais SMTP nos logs.
            error_log('AEED: falha no envio SMTP de recuperacao; confira a configuracao do servidor de email.');
        }
    }

    public function tokenValido($token)
    {
        return is_string($token) && preg_match('/\A[a-f0-9]{64}\z/', $token) && $this->usuarios->buscarPorTokenReset($token) !== false;
    }

    public function redefinir($token, $senha, $confirmacao)
    {
        if (!is_string($senha) || !is_string($confirmacao) || strlen($senha) < 6 || strlen($senha) > 72 || strpos($senha, "\0") !== false) {
            throw new DomainException('A senha deve ter de 6 a 72 bytes, sem caracteres nulos.');
        }
        if ($senha !== $confirmacao) throw new DomainException('As senhas não coincidem.');
        if (!is_string($token) || !preg_match('/\A[a-f0-9]{64}\z/', $token)) return false;
        $usuario = $this->usuarios->buscarPorTokenReset($token);
        if (!$usuario || !$this->usuarios->redefinirSenhaPorToken($token, $senha)) return false;
        try {
            $this->email->enviarConfirmacao($usuario['email']);
        } catch (Throwable $exception) {
            error_log('AEED: senha alterada, mas nao foi possivel enviar a notificacao por email.');
        }
        return true;
    }
}
