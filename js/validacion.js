document.addEventListener('DOMContentLoaded', function () {
    var formCliente = document.getElementById('form-cliente');
    if (formCliente) {
        formCliente.addEventListener('submit', validarFormularioCliente);
    }

    var formPedido = document.getElementById('form-pedido');
    if (formPedido) {
        formPedido.addEventListener('submit', validarFormularioPedido);
    }
});

function mostrarError(idCampo, mensaje) {
    var campo = document.getElementById(idCampo);
    var contenedorError = document.getElementById('error-' + idCampo);

    if (campo) {
        campo.classList.add('campo-invalido');
    }
    if (contenedorError) {
        contenedorError.textContent = mensaje;
    }
}

function limpiarError(idCampo) {
    var campo = document.getElementById(idCampo);
    var contenedorError = document.getElementById('error-' + idCampo);

    if (campo) {
        campo.classList.remove('campo-invalido');
    }
    if (contenedorError) {
        contenedorError.textContent = '';
    }
}

function limpiarErrores(idsCampos) {
    idsCampos.forEach(limpiarError);
}

function validarFormularioCliente(evento) {
    var idsCampos = ['nombre', 'correo', 'telefono', 'direccion'];
    limpiarErrores(idsCampos);

    var nombre = document.getElementById('nombre').value.trim();
    var correo = document.getElementById('correo').value.trim();
    var telefono = document.getElementById('telefono').value.trim();
    var direccion = document.getElementById('direccion').value.trim();

    var esValido = true;

    if (nombre === '' || !/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,100}$/.test(nombre)) {
        mostrarError('nombre', 'Ingrese un nombre valido (solo letras, 2 a 100 caracteres).');
        esValido = false;
    }

    if (correo === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
        mostrarError('correo', 'Ingrese un correo electronico valido.');
        esValido = false;
    }

    if (telefono === '' || !/^[0-9+\-\s]{7,20}$/.test(telefono)) {
        mostrarError('telefono', 'Ingrese un telefono valido (7 a 20 digitos).');
        esValido = false;
    }

    if (direccion === '' || direccion.length > 200) {
        mostrarError('direccion', 'Ingrese una direccion valida (maximo 200 caracteres).');
        esValido = false;
    }

    if (!esValido) {
        evento.preventDefault();
    }
}

function validarFormularioPedido(evento) {
    var idsCampos = ['cliente_id', 'producto', 'cantidad', 'precio_unitario', 'estado', 'fecha_pedido'];
    limpiarErrores(idsCampos);

    var clienteId = document.getElementById('cliente_id').value;
    var producto = document.getElementById('producto').value.trim();
    var cantidad = document.getElementById('cantidad').value;
    var precioUnitario = document.getElementById('precio_unitario').value;
    var estado = document.getElementById('estado').value;
    var fechaPedido = document.getElementById('fecha_pedido').value;

    var esValido = true;

    if (!clienteId) {
        mostrarError('cliente_id', 'Debe seleccionar un cliente.');
        esValido = false;
    }

    if (producto === '' || producto.length > 150) {
        mostrarError('producto', 'Ingrese un producto valido (maximo 150 caracteres).');
        esValido = false;
    }

    if (cantidad === '' || !/^[0-9]+$/.test(cantidad) || parseInt(cantidad, 10) < 1) {
        mostrarError('cantidad', 'La cantidad debe ser un numero entero mayor a 0.');
        esValido = false;
    }

    if (precioUnitario === '' || isNaN(precioUnitario) || parseFloat(precioUnitario) <= 0) {
        mostrarError('precio_unitario', 'El precio unitario debe ser mayor a 0.');
        esValido = false;
    }

    if (estado === '') {
        mostrarError('estado', 'Debe seleccionar un estado.');
        esValido = false;
    }

    if (fechaPedido === '') {
        mostrarError('fecha_pedido', 'Debe seleccionar una fecha.');
        esValido = false;
    }

    if (!esValido) {
        evento.preventDefault();
    }
}
