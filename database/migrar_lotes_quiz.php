<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../Model/Database/Conexao.php';

Conexao::conectar()->exec(file_get_contents(__DIR__ . '/lotes_quiz.sql'));
echo "Lotes diarios do quiz atualizados. Rodadas, usuarios e moedas foram preservados.\n";
