<?php
require_once __DIR__ . "/../app/controllers/ClienteController.php";
require_once __DIR__ . "/../app/controllers/PedidoController.php";

$url = $_GET["url"] ?? "cliente/listar";

$cliente = new ClienteController();
$pedido = new PedidoController();

switch ($url) {
    case "cliente/listar":
        $cliente->listar();
        break;
    case "cliente/crearForm":
        $cliente->crearForm();
        break;
    case "cliente/crear":
        $cliente->crear();
        break;
    case "cliente/editarForm":
        $cliente->editarForm();
        break;
    case "cliente/actualizar":
        $cliente->actualizar();
        break;
    case "cliente/eliminar":
        $cliente->eliminar();
        break;

    case "pedido/listar":
        $pedido->listar();
        break;
    case "pedido/crearForm":
        $pedido->crearForm();
        break;
    case "pedido/crear":
        $pedido->crear();
        break;
    case "pedido/editarForm":
        $pedido->editarForm();
        break;
    case "pedido/actualizar":
        $pedido->actualizar();
        break;
    case "pedido/eliminar":
        $pedido->eliminar();
        break;

    default:
        http_response_code(404);
        echo "404 - Ruta no encontrada";
}
