<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($tituloPagina) ? htmlspecialchars($tituloPagina) : 'Gestion de Clientes y Pedidos' ?></title>
    <link rel="stylesheet" href="/css/estilo.css">
</head>
<body>
    <h1>Gestion de Clientes y Pedidos</h1>
    <p class="subtitulo">Modulo CRUD desarrollado en PHP con arquitectura MVC</p>

    <nav class="menu-principal">
        <a href="index.php?controlador=cliente&accion=listar">Clientes</a>
        <a href="index.php?controlador=pedido&accion=listar">Pedidos</a>
    </nav>
