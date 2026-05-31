<?php
require_once __DIR__ . '/../Database/Conexao.php';

class Usuario
{
    public function buscarPorEmail($email)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT id, nome, email, senha, ativo
                FROM usuarios
                WHERE email = :email AND ativo = 1
                LIMIT 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function emailExiste($email)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT id FROM usuarios WHERE email = :email LIMIT 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }

    public function cadastrar($nome, $email, $senha)
    {
        $conexao = Conexao::conectar();

        $sql = 'INSERT INTO usuarios (nome, email, senha, ativo)
                VALUES (:nome, :email, :senha, 1)';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT));
        $stmt->execute();

        return (int) $conexao->lastInsertId();
    }
}

?>