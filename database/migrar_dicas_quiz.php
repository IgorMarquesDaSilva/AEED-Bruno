<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Database/Conexao.php';

Conexao::conectar()->exec(file_get_contents(__DIR__ . '/dicas_quiz.sql'));
echo "Dicas do quiz atualizadas. Usuarios, moedas e rodadas foram preservados.\n";
