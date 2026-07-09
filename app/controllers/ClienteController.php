<?php
require_once __DIR__ . "/../models/Cliente.php";

class ClienteController
{
    public function listar()
    {
        $clientes = Cliente::obtenerTodos();
        $msg = $_GET["msg"] ?? "";
        require __DIR__ . "/../views/clientes/listar.php";
    }

    public function crearForm()
    {
        $msg = "";
        require __DIR__ . "/../views/clientes/crear.php";
    }

    public function crear()
    {
        $nombre = $_POST["nombre"] ?? "";
        $correo = $_POST["correo"] ?? "";
        $telefono = $_POST["telefono"] ?? "";
        $direccion = $_POST["direccion"] ?? "";

        if ($nombre === "" || $correo === "" || $telefono === "" || $direccion === "") {
            $msg = "Complete todos los campos";
            require __DIR__ . "/../views/clientes/crear.php";
            return;
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $msg = "El correo no es valido";
            require __DIR__ . "/../views/clientes/crear.php";
            return;
        }

        if (Cliente::correoExiste($correo)) {
            $msg = "Ya existe un cliente con ese correo";
            require __DIR__ . "/../views/clientes/crear.php";
            return;
        }

        Cliente::crear($nombre, $correo, $telefono, $direccion);
        header("Location: index.php?url=cliente/listar&msg=" . urlencode("Cliente creado"));
        exit;
    }

    public function editarForm()
    {
        $id = $_GET["id"] ?? 0;
        $cliente = Cliente::obtenerPorId($id);
        $msg = "";
        require __DIR__ . "/../views/clientes/editar.php";
    }

    public function actualizar()
    {
        $id = $_POST["id"] ?? 0;
        $nombre = $_POST["nombre"] ?? "";
        $correo = $_POST["correo"] ?? "";
        $telefono = $_POST["telefono"] ?? "";
        $direccion = $_POST["direccion"] ?? "";

        if ($nombre === "" || $correo === "" || $telefono === "" || $direccion === "") {
            $cliente = Cliente::obtenerPorId($id);
            $msg = "Complete todos los campos";
            require __DIR__ . "/../views/clientes/editar.php";
            return;
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $cliente = Cliente::obtenerPorId($id);
            $msg = "El correo no es valido";
            require __DIR__ . "/../views/clientes/editar.php";
            return;
        }

        Cliente::actualizar($id, $nombre, $correo, $telefono, $direccion);
        header("Location: index.php?url=cliente/listar&msg=" . urlencode("Cliente actualizado"));
        exit;
    }

    public function eliminar()
    {
        $id = $_GET["id"] ?? 0;

        if (Cliente::tienePedidos($id)) {
            header("Location: index.php?url=cliente/listar&msg=" . urlencode("No se puede eliminar, el cliente tiene pedidos"));
            exit;
        }

        Cliente::eliminar($id);
        header("Location: index.php?url=cliente/listar&msg=" . urlencode("Cliente eliminado"));
        exit;
    }
}
