CREATE TABLE IF NOT EXISTS quiz_dicas (
    usuario_id INT NOT NULL,
    pergunta_id VARCHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    custo_moedas TINYINT UNSIGNED NOT NULL,
    comprado_em DATETIME NOT NULL,
    PRIMARY KEY (usuario_id, pergunta_id),
    CONSTRAINT fk_quiz_dica_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
