<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Database/Conexao.php';

$pdo = Conexao::conectar();
$colunas = $pdo->query('SHOW COLUMNS FROM usuarios')->fetchAll(PDO::FETCH_COLUMN);
$necessarias = [
    'reset_token' => 'VARCHAR(64) DEFAULT NULL',
    'reset_expira' => 'DATETIME DEFAULT NULL',
    'sessao_versao' => 'INT UNSIGNED NOT NULL DEFAULT 0'
];
foreach ($necessarias as $coluna => $definicao) {
    if (!in_array($coluna, $colunas, true)) {
        $pdo->exec("ALTER TABLE usuarios ADD COLUMN $coluna $definicao");
        echo "Coluna adicionada: $coluna\n";
    }
}
$indices = $pdo->query('SHOW INDEX FROM usuarios')->fetchAll(PDO::FETCH_COLUMN, 2);
if (!in_array('idx_usuarios_reset_token', $indices, true)) {
    $pdo->exec('CREATE INDEX idx_usuarios_reset_token ON usuarios (reset_token)');
}
$pdo->exec('CREATE TABLE IF NOT EXISTS recuperacao_limites (
    chave CHAR(64) NOT NULL PRIMARY KEY,
    inicio DATETIME NOT NULL,
    tentativas INT UNSIGNED NOT NULL DEFAULT 0,
    INDEX idx_recuperacao_inicio (inicio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
echo "Recuperacao de senha atualizada; usuarios preservados.\n";
