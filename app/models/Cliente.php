<?php
require_once __DIR__ . "/../../config/conexion.php";

class Cliente
{
    public static function obtenerTodos()
    {
        $conn = Conexion::conectar();
        $sql = "SELECT * FROM clientes ORDER BY id DESC";
        $res = $conn->query($sql);

        $clientes = [];
        while ($fila = $res->fetch_assoc()) {
            $clientes[] = $fila;
        }
        return $clientes;
    }

    public static function obtenerPorId($id)
    {
        $conn = Conexion::conectar();
        $id = (int)$id;

        $sql = "SELECT * FROM clientes WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc(); // retorna null si no existe
    }

    public static function crear($nombre, $correo, $telefono, $direccion)
    {
        $conn = Conexion::conectar();

        $sql = "INSERT INTO clientes (nombre, correo, telefono, direccion) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $correo, $telefono, $direccion);
        return $stmt->execute();
    }

    public static function actualizar($id, $nombre, $correo, $telefono, $direccion)
    {
        $conn = Conexion::conectar();
        $id = (int)$id;

        $sql = "UPDATE clientes SET nombre=?, correo=?, telefono=?, direccion=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $correo, $telefono, $direccion, $id);
        return $stmt->execute();
    }

    public static function eliminar($id)
    {
        $conn = Conexion::conectar();
        $id = (int)$id;

        $sql = "DELETE FROM clientes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public static function correoExiste($correo)
    {
        $conn = Conexion::conectar();

        $sql = "SELECT id FROM clientes WHERE correo = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public static function tienePedidos($id)
    {
        $conn = Conexion::conectar();
        $id = (int)$id;

        $sql = "SELECT id FROM pedidos WHERE cliente_id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }
}
