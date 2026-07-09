function validarFormularioCliente() {
    var nombre = document.getElementById("nombre").value.trim();
    var correo = document.getElementById("correo").value.trim();
    var telefono = document.getElementById("telefono").value.trim();
    var direccion = document.getElementById("direccion").value.trim();

    if (nombre === "" || correo === "" || telefono === "" || direccion === "") {
        alert("Complete todos los campos");
        return false;
    }

    if (correo.indexOf("@") === -1) {
        alert("Ingrese un correo valido");
        return false;
    }

    return true;
}

function validarFormularioPedido() {
    var clienteId = document.getElementById("cliente_id").value;
    var producto = document.getElementById("producto").value.trim();
    var cantidad = document.getElementById("cantidad").value;
    var precioUnitario = document.getElementById("precio_unitario").value;
    var fechaPedido = document.getElementById("fecha_pedido").value;

    if (clienteId === "" || producto === "" || cantidad === "" || precioUnitario === "" || fechaPedido === "") {
        alert("Complete todos los campos");
        return false;
    }

    if (parseFloat(cantidad) < 1) {
        alert("La cantidad debe ser mayor a 0");
        return false;
    }

    if (parseFloat(precioUnitario) <= 0) {
        alert("El precio unitario debe ser mayor a 0");
        return false;
    }

    return true;
}
