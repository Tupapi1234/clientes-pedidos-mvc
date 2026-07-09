<?php
class Conexion
{
    public static function conectar()
    {
        $host = getenv('DB_HOST') ?: 'localhost';
        $bd = getenv('DB_NAME') ?: 'clientes_pedidos';
        $usuario = getenv('DB_USER') ?: 'root';
        $clave = getenv('DB_PASS') ?: '1234';
        $puerto = getenv('DB_PORT') ?: '3306';

        $conn = new mysqli($host, $usuario, $clave, $bd, $puerto);

        if ($conn->connect_error) {
            die("Error de conexion: " . $conn->connect_error);
        }
        return $conn;
    }
}
