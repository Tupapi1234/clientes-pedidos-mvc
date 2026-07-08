<?php
$mensajesTexto = [
    'creado' => ['Registro creado correctamente.', 'mensaje-exito'],
    'actualizado' => ['Registro actualizado correctamente.', 'mensaje-exito'],
    'eliminado' => ['Registro eliminado correctamente.', 'mensaje-exito'],
    'tiene_pedidos' => ['No se puede eliminar el cliente porque tiene pedidos asociados.', 'mensaje-error'],
];
?>
<?php if (!empty($mensaje) && isset($mensajesTexto[$mensaje])): ?>
    <div class="mensaje <?= $mensajesTexto[$mensaje][1] ?>">
        <?= htmlspecialchars($mensajesTexto[$mensaje][0]) ?>
    </div>
<?php endif; ?>
