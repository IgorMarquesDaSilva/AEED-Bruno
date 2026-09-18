<?php
require_once __DIR__ . '/../Database/Conexao.php';

class LimiteRecuperacao
{
    public function permitir($email, $ip)
    {
        $pdo = Conexao::conectar();
        $limites = [
            hash('sha256', 'email:' . strtolower(trim($email))) => [3, 3600],
            hash('sha256', 'ip:' . $ip) => [10, 900]
        ];
        ksort($limites);
        $pdo->beginTransaction();
        try {
            $permitido = true;
            // Bloqueios no banco mantem os limites mesmo com novas sessoes ou envios simultaneos.
            foreach ($limites as $chave => [$maximo, $segundos]) {
                $stmt = $pdo->prepare('INSERT IGNORE INTO recuperacao_limites (chave, inicio, tentativas) VALUES (?, UTC_TIMESTAMP(), 0)');
                $stmt->execute([$chave]);
                $stmt = $pdo->prepare('SELECT tentativas, TIMESTAMPDIFF(SECOND, inicio, UTC_TIMESTAMP()) AS idade FROM recuperacao_limites WHERE chave = ? FOR UPDATE');
                $stmt->execute([$chave]);
                $registro = $stmt->fetch();
                if ((int) $registro['idade'] >= $segundos) {
                    $stmt = $pdo->prepare('UPDATE recuperacao_limites SET inicio = UTC_TIMESTAMP(), tentativas = 1 WHERE chave = ?');
                } elseif ((int) $registro['tentativas'] >= $maximo) {
                    $permitido = false;
                    continue;
                } else {
                    $stmt = $pdo->prepare('UPDATE recuperacao_limites SET tentativas = tentativas + 1 WHERE chave = ?');
                }
                $stmt->execute([$chave]);
            }
            $pdo->commit();
            $pdo->exec('DELETE FROM recuperacao_limites WHERE inicio < DATE_SUB(UTC_TIMESTAMP(), INTERVAL 1 DAY)');
            return $permitido;
        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $exception;
        }
    }
}
