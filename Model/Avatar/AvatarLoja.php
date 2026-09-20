<?php
require_once __DIR__ . '/../Moedas/Carteira.php';
require_once __DIR__ . '/CatalogoAvatar.php';

class AvatarLoja
{
    private $pdo;
    private $carteira;

    public function __construct($pdo = null)
    {
        $this->pdo = $pdo ?? Conexao::conectar();
        $this->carteira = new Carteira($this->pdo);
    }

    public function inventario($usuarioId)
    {
        $stmt = $this->pdo->prepare('SELECT item_id FROM avatar_inventario WHERE usuario_id = ?');
        $stmt->execute([$usuarioId]);
        return array_fill_keys($stmt->fetchAll(PDO::FETCH_COLUMN), true);
    }

    public function equipado($usuarioId)
    {
        $stmt = $this->pdo->prepare('SELECT categoria, item_id FROM avatar_equipamentos WHERE usuario_id = ?');
        $stmt->execute([$usuarioId]);
        $equipado = CatalogoAvatar::iniciais();
        $itens = CatalogoAvatar::itens();
        foreach ($stmt->fetchAll() as $registro) {
            $item = $itens[$registro['item_id']] ?? null;
            if ($item && $item['categoria'] === $registro['categoria']) {
                $equipado[$registro['categoria']] = $registro['item_id'];
            }
        }
        return $equipado;
    }

    public function habilidadesEquipadas($usuarioId)
    {
        $equipado = $this->equipado($usuarioId);
        $inventario = $this->inventario($usuarioId);
        $habilidades = CatalogoAvatar::habilidades();
        return array_values(array_filter($equipado, function ($itemId) use ($inventario, $habilidades) {
            return isset($inventario[$itemId], $habilidades[$itemId]);
        }));
    }

    public function comprar($usuarioId, $itemId)
    {
        $itens = CatalogoAvatar::itens();
        if (!is_string($itemId) || !isset($itens[$itemId]) || $itens[$itemId]['preco'] === 0) {
            throw new DomainException('Este item não está à venda.');
        }
        $item = $itens[$itemId];
        $this->pdo->beginTransaction();
        try {
            $saldo = $this->carteira->bloquear($usuarioId);
            $stmt = $this->pdo->prepare('SELECT 1 FROM avatar_inventario WHERE usuario_id = ? AND item_id = ?');
            $stmt->execute([$usuarioId, $itemId]);
            if ($stmt->fetchColumn()) throw new DomainException('Você já possui este item.');
            if ($saldo < $item['preco']) throw new DomainException('Moedas insuficientes para esta compra.');
            $stmt = $this->pdo->prepare('UPDATE moedas_carteiras SET saldo = saldo - ? WHERE usuario_id = ? AND saldo >= ?');
            $stmt->execute([$item['preco'], $usuarioId, $item['preco']]);
            if ($stmt->rowCount() !== 1) throw new RuntimeException('Não foi possível atualizar o saldo.');
            $stmt = $this->pdo->prepare('INSERT INTO avatar_inventario (usuario_id, item_id, comprado_em) VALUES (?, ?, UTC_TIMESTAMP())');
            $stmt->execute([$usuarioId, $itemId]);
            $this->equiparRegistro($usuarioId, $item['categoria'], $itemId);
            $this->pdo->commit();
            return $this->carteira->saldo($usuarioId);
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            throw $exception;
        }
    }

    public function equipar($usuarioId, $itemId)
    {
        $itens = CatalogoAvatar::itens();
        if (!is_string($itemId) || !isset($itens[$itemId])) throw new DomainException('Item inválido.');
        $item = $itens[$itemId];
        $this->pdo->beginTransaction();
        try {
            $this->carteira->bloquear($usuarioId);
            if ($item['preco'] > 0) {
                $stmt = $this->pdo->prepare('SELECT 1 FROM avatar_inventario WHERE usuario_id = ? AND item_id = ?');
                $stmt->execute([$usuarioId, $itemId]);
                if (!$stmt->fetchColumn()) throw new DomainException('Compre este item antes de equipá-lo.');
            }
            $this->equiparRegistro($usuarioId, $item['categoria'], $itemId);
            $this->pdo->commit();
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            throw $exception;
        }
    }

    public function removerAcessorio($usuarioId)
    {
        $this->pdo->beginTransaction();
        try {
            $this->carteira->bloquear($usuarioId);
            $stmt = $this->pdo->prepare("DELETE FROM avatar_equipamentos WHERE usuario_id = ? AND categoria = 'acessorio'");
            $stmt->execute([$usuarioId]);
            $this->pdo->commit();
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            throw $exception;
        }
    }

    private function equiparRegistro($usuarioId, $categoria, $itemId)
    {
        $stmt = $this->pdo->prepare('INSERT INTO avatar_equipamentos (usuario_id, categoria, item_id) VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE item_id = VALUES(item_id)');
        $stmt->execute([$usuarioId, $categoria, $itemId]);
    }
}
