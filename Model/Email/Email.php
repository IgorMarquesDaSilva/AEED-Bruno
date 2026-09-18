<?php

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    private $config;

    public function __construct($config = null)
    {
        if ($config === null) {
            $pasta = __DIR__ . '/../../config/';
            $config = require $pasta . 'email.example.php';
            if (is_file($pasta . 'email.local.php')) {
                $config = array_replace($config, require $pasta . 'email.local.php');
            }
            foreach (['app_url', 'host', 'port', 'encryption', 'username', 'password', 'from_email', 'from_name'] as $chave) {
                $variavel = $chave === 'app_url' ? 'AEED_APP_URL' : 'AEED_SMTP_' . strtoupper($chave);
                $valor = getenv($variavel);
                if ($valor !== false) $config[$chave] = $valor;
            }
        }
        $this->config = $config;
    }

    public function validarConfiguracao()
    {
        $autoload = __DIR__ . '/../../vendor/autoload.php';
        if (!is_file($autoload)) {
            throw new RuntimeException('Instale as dependencias com composer install.');
        }
        require_once $autoload;
        $c = $this->config;
        $url = parse_url($c['app_url'] ?? '');
        $local = isset($url['host']) && in_array($url['host'], ['localhost', '127.0.0.1', '[::1]'], true);
        if (!$url || empty($url['host']) || !in_array($url['scheme'] ?? '', $local ? ['http', 'https'] : ['https'], true) ||
            isset($url['user']) || isset($url['pass']) || isset($url['query']) || isset($url['fragment'])) {
            throw new RuntimeException('Configure a URL publica do projeto. Fora do localhost, utilize HTTPS.');
        }
        $host = $c['host'] ?? '';
        $criptografia = $c['encryption'] ?? '';
        $smtpLocal = in_array($host, ['localhost', '127.0.0.1', '::1'], true);
        if (!is_string($host) || $host === '' || preg_match('/[\s;\/]/', $host) ||
            !filter_var($c['from_email'] ?? '', FILTER_VALIDATE_EMAIL) ||
            !filter_var($c['port'] ?? 0, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 65535]]) ||
            !in_array($criptografia, $smtpLocal ? ['', 'tls', 'ssl'] : ['tls', 'ssl'], true) ||
            (!$smtpLocal && (empty($c['username']) || empty($c['password'])))) {
            throw new RuntimeException('Configure o servidor SMTP e o remetente em config/email.local.php.');
        }
    }

    public function enviarRecuperacao($destinatario, $token)
    {
        $this->validarConfiguracao();
        // URL configurada pelo administrador, nunca pelo cabecalho Host da requisicao.
        $link = rtrim($this->config['app_url'], '/') . '/index.php?pagina=redefinirSenha&token=' . rawurlencode($token);
        $texto = "Recebemos uma solicitação para redefinir sua senha no ED em C#.\n\n"
            . "Acesse este link para escolher uma nova senha:\n$link\n\n"
            . "O link é válido por 30 minutos e só pode ser usado uma vez.\n"
            . "Se você não fez esta solicitação, ignore este e-mail. Sua senha não foi alterada.";
        $this->enviar($destinatario, 'Redefinição de senha - ED em C#', $texto);
    }

    public function enviarConfirmacao($destinatario)
    {
        $this->validarConfiguracao();
        $this->enviar($destinatario, 'Senha alterada - ED em C#',
            "Sua senha do ED em C# foi alterada.\n\nOs acessos anteriores foram invalidados. "
            . "Faça login novamente com sua nova senha.\n\n"
            . "Se você não reconhece esta alteração, solicite uma nova recuperação e entre em contato com o responsável pelo site.");
    }

    private function enviar($destinatario, $assunto, $texto)
    {
        $c = $this->config;
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $c['host'];
        $mail->Port = (int) $c['port'];
        $mail->SMTPSecure = $c['encryption'];
        $mail->SMTPAuth = $c['username'] !== '';
        $mail->Username = $c['username'];
        $mail->Password = $c['password'];
        $mail->SMTPAutoTLS = $c['encryption'] !== '';
        $mail->SMTPDebug = 0;
        $mail->Timeout = 10;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($c['from_email'], $c['from_name']);
        $mail->addAddress($destinatario);
        $mail->Subject = $assunto;
        $mail->Body = $texto;
        $mail->send();
    }
}
