<?php
class Cliente
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM clientes ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cliente ?: null;
    }

    public function guardar($nombre, $correo, $telefono, $direccion)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO clientes (nombre, correo, telefono, direccion) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$nombre, $correo, $telefono, $direccion]);
        return $this->pdo->lastInsertId();
    }

    public function actualizar($id, $nombre, $correo, $telefono, $direccion)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE clientes SET nombre = ?, correo = ?, telefono = ?, direccion = ? WHERE id = ?"
        );
        return $stmt->execute([$nombre, $correo, $telefono, $direccion, $id]);
    }

    public function eliminar($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function existeCorreo($correo, $idExcluido = null)
    {
        if ($idExcluido) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM clientes WHERE correo = ? AND id != ?");
            $stmt->execute([$correo, $idExcluido]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM clientes WHERE correo = ?");
            $stmt->execute([$correo]);
        }
        return $stmt->fetchColumn() > 0;
    }

    public function tienePedidos($id)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pedidos WHERE cliente_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }
}
