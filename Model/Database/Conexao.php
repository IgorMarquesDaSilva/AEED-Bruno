<?php

class Conexao
{
    private static $conexao = null;

    public static function conectar()
    {
        if (self::$conexao === null) {
            $host = 'localhost';
            $banco = 'aeed_bruno';
            $usuario = 'root';
            $senha = '';

            $dsn = "mysql:host={$host};dbname={$banco};charset=utf8mb4";

            self::$conexao = new PDO($dsn, $usuario, $senha, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return self::$conexao;
    }

    public static function tabelaAusente($exception)
    {
        return $exception instanceof PDOException && $exception->getCode() === '42S02';
    }

    // Cria apenas as tabelas que faltam; o esquema usa CREATE TABLE IF NOT EXISTS.
    public static function garantirEsquema()
    {
        $pdo = self::conectar();
        if ($pdo->inTransaction()) $pdo->rollBack();
        $pdo->exec(file_get_contents(__DIR__ . '/../../database/aeed_bruno.sql'));
    }
}

?>
