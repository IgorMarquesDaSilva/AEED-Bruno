<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Database/Conexao.php';

Conexao::conectar()->exec(file_get_contents(__DIR__ . '/avatar_loja.sql'));
echo "Avatar e loja atualizados. Contas, moedas e rodadas foram preservadas.\n";
