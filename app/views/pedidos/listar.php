<?php $tituloPagina = 'Pedidos'; ?>
<?php require __DIR__ . '/../partials/cabecera.php'; ?>

<?php require __DIR__ . '/../partials/mensajes.php'; ?>

<div class="acciones">
    <a class="boton boton-primario" href="index.php?url=pedido/crearForm">+ Nuevo pedido</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio unitario</th>
            <th>Subtotal</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pedidos)): ?>
            <?php foreach ($pedidos as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['id']) ?></td>
                    <td><?= htmlspecialchars($p['cliente_nombre']) ?></td>
                    <td><?= htmlspecialchars($p['producto']) ?></td>
                    <td><?= htmlspecialchars($p['cantidad']) ?></td>
                    <td>$<?= htmlspecialchars(number_format((float) $p['precio_unitario'], 2)) ?></td>
                    <td>$<?= htmlspecialchars(number_format((float) $p['precio_unitario'] * (int) $p['cantidad'], 2)) ?></td>
                    <td><?= htmlspecialchars(ucfirst($p['estado'])) ?></td>
                    <td><?= htmlspecialchars($p['fecha_pedido']) ?></td>
                    <td class="columna-acciones">
                        <a href="index.php?url=pedido/editarForm&id=<?= (int) $p['id'] ?>">Editar</a>
                        <a href="index.php?url=pedido/eliminar&id=<?= (int) $p['id'] ?>"
                           onclick="return confirm('Eliminar este pedido?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="9" class="vacio">No hay pedidos registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../partials/pie.php'; ?>
