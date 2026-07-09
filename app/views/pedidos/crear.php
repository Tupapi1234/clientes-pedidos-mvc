<?php $tituloPagina = 'Nuevo pedido'; ?>
<?php require __DIR__ . '/../partials/cabecera.php'; ?>

<h2>Nuevo pedido</h2>

<?php require __DIR__ . '/../partials/mensajes.php'; ?>

<?php if (empty($clientes)): ?>
    <p class="mensaje">Debe registrar al menos un cliente antes de crear un pedido.
        <a href="index.php?url=cliente/crearForm">Registrar cliente</a>
    </p>
<?php else: ?>
<form class="formulario" id="form-pedido" method="POST" action="index.php?url=pedido/crear"
      onsubmit="return validarFormularioPedido()">
    <div class="campo">
        <label for="cliente_id">Cliente</label>
        <select id="cliente_id" name="cliente_id" required>
            <option value="">-- Seleccione un cliente --</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= (int) $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="campo">
        <label for="producto">Producto</label>
        <input type="text" id="producto" name="producto" required>
    </div>

    <div class="campo">
        <label for="cantidad">Cantidad</label>
        <input type="number" id="cantidad" name="cantidad" min="1" step="1" required>
    </div>

    <div class="campo">
        <label for="precio_unitario">Precio unitario</label>
        <input type="number" id="precio_unitario" name="precio_unitario" min="0.01" step="0.01" required>
    </div>

    <div class="campo">
        <label for="estado">Estado</label>
        <select id="estado" name="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="completado">Completado</option>
            <option value="cancelado">Cancelado</option>
        </select>
    </div>

    <div class="campo">
        <label for="fecha_pedido">Fecha del pedido</label>
        <input type="date" id="fecha_pedido" name="fecha_pedido" required>
    </div>

    <button type="submit" class="boton boton-primario">Guardar</button>
    <a class="boton boton-secundario" href="index.php?url=pedido/listar">Cancelar</a>
</form>
<?php endif; ?>

<?php require __DIR__ . '/../partials/pie.php'; ?>
