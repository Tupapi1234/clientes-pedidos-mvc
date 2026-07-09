<?php
require_once __DIR__ . "/../../config/conexion.php";

class Pedido
{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT p.*, c.nombre AS cliente_nombre
                FROM pedidos p
                INNER JOIN clientes c ON p.cliente_id = c.id
                ORDER BY p.id DESC";
        $res = $conn->query($sql);

        $pedidos = [];
        while ($fila = $res->fetch_assoc()) {
            $pedidos[] = $fila;
        }
        return $pedidos;
    }

    public static function obtenerPorId($id)
    {
        $conn = Conexion::conectar();
        $id = (int)$id;

        $sql = "SELECT * FROM pedidos WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc(); // retorna null si no existe
    }

    public static function crear($clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido)
    {
        $conn = Conexion::conectar();
        $clienteId = (int)$clienteId;

        $sql = "INSERT INTO pedidos (cliente_id, producto, cantidad, precio_unitario, estado, fecha_pedido)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isidss", $clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido);
        return $stmt->execute();
    }

    public static function actualizar($id, $clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido)
    {
        $conn = Conexion::conectar();
        $id = (int)$id;
        $clienteId = (int)$clienteId;

        $sql = "UPDATE pedidos
                SET cliente_id=?, producto=?, cantidad=?, precio_unitario=?, estado=?, fecha_pedido=?
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isidssi", $clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido, $id);
        return $stmt->execute();
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $id = (int)$id;

        $sql = "DELETE FROM pedidos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
