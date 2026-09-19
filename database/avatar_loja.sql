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
