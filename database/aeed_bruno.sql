CREATE DATABASE IF NOT EXISTS aeed_bruno
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE aeed_bruno;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_usuarios_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuarios (nome, email, senha, ativo)
VALUES (
    'Administrador',
    'admin@aeed.com',
    '$2y$10$/FEUjeQRj4U6hu5u7NSEEOLYMMqzhHCJt6FgDapef9hgm0IYWTKSS',
    1
)
ON DUPLICATE KEY UPDATE
    nome = VALUES(nome),
    senha = VALUES(senha),
    ativo = VALUES(ativo);
