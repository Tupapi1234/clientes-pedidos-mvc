<?php
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Cliente.php';

class PedidoController
{
    private $modelo;
    private $modeloCliente;

    private $estadosValidos = ['pendiente', 'completado', 'cancelado'];

    public function __construct($pdo)
    {
        $this->modelo = new Pedido($pdo);
        $this->modeloCliente = new Cliente($pdo);
    }

    public function index()
    {
        $pedidos = $this->modelo->obtenerTodos();
        $mensaje = $_GET['mensaje'] ?? '';
        require __DIR__ . '/../views/pedidos/listado.php';
    }

    public function crear()
    {
        $errores = [];
        $datos = [
            'cliente_id' => '', 'producto' => '', 'cantidad' => '',
            'precio_unitario' => '', 'estado' => 'pendiente', 'fecha_pedido' => date('Y-m-d'),
        ];
        $clientes = $this->modeloCliente->obtenerTodos();
        require __DIR__ . '/../views/pedidos/formulario.php';
    }

    public function guardar()
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $clientes = $this->modeloCliente->obtenerTodos();
            require __DIR__ . '/../views/pedidos/formulario.php';
            return;
        }

        $this->modelo->guardar(
            $datos['cliente_id'],
            $datos['producto'],
            $datos['cantidad'],
            $datos['precio_unitario'],
            $datos['estado'],
            $datos['fecha_pedido']
        );
        header('Location: index.php?controlador=pedido&accion=listar&mensaje=creado');
        exit;
    }

    public function editar()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $pedido = $this->modelo->obtenerPorId($id);

        if (!$pedido) {
            $this->noEncontrado();
            return;
        }

        $errores = [];
        $datos = $pedido;
        $clientes = $this->modeloCliente->obtenerTodos();
        require __DIR__ . '/../views/pedidos/editar.php';
    }

    public function actualizar()
    {
        $id = (int) ($_POST['id'] ?? 0);
        $pedido = $this->modelo->obtenerPorId($id);

        if (!$pedido) {
            $this->noEncontrado();
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            $datos['id'] = $id;
            $clientes = $this->modeloCliente->obtenerTodos();
            require __DIR__ . '/../views/pedidos/editar.php';
            return;
        }

        $this->modelo->actualizar(
            $id,
            $datos['cliente_id'],
            $datos['producto'],
            $datos['cantidad'],
            $datos['precio_unitario'],
            $datos['estado'],
            $datos['fecha_pedido']
        );
        header('Location: index.php?controlador=pedido&accion=listar&mensaje=actualizado');
        exit;
    }

    public function eliminar()
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->modelo->eliminar($id);
        }

        header('Location: index.php?controlador=pedido&accion=listar&mensaje=eliminado');
        exit;
    }

    private function obtenerDatosFormulario()
    {
        return [
            'cliente_id' => (int) ($_POST['cliente_id'] ?? 0),
            'producto' => trim($_POST['producto'] ?? ''),
            'cantidad' => trim($_POST['cantidad'] ?? ''),
            'precio_unitario' => trim($_POST['precio_unitario'] ?? ''),
            'estado' => trim($_POST['estado'] ?? ''),
            'fecha_pedido' => trim($_POST['fecha_pedido'] ?? ''),
        ];
    }

    private function validar($datos)
    {
        $errores = [];

        if ($datos['cliente_id'] <= 0 || !$this->modeloCliente->obtenerPorId($datos['cliente_id'])) {
            $errores['cliente_id'] = 'Debe seleccionar un cliente valido.';
        }

        if ($datos['producto'] === '') {
            $errores['producto'] = 'El producto es obligatorio.';
        } elseif (strlen($datos['producto']) > 150) {
            $errores['producto'] = 'El producto no debe superar los 150 caracteres.';
        }

        if ($datos['cantidad'] === '' || !ctype_digit((string) $datos['cantidad']) || (int) $datos['cantidad'] < 1) {
            $errores['cantidad'] = 'La cantidad debe ser un numero entero mayor a 0.';
        }

        if ($datos['precio_unitario'] === '' || !is_numeric($datos['precio_unitario']) || (float) $datos['precio_unitario'] <= 0) {
            $errores['precio_unitario'] = 'El precio unitario debe ser un numero mayor a 0.';
        }

        if (!in_array($datos['estado'], $this->estadosValidos, true)) {
            $errores['estado'] = 'El estado seleccionado no es valido.';
        }

        if ($datos['fecha_pedido'] === '') {
            $errores['fecha_pedido'] = 'La fecha del pedido es obligatoria.';
        } else {
            $fecha = DateTime::createFromFormat('Y-m-d', $datos['fecha_pedido']);
            if (!$fecha || $fecha->format('Y-m-d') !== $datos['fecha_pedido']) {
                $errores['fecha_pedido'] = 'La fecha del pedido no es valida.';
            }
        }

        return $errores;
    }

    private function noEncontrado()
    {
        http_response_code(404);
        echo 'Pedido no encontrado.';
    }
}
