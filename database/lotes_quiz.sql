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
