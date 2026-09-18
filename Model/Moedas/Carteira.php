<?php
require_once __DIR__ . '/../Database/Conexao.php';

class Carteira
{
    private $pdo;

    public function __construct($pdo = null)
    {
        $this->pdo = $pdo ?? Conexao::conectar();
    }

    public static function recompensaPorErros($erros)
    {
        return $erros === 0 ? 10 : ($erros === 1 ? 5 : 2);
    }

    public function saldo($usuarioId)
    {
        $stmt = $this->pdo->prepare('SELECT saldo FROM moedas_carteiras WHERE usuario_id = ?');
        $stmt->execute([$usuarioId]);
        return (int) $stmt->fetchColumn();
    }

    public function historico($usuarioId)
    {
        $stmt = $this->pdo->prepare("SELECT tema, moedas_ganhas, saldo_apos, concluido_em FROM quiz_rodadas
            WHERE usuario_id = ? AND estado = 'concluida' ORDER BY concluido_em DESC, id DESC LIMIT 10");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll();
    }

    public function bloquear($usuarioId)
    {
        $stmt = $this->pdo->prepare('INSERT INTO moedas_carteiras (usuario_id, saldo) VALUES (?, 0)
            ON DUPLICATE KEY UPDATE usuario_id = VALUES(usuario_id)');
        $stmt->execute([$usuarioId]);
        $stmt = $this->pdo->prepare('SELECT saldo FROM moedas_carteiras WHERE usuario_id = ? FOR UPDATE');
        $stmt->execute([$usuarioId]);
        return (int) $stmt->fetchColumn();
    }
}
