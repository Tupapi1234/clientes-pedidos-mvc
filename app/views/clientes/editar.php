<?php $tituloPagina = 'Editar cliente'; ?>
<?php require __DIR__ . '/../partials/cabecera.php'; ?>

<h2>Editar cliente</h2>

<form class="formulario" id="form-cliente" method="POST" action="index.php?controlador=cliente&accion=actualizar" novalidate>
    <input type="hidden" name="id" value="<?= (int) $datos['id'] ?>">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>"
               required minlength="2" maxlength="100" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
               class="<?= isset($errores['nombre']) ? 'campo-invalido' : '' ?>">
        <span class="error-campo" id="error-nombre"><?= htmlspecialchars($errores['nombre'] ?? '') ?></span>
    </div>

    <div class="campo">
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($datos['correo']) ?>"
               required maxlength="150"
               class="<?= isset($errores['correo']) ? 'campo-invalido' : '' ?>">
        <span class="error-campo" id="error-correo"><?= htmlspecialchars($errores['correo'] ?? '') ?></span>
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($datos['telefono']) ?>"
               required minlength="7" maxlength="20" pattern="[0-9+\-\s]+"
               class="<?= isset($errores['telefono']) ? 'campo-invalido' : '' ?>">
        <span class="error-campo" id="error-telefono"><?= htmlspecialchars($errores['telefono'] ?? '') ?></span>
    </div>

    <div class="campo">
        <label for="direccion">Direccion</label>
        <textarea id="direccion" name="direccion" required maxlength="200"
                  class="<?= isset($errores['direccion']) ? 'campo-invalido' : '' ?>"><?= htmlspecialchars($datos['direccion']) ?></textarea>
        <span class="error-campo" id="error-direccion"><?= htmlspecialchars($errores['direccion'] ?? '') ?></span>
    </div>

    <button type="submit" class="boton boton-primario">Actualizar</button>
    <a class="boton boton-secundario" href="index.php?controlador=cliente&accion=listar">Cancelar</a>
</form>

<?php require __DIR__ . '/../partials/pie.php'; ?>
