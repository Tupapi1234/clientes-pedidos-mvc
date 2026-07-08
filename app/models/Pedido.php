<?php
class Pedido
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerTodos()
    {
        $stmt = $this->pdo->query(
            "SELECT p.*, c.nombre AS cliente_nombre
             FROM pedidos p
             INNER JOIN clientes c ON p.cliente_id = c.id
             ORDER BY p.id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
        return $pedido ?: null;
    }

    public function guardar($clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO pedidos (cliente_id, producto, cantidad, precio_unitario, estado, fecha_pedido)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido]);
        return $this->pdo->lastInsertId();
    }

    public function actualizar($id, $clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE pedidos
             SET cliente_id = ?, producto = ?, cantidad = ?, precio_unitario = ?, estado = ?, fecha_pedido = ?
             WHERE id = ?"
        );
        return $stmt->execute([$clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido, $id]);
    }

    public function eliminar($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM pedidos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
