# Gestion de Clientes y Pedidos (MVC en PHP)

Aplicacion web para administrar **clientes** y sus **pedidos** (proceso comercial), desarrollada en PHP puro con arquitectura MVC y base de datos MySQL. Permite un CRUD completo sobre ambas entidades, con validaciones en frontend (HTML5 + JavaScript) y backend (PHP).

## Tecnologias

- PHP 8+ (sin frameworks), PDO para el acceso a datos
- MySQL
- HTML5, CSS3, JavaScript (validaciones del lado del cliente)

## Estructura del proyecto

```
/public
    index.php          -> Front Controller (enrutador)
/css
    estilo.css
/js
    validacion.js       -> Validaciones de formularios en el cliente
/app
    /controllers        -> ClienteController.php, PedidoController.php
    /models              -> Cliente.php, Pedido.php (acceso a datos con PDO)
    /views                -> Vistas HTML por entidad (clientes/, pedidos/, partials/)
/config
    conexion.php         -> Conexion PDO a MySQL
/database
    database.sql          -> Script de creacion de la base de datos
```

## Entidades y relacion

- **Cliente**: id, nombre, correo, telefono, direccion.
- **Pedido**: id, cliente_id (FK -> clientes.id), producto, cantidad, precio_unitario, estado, fecha_pedido.

Un cliente puede tener muchos pedidos (relacion 1:N). No se permite eliminar un cliente que tenga pedidos asociados.

## Requisitos

- PHP >= 8.0 con extensiones `pdo` y `pdo_mysql`
- MySQL >= 5.7 (o MariaDB equivalente)

## Instalacion y ejecucion local

1. Clonar el repositorio:
   ```
   git clone <url-del-repositorio>
   cd clientes-pedidos-mvc
   ```

2. Crear la base de datos ejecutando el script SQL:
   ```
   mysql -u root -p < database/database.sql
   ```
   Esto crea la base `clientes_pedidos` con las tablas `clientes` y `pedidos`, junto con datos de ejemplo.

3. Configurar la conexion (opcional). Por defecto `config/conexion.php` usa:
   - host: `localhost`
   - puerto: `3306`
   - base de datos: `clientes_pedidos`
   - usuario: `root`
   - clave: `` (vacia)

   Estos valores se pueden sobrescribir con variables de entorno: `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`.

4. Levantar un servidor con el servidor embebido de PHP desde la carpeta `public`:
   ```
   cd public
   php -S localhost:8000
   ```
   Y abrir `http://localhost:8000` en el navegador.

   Alternativamente, se puede usar XAMPP/WAMP/Laragon apuntando el DocumentRoot a la carpeta `public/`.

## Despliegue en Render

Esta aplicacion incluye un `Dockerfile` (PHP 8.2 + Apache) listo para desplegarse como **Web Service** en Render:

1. Subir el repositorio a GitHub.
2. En Render, crear un nuevo **Web Service**, seleccionar "Build from Dockerfile" y apuntar al repositorio.
3. Render no ofrece MySQL administrado; se recomienda usar un proveedor externo de MySQL (por ejemplo Railway, Clever Cloud o Aiven) y crear la base de datos ahi ejecutando `database/database.sql`.
4. En la seccion de variables de entorno del servicio en Render, configurar:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_NAME`
   - `DB_USER`
   - `DB_PASS`
5. Desplegar. La aplicacion quedara accesible desde la URL publica que asigna Render.

## Validaciones

- **Frontend**: atributos HTML5 (`required`, `pattern`, `min`, `maxlength`, etc.) y validaciones en `js/validacion.js` que impiden el envio del formulario si hay datos invalidos.
- **Backend**: cada controlador valida nuevamente todos los campos (formato de correo, telefono, longitudes, numeros positivos, fechas validas, existencia del cliente seleccionado, correo duplicado) antes de tocar la base de datos. Ningun campo vacio o invalido llega a guardarse.
