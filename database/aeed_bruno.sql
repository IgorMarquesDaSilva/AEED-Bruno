-- Esquema para instalacao nova. Crie e selecione o banco aeed_bruno antes de importar.
-- Sem contas, senhas, tokens ou dados de uso: cadastre o primeiro usuario pelo site.

CREATE TABLE IF NOT EXISTS usuarios (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    lembrar_token VARCHAR(64) DEFAULT NULL,
    lembrar_expira DATETIME DEFAULT NULL,
    reset_token VARCHAR(64) DEFAULT NULL,
    reset_expira DATETIME DEFAULT NULL,
    sessao_versao INT UNSIGNED NOT NULL DEFAULT 0,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_usuarios_email (email),
    INDEX idx_usuarios_reset_token (reset_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS recuperacao_limites (
    chave CHAR(64) NOT NULL PRIMARY KEY,
    inicio DATETIME NOT NULL,
    tentativas INT UNSIGNED NOT NULL DEFAULT 0,
    INDEX idx_recuperacao_inicio (inicio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS moedas_carteiras (
    usuario_id INT NOT NULL PRIMARY KEY,
    saldo INT UNSIGNED NOT NULL DEFAULT 0,
    CONSTRAINT fk_carteira_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS quiz_rodadas (
    id CHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL PRIMARY KEY,
    usuario_id INT NOT NULL,
    tema VARCHAR(32) NOT NULL,
    estado VARCHAR(12) NOT NULL DEFAULT 'andamento',
    dados JSON NOT NULL,
    criado_em DATETIME NOT NULL,
    concluido_em DATETIME DEFAULT NULL,
    moedas_ganhas INT UNSIGNED NOT NULL DEFAULT 0,
    saldo_apos INT UNSIGNED DEFAULT NULL,
    INDEX idx_rodadas_usuario (usuario_id, estado, concluido_em),
    CONSTRAINT fk_rodada_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS quiz_respostas (
    rodada_id CHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    pergunta_id VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    dia DATE DEFAULT NULL,
    alternativa TINYINT UNSIGNED NOT NULL,
    correta TINYINT UNSIGNED NOT NULL,
    moedas_previstas TINYINT UNSIGNED NOT NULL DEFAULT 0,
    moedas_recebidas TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (rodada_id, pergunta_id),
    CONSTRAINT fk_resposta_rodada FOREIGN KEY (rodada_id) REFERENCES quiz_rodadas (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS moedas_questoes_dia (
    usuario_id INT NOT NULL,
    pergunta_id VARCHAR(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    dia DATE NOT NULL,
    erros INT UNSIGNED NOT NULL DEFAULT 0,
    moedas_creditadas TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (usuario_id, pergunta_id, dia),
    CONSTRAINT fk_questao_dia_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS avatar_inventario (
    usuario_id INT NOT NULL,
    item_id VARCHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    comprado_em DATETIME NOT NULL,
    PRIMARY KEY (usuario_id, item_id),
    CONSTRAINT fk_avatar_inventario_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS avatar_equipamentos (
    usuario_id INT NOT NULL,
    categoria VARCHAR(16) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    item_id VARCHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    PRIMARY KEY (usuario_id, categoria),
    CONSTRAINT fk_avatar_equipamento_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS quiz_lotes_dia (
    usuario_id INT NOT NULL,
    tema VARCHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    dia DATE NOT NULL,
    perguntas JSON NOT NULL,
    usadas JSON NOT NULL,
    renovacoes INT UNSIGNED NOT NULL DEFAULT 0,
    moedas_gastas INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (usuario_id, tema, dia),
    CONSTRAINT fk_lote_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS quiz_dicas (
    usuario_id INT NOT NULL,
    pergunta_id VARCHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    custo_moedas TINYINT UNSIGNED NOT NULL,
    comprado_em DATETIME NOT NULL,
    PRIMARY KEY (usuario_id, pergunta_id),
    CONSTRAINT fk_quiz_dica_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
