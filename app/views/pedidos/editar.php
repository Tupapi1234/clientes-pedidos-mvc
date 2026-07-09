<?php $tituloPagina = 'Editar pedido'; ?>
<?php require __DIR__ . '/../partials/cabecera.php'; ?>

<h2>Editar pedido</h2>

<?php require __DIR__ . '/../partials/mensajes.php'; ?>

<form class="formulario" id="form-pedido" method="POST" action="index.php?url=pedido/actualizar"
      onsubmit="return validarFormularioPedido()">
    <input type="hidden" name="id" value="<?= (int) $pedido['id'] ?>">

    <div class="campo">
        <label for="cliente_id">Cliente</label>
        <select id="cliente_id" name="cliente_id" required>
            <option value="">-- Seleccione un cliente --</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= (int) $c['id'] ?>" <?= (string) $pedido['cliente_id'] === (string) $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="campo">
        <label for="producto">Producto</label>
        <input type="text" id="producto" name="producto" value="<?= htmlspecialchars($pedido['producto']) ?>" required>
    </div>

    <div class="campo">
        <label for="cantidad">Cantidad</label>
        <input type="number" id="cantidad" name="cantidad" value="<?= htmlspecialchars($pedido['cantidad']) ?>" min="1" step="1" required>
    </div>

    <div class="campo">
        <label for="precio_unitario">Precio unitario</label>
        <input type="number" id="precio_unitario" name="precio_unitario" value="<?= htmlspecialchars($pedido['precio_unitario']) ?>" min="0.01" step="0.01" required>
    </div>

    <div class="campo">
        <label for="estado">Estado</label>
        <select id="estado" name="estado" required>
            <?php foreach (['pendiente', 'completado', 'cancelado'] as $estado): ?>
                <option value="<?= $estado ?>" <?= $pedido['estado'] === $estado ? 'selected' : '' ?>>
                    <?= ucfirst($estado) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="campo">
        <label for="fecha_pedido">Fecha del pedido</label>
        <input type="date" id="fecha_pedido" name="fecha_pedido" value="<?= htmlspecialchars($pedido['fecha_pedido']) ?>" required>
    </div>

    <button type="submit" class="boton boton-primario">Actualizar</button>
    <a class="boton boton-secundario" href="index.php?url=pedido/listar">Cancelar</a>
</form>

<?php require __DIR__ . '/../partials/pie.php'; ?>
