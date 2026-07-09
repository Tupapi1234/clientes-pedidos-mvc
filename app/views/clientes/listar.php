<?php $tituloPagina = 'Clientes'; ?>
<?php require __DIR__ . '/../partials/cabecera.php'; ?>

<?php require __DIR__ . '/../partials/mensajes.php'; ?>

<div class="acciones">
    <a class="boton boton-primario" href="index.php?url=cliente/crearForm">+ Nuevo cliente</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($clientes)): ?>
            <?php foreach ($clientes as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['id']) ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td><?= htmlspecialchars($c['correo']) ?></td>
                    <td><?= htmlspecialchars($c['telefono']) ?></td>
                    <td><?= htmlspecialchars($c['direccion']) ?></td>
                    <td class="columna-acciones">
                        <a href="index.php?url=cliente/editarForm&id=<?= (int) $c['id'] ?>">Editar</a>
                        <a href="index.php?url=cliente/eliminar&id=<?= (int) $c['id'] ?>"
                           onclick="return confirm('Eliminar este cliente?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="vacio">No hay clientes registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../partials/pie.php'; ?>
