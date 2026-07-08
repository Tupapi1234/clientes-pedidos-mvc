<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../app/controllers/ClienteController.php';
require_once __DIR__ . '/../app/controllers/PedidoController.php';

$controladores = [
    'cliente' => ClienteController::class,
    'pedido' => PedidoController::class,
];

$controlador = $_GET['controlador'] ?? 'cliente';
$accion = $_GET['accion'] ?? 'listar';

$accionesPermitidas = ['listar', 'crear', 'guardar', 'editar', 'actualizar', 'eliminar'];

if (!isset($controladores[$controlador]) || !in_array($accion, $accionesPermitidas, true)) {
    http_response_code(404);
    die('Pagina no encontrada.');
}

$clase = $controladores[$controlador];
$instancia = new $clase($pdo);

$metodo = $accion === 'listar' ? 'index' : $accion;
$instancia->$metodo();
