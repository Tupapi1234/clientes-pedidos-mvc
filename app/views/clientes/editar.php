<?php $tituloPagina = 'Editar cliente'; ?>
<?php require __DIR__ . '/../partials/cabecera.php'; ?>

<h2>Editar cliente</h2>

<?php require __DIR__ . '/../partials/mensajes.php'; ?>

<form class="formulario" id="form-cliente" method="POST" action="index.php?url=cliente/actualizar"
      onsubmit="return validarFormularioCliente()">
    <input type="hidden" name="id" value="<?= (int) $cliente['id'] ?>">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
    </div>

    <div class="campo">
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($cliente['correo']) ?>" required>
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>" required>
    </div>

    <div class="campo">
        <label for="direccion">Direccion</label>
        <textarea id="direccion" name="direccion" required><?= htmlspecialchars($cliente['direccion']) ?></textarea>
    </div>

    <button type="submit" class="boton boton-primario">Actualizar</button>
    <a class="boton boton-secundario" href="index.php?url=cliente/listar">Cancelar</a>
</form>

<?php require __DIR__ . '/../partials/pie.php'; ?>
