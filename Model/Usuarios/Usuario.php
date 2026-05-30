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
}

?>
