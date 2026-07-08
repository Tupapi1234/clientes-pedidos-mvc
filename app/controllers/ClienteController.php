<?php
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController
{
    private $modelo;

    public function __construct($pdo)
    {
        $this->modelo = new Cliente($pdo);
    }

    public function index()
    {
        $clientes = $this->modelo->obtenerTodos();
        $mensaje = $_GET['mensaje'] ?? '';
        require __DIR__ . '/../views/clientes/listado.php';
    }

    public function crear()
    {
        $errores = [];
        $datos = ['nombre' => '', 'correo' => '', 'telefono' => '', 'direccion' => ''];
        require __DIR__ . '/../views/clientes/formulario.php';
    }

    public function guardar()
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos);

        if (!empty($errores)) {
            require __DIR__ . '/../views/clientes/formulario.php';
            return;
        }

        $this->modelo->guardar($datos['nombre'], $datos['correo'], $datos['telefono'], $datos['direccion']);
        header('Location: index.php?controlador=cliente&accion=listar&mensaje=creado');
        exit;
    }

    public function editar()
    {
        $id = (int) ($_GET['id'] ?? 0);
        $cliente = $this->modelo->obtenerPorId($id);

        if (!$cliente) {
            $this->noEncontrado();
            return;
        }

        $errores = [];
        $datos = $cliente;
        require __DIR__ . '/../views/clientes/editar.php';
    }

    public function actualizar()
    {
        $id = (int) ($_POST['id'] ?? 0);
        $cliente = $this->modelo->obtenerPorId($id);

        if (!$cliente) {
            $this->noEncontrado();
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validar($datos, $id);

        if (!empty($errores)) {
            $datos['id'] = $id;
            require __DIR__ . '/../views/clientes/editar.php';
            return;
        }

        $this->modelo->actualizar($id, $datos['nombre'], $datos['correo'], $datos['telefono'], $datos['direccion']);
        header('Location: index.php?controlador=cliente&accion=listar&mensaje=actualizado');
        exit;
    }

    public function eliminar()
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            if ($this->modelo->tienePedidos($id)) {
                header('Location: index.php?controlador=cliente&accion=listar&mensaje=tiene_pedidos');
                exit;
            }
            $this->modelo->eliminar($id);
        }

        header('Location: index.php?controlador=cliente&accion=listar&mensaje=eliminado');
        exit;
    }

    private function obtenerDatosFormulario()
    {
        return [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'correo' => trim($_POST['correo'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'direccion' => trim($_POST['direccion'] ?? ''),
        ];
    }

    private function validar($datos, $idExcluido = null)
    {
        $errores = [];

        if ($datos['nombre'] === '') {
            $errores['nombre'] = 'El nombre es obligatorio.';
        } elseif (!preg_match('/^[\p{L}\s]{2,100}$/u', $datos['nombre'])) {
            $errores['nombre'] = 'El nombre solo debe contener letras y espacios (2 a 100 caracteres).';
        }

        if ($datos['correo'] === '') {
            $errores['correo'] = 'El correo es obligatorio.';
        } elseif (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores['correo'] = 'El correo no tiene un formato valido.';
        } elseif ($this->modelo->existeCorreo($datos['correo'], $idExcluido)) {
            $errores['correo'] = 'Ya existe un cliente registrado con este correo.';
        }

        if ($datos['telefono'] === '') {
            $errores['telefono'] = 'El telefono es obligatorio.';
        } elseif (!preg_match('/^[0-9+\-\s]{7,20}$/', $datos['telefono'])) {
            $errores['telefono'] = 'El telefono debe tener entre 7 y 20 digitos.';
        }

        if ($datos['direccion'] === '') {
            $errores['direccion'] = 'La direccion es obligatoria.';
        } elseif (strlen($datos['direccion']) > 200) {
            $errores['direccion'] = 'La direccion no debe superar los 200 caracteres.';
        }

        return $errores;
    }

    private function noEncontrado()
    {
        http_response_code(404);
        echo 'Cliente no encontrado.';
    }
}
