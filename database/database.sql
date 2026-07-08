-- Script de creacion de base de datos
-- Proyecto: Gestion de Clientes y Pedidos (MVC en PHP)

CREATE DATABASE IF NOT EXISTS clientes_pedidos
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE clientes_pedidos;

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    direccion VARCHAR(200) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    producto VARCHAR(150) NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'completado', 'cancelado') NOT NULL DEFAULT 'pendiente',
    fecha_pedido DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pedidos_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Datos de ejemplo
INSERT INTO clientes (nombre, correo, telefono, direccion) VALUES
('Juan Perez', 'juan.perez@example.com', '0991234567', 'Av. 9 de Octubre, Guayaquil'),
('Maria Gomez', 'maria.gomez@example.com', '0987654321', 'Cdla. Kennedy, Guayaquil');

INSERT INTO pedidos (cliente_id, producto, cantidad, precio_unitario, estado, fecha_pedido) VALUES
(1, 'Laptop Dell Inspiron', 1, 650.00, 'pendiente', '2026-07-01'),
(2, 'Mouse inalambrico', 3, 12.50, 'completado', '2026-07-03');
