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
