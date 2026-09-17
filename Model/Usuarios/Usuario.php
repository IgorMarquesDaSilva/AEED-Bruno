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

    public function buscarPorId($id)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT id, nome, email, ativo
                FROM usuarios
                WHERE id = :id AND ativo = 1
                LIMIT 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function salvarTokenLogin($id, $token, $expiraEm)
    {
        $conexao = Conexao::conectar();

        $sql = 'UPDATE usuarios
                SET lembrar_token = :token, lembrar_expira = :expira
                WHERE id = :id';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':token', hash('sha256', $token));
        $stmt->bindValue(':expira', $expiraEm);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function buscarPorTokenLogin($id, $token)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT id, nome, email, lembrar_token
                FROM usuarios
                WHERE id = :id
                  AND ativo = 1
                  AND lembrar_token IS NOT NULL
                  AND lembrar_expira > NOW()
                LIMIT 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch();

        if (!$usuario) {
            return false;
        }

        if (!hash_equals($usuario['lembrar_token'], hash('sha256', $token))) {
            return false;
        }

        return $usuario;
    }

    public function limparTokenLogin($id)
    {
        $conexao = Conexao::conectar();

        $sql = 'UPDATE usuarios
                SET lembrar_token = NULL, lembrar_expira = NULL
                WHERE id = :id';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
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

    public function emailExisteParaOutro($email, $id)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT id FROM usuarios WHERE email = :email AND id <> :id LIMIT 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }

    public function atualizarPerfil($id, $nome, $email)
    {
        $conexao = Conexao::conectar();

        $sql = 'UPDATE usuarios
                SET nome = :nome, email = :email
                WHERE id = :id';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function buscarSenhaPorId($id)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT senha FROM usuarios WHERE id = :id AND ativo = 1 LIMIT 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch();

        return $usuario ? $usuario['senha'] : null;
    }

    public function atualizarSenha($id, $senha)
    {
        $conexao = Conexao::conectar();

        $sql = 'UPDATE usuarios
                SET senha = :senha, lembrar_token = NULL, lembrar_expira = NULL
                WHERE id = :id';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function salvarTokenReset($email, $token, $expiraEm)
    {
        $conexao = Conexao::conectar();

        $sql = 'UPDATE usuarios
                SET reset_token = :token, reset_expira = :expira
                WHERE email = :email AND ativo = 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':token', hash('sha256', $token));
        $stmt->bindValue(':expira', $expiraEm);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function buscarPorTokenReset($token)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT id, nome, email, reset_token
                FROM usuarios
                WHERE ativo = 1
                  AND reset_token IS NOT NULL
                  AND reset_expira > NOW()';

        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        while ($usuario = $stmt->fetch()) {
            if (hash_equals($usuario['reset_token'], hash('sha256', $token))) {
                return $usuario;
            }
        }

        return false;
    }

    public function redefinirSenhaPorToken($id, $senha)
    {
        $conexao = Conexao::conectar();

        $sql = 'UPDATE usuarios
                SET senha = :senha,
                    reset_token = NULL,
                    reset_expira = NULL,
                    lembrar_token = NULL,
                    lembrar_expira = NULL
                WHERE id = :id';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

?>