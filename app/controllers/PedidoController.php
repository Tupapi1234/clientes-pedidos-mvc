<?php
require_once __DIR__ . "/../models/Pedido.php";
require_once __DIR__ . "/../models/Cliente.php";

class PedidoController
{
    public function listar()
    {
        $pedidos = Pedido::obtenerTodos();
        $msg = $_GET["msg"] ?? "";
        require __DIR__ . "/../views/pedidos/listar.php";
    }

    public function crearForm()
    {
        $clientes = Cliente::obtenerTodos();
        $msg = "";
        require __DIR__ . "/../views/pedidos/crear.php";
    }

    public function crear()
    {
        $clienteId = $_POST["cliente_id"] ?? "";
        $producto = $_POST["producto"] ?? "";
        $cantidad = $_POST["cantidad"] ?? "";
        $precioUnitario = $_POST["precio_unitario"] ?? "";
        $estado = $_POST["estado"] ?? "";
        $fechaPedido = $_POST["fecha_pedido"] ?? "";

        if ($clienteId === "" || $producto === "" || $cantidad === "" || $precioUnitario === "" || $estado === "" || $fechaPedido === "") {
            $clientes = Cliente::obtenerTodos();
            $msg = "Complete todos los campos";
            require __DIR__ . "/../views/pedidos/crear.php";
            return;
        }

        if (!is_numeric($cantidad) || $cantidad < 1) {
            $clientes = Cliente::obtenerTodos();
            $msg = "La cantidad debe ser un numero mayor a 0";
            require __DIR__ . "/../views/pedidos/crear.php";
            return;
        }

        if (!is_numeric($precioUnitario) || $precioUnitario <= 0) {
            $clientes = Cliente::obtenerTodos();
            $msg = "El precio unitario debe ser mayor a 0";
            require __DIR__ . "/../views/pedidos/crear.php";
            return;
        }

        Pedido::crear($clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido);
        header("Location: index.php?url=pedido/listar&msg=" . urlencode("Pedido creado"));
        exit;
    }

    public function editarForm()
    {
        $id = $_GET["id"] ?? 0;
        $pedido = Pedido::obtenerPorId($id);
        $clientes = Cliente::obtenerTodos();
        $msg = "";
        require __DIR__ . "/../views/pedidos/editar.php";
    }

    public function actualizar()
    {
        $id = $_POST["id"] ?? 0;
        $clienteId = $_POST["cliente_id"] ?? "";
        $producto = $_POST["producto"] ?? "";
        $cantidad = $_POST["cantidad"] ?? "";
        $precioUnitario = $_POST["precio_unitario"] ?? "";
        $estado = $_POST["estado"] ?? "";
        $fechaPedido = $_POST["fecha_pedido"] ?? "";

        if ($clienteId === "" || $producto === "" || $cantidad === "" || $precioUnitario === "" || $estado === "" || $fechaPedido === "") {
            $pedido = Pedido::obtenerPorId($id);
            $clientes = Cliente::obtenerTodos();
            $msg = "Complete todos los campos";
            require __DIR__ . "/../views/pedidos/editar.php";
            return;
        }

        if (!is_numeric($cantidad) || $cantidad < 1 || !is_numeric($precioUnitario) || $precioUnitario <= 0) {
            $pedido = Pedido::obtenerPorId($id);
            $clientes = Cliente::obtenerTodos();
            $msg = "Cantidad y precio deben ser numeros validos";
            require __DIR__ . "/../views/pedidos/editar.php";
            return;
        }

        Pedido::actualizar($id, $clienteId, $producto, $cantidad, $precioUnitario, $estado, $fechaPedido);
        header("Location: index.php?url=pedido/listar&msg=" . urlencode("Pedido actualizado"));
        exit;
    }

    public function eliminar()
    {
        $id = $_GET["id"] ?? 0;
        Pedido::eliminar($id);
        header("Location: index.php?url=pedido/listar&msg=" . urlencode("Pedido eliminado"));
        exit;
    }
}
