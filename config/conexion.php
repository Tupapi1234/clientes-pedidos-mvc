<?php
$host = getenv('DB_HOST') ?: 'localhost';
$puerto = getenv('DB_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: 'clientes_pedidos';
$usuario = getenv('DB_USER') ?: 'root';
$clave = getenv('DB_PASS') ?: '1234';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$dbname;charset=utf8mb4",
        $usuario,
        $clave
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexion: " . $e->getMessage());
}
