<?php $tituloPagina = 'Nuevo cliente'; ?>
<?php require __DIR__ . '/../partials/cabecera.php'; ?>

<h2>Nuevo cliente</h2>

<?php require __DIR__ . '/../partials/mensajes.php'; ?>

<form class="formulario" id="form-cliente" method="POST" action="index.php?url=cliente/crear"
      onsubmit="return validarFormularioCliente()">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>

    <div class="campo">
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" required>
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="text" id="telefono" name="telefono" required>
    </div>

    <div class="campo">
        <label for="direccion">Direccion</label>
        <textarea id="direccion" name="direccion" required></textarea>
    </div>

    <button type="submit" class="boton boton-primario">Guardar</button>
    <a class="boton boton-secundario" href="index.php?url=cliente/listar">Cancelar</a>
</form>

<?php require __DIR__ . '/../partials/pie.php'; ?>
