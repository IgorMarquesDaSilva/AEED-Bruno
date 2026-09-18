<?php
require_once __DIR__ . '/../Database/Conexao.php';

class Usuario
{
    public function buscarPorEmail($email)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT id, nome, email, senha, ativo, sessao_versao
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

        $sql = 'SELECT id, nome, email, ativo, sessao_versao
                FROM usuarios
                WHERE id = :id AND ativo = 1
                LIMIT 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function salvarTokenLogin($id, $token, $expiraEm, $sessaoVersao)
    {
        $conexao = Conexao::conectar();

        $sql = 'UPDATE usuarios
                SET lembrar_token = :token, lembrar_expira = :expira
                WHERE id = :id AND sessao_versao = :versao AND ativo = 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':token', hash('sha256', $token));
        $stmt->bindValue(':expira', $expiraEm);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':versao', $sessaoVersao, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() === 1;
    }

    public function buscarPorTokenLogin($id, $token)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT id, nome, email, lembrar_token, sessao_versao
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
                SET nome = :nome, email = :email, reset_token = NULL, reset_expira = NULL
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
                SET senha = :senha, lembrar_token = NULL, lembrar_expira = NULL,
                    reset_token = NULL, reset_expira = NULL, sessao_versao = sessao_versao + 1
                WHERE id = :id';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function salvarTokenReset($email, $token)
    {
        $conexao = Conexao::conectar();

        $sql = 'UPDATE usuarios
                SET reset_token = :token, reset_expira = DATE_ADD(UTC_TIMESTAMP(), INTERVAL 30 MINUTE)
                WHERE email = :email AND ativo = 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':token', hash('sha256', $token));
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function buscarPorTokenReset($token)
    {
        $conexao = Conexao::conectar();

        $sql = 'SELECT id, nome, email
                FROM usuarios
                WHERE ativo = 1
                  AND reset_token = :token
                  AND reset_expira > UTC_TIMESTAMP()
                LIMIT 1';

        $stmt = $conexao->prepare($sql);
        $stmt->execute([':token' => hash('sha256', $token)]);
        return $stmt->fetch();
    }

    public function invalidarTokenReset($token)
    {
        $stmt = Conexao::conectar()->prepare('UPDATE usuarios SET reset_token = NULL, reset_expira = NULL WHERE reset_token = :token');
        $stmt->execute([':token' => hash('sha256', $token)]);
    }

    public function redefinirSenhaPorToken($token, $senha)
    {
        $conexao = Conexao::conectar();

        $sql = 'UPDATE usuarios
                SET senha = :senha,
                    reset_token = NULL,
                    reset_expira = NULL,
                    lembrar_token = NULL,
                    lembrar_expira = NULL,
                    sessao_versao = sessao_versao + 1
                WHERE reset_token = :token AND reset_expira > UTC_TIMESTAMP() AND ativo = 1';

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':senha', password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(':token', hash('sha256', $token));
        $stmt->execute();
        return $stmt->rowCount() === 1;
    }
}

?>
