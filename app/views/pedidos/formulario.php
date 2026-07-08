<?php $tituloPagina = 'Nuevo pedido'; ?>
<?php require __DIR__ . '/../partials/cabecera.php'; ?>

<h2>Nuevo pedido</h2>

<?php if (empty($clientes)): ?>
    <div class="mensaje mensaje-advertencia">
        Debe registrar al menos un cliente antes de crear un pedido.
        <a href="index.php?controlador=cliente&accion=crear">Registrar cliente</a>
    </div>
<?php else: ?>
<form class="formulario" id="form-pedido" method="POST" action="index.php?controlador=pedido&accion=guardar" novalidate>
    <div class="campo">
        <label for="cliente_id">Cliente</label>
        <select id="cliente_id" name="cliente_id" required
                class="<?= isset($errores['cliente_id']) ? 'campo-invalido' : '' ?>">
            <option value="">-- Seleccione un cliente --</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= (int) $c['id'] ?>" <?= (string) $datos['cliente_id'] === (string) $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="error-campo" id="error-cliente_id"><?= htmlspecialchars($errores['cliente_id'] ?? '') ?></span>
    </div>

    <div class="campo">
        <label for="producto">Producto</label>
        <input type="text" id="producto" name="producto" value="<?= htmlspecialchars($datos['producto']) ?>"
               required maxlength="150"
               class="<?= isset($errores['producto']) ? 'campo-invalido' : '' ?>">
        <span class="error-campo" id="error-producto"><?= htmlspecialchars($errores['producto'] ?? '') ?></span>
    </div>

    <div class="campo">
        <label for="cantidad">Cantidad</label>
        <input type="number" id="cantidad" name="cantidad" value="<?= htmlspecialchars($datos['cantidad']) ?>"
               required min="1" step="1"
               class="<?= isset($errores['cantidad']) ? 'campo-invalido' : '' ?>">
        <span class="error-campo" id="error-cantidad"><?= htmlspecialchars($errores['cantidad'] ?? '') ?></span>
    </div>

    <div class="campo">
        <label for="precio_unitario">Precio unitario</label>
        <input type="number" id="precio_unitario" name="precio_unitario" value="<?= htmlspecialchars($datos['precio_unitario']) ?>"
               required min="0.01" step="0.01"
               class="<?= isset($errores['precio_unitario']) ? 'campo-invalido' : '' ?>">
        <span class="error-campo" id="error-precio_unitario"><?= htmlspecialchars($errores['precio_unitario'] ?? '') ?></span>
    </div>

    <div class="campo">
        <label for="estado">Estado</label>
        <select id="estado" name="estado" required
                class="<?= isset($errores['estado']) ? 'campo-invalido' : '' ?>">
            <?php foreach (['pendiente', 'completado', 'cancelado'] as $estado): ?>
                <option value="<?= $estado ?>" <?= $datos['estado'] === $estado ? 'selected' : '' ?>>
                    <?= ucfirst($estado) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <span class="error-campo" id="error-estado"><?= htmlspecialchars($errores['estado'] ?? '') ?></span>
    </div>

    <div class="campo">
        <label for="fecha_pedido">Fecha del pedido</label>
        <input type="date" id="fecha_pedido" name="fecha_pedido" value="<?= htmlspecialchars($datos['fecha_pedido']) ?>"
               required
               class="<?= isset($errores['fecha_pedido']) ? 'campo-invalido' : '' ?>">
        <span class="error-campo" id="error-fecha_pedido"><?= htmlspecialchars($errores['fecha_pedido'] ?? '') ?></span>
    </div>

    <button type="submit" class="boton boton-primario">Guardar</button>
    <a class="boton boton-secundario" href="index.php?controlador=pedido&accion=listar">Cancelar</a>
</form>
<?php endif; ?>

<?php require __DIR__ . '/../partials/pie.php'; ?>
