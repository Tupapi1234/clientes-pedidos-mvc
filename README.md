# Gestion de Clientes y Pedidos (MVC en PHP)

Aplicacion web para administrar **clientes** y sus **pedidos** (proceso comercial), desarrollada en PHP puro con arquitectura MVC y base de datos MySQL. Permite un CRUD completo sobre ambas entidades, con validaciones en frontend (HTML5 + JavaScript) y backend (PHP).

## Tecnologias

- PHP 8+ (sin frameworks), `mysqli` para el acceso a datos
- MySQL (probado tambien con MariaDB, ya que es 100% compatible; el proyecto se desarrollo y probo localmente sobre MariaDB via XAMPP)
- HTML5, CSS3, JavaScript (validaciones del lado del cliente)

## Estructura del proyecto

```
/public
    index.php          -> Front Controller (enrutador), unico punto expuesto por el servidor web
    /css
        estilo.css
    /js
        validacion.js   -> Validaciones de formularios en el cliente
/app
    /controllers        -> ClienteController.php, PedidoController.php
    /models              -> Cliente.php, Pedido.php (acceso a datos con mysqli)
    /views                -> Vistas HTML por entidad (clientes/, pedidos/, partials/)
/config
    conexion.php         -> Clase Conexion, conexion a MySQL con mysqli
/database
    database.sql          -> Script de creacion de la base de datos
```

`css/` y `js/` viven dentro de `public/` a proposito: el servidor solo expone ese directorio (ver `Dockerfile`), manteniendo `app/`, `config/` y `database/` fuera del alcance de peticiones HTTP directas.

## Entidades y relacion

- **Cliente**: id, nombre, correo, telefono, direccion.
- **Pedido**: id, cliente_id (FK -> clientes.id), producto, cantidad, precio_unitario, estado, fecha_pedido.

Un cliente puede tener muchos pedidos (relacion 1:N). No se permite eliminar un cliente que tenga pedidos asociados.

## Enrutamiento

Todas las peticiones pasan por `public/index.php`, que lee el parametro `url` y decide que metodo del controlador ejecutar. Ejemplos:

- `index.php?url=cliente/listar` -> listado de clientes
- `index.php?url=cliente/crearForm` -> formulario de nuevo cliente
- `index.php?url=cliente/crear` -> guarda el POST del formulario
- `index.php?url=cliente/editarForm&id=1` -> formulario de edicion
- `index.php?url=cliente/actualizar` -> guarda los cambios
- `index.php?url=cliente/eliminar&id=1` -> elimina el registro

Lo mismo aplica para `pedido/...`.

## Requisitos

- PHP >= 8.0 con extension `mysqli`
- MySQL >= 5.7 o MariaDB >= 10.4 (totalmente compatibles para este proyecto)

## Instalacion y ejecucion local

1. Clonar el repositorio:
   ```
   git clone <url-del-repositorio>
   cd clientes-pedidos-mvc
   ```

2. Crear la base de datos ejecutando el script SQL (funciona igual con `mysql` o con el cliente de MariaDB):
   ```
   mysql -u root -p < database/database.sql
   ```
   Esto crea la base `clientes_pedidos` con las tablas `clientes` y `pedidos`, junto con datos de ejemplo.

3. Configurar la conexion. Por defecto `config/conexion.php` usa:
   - host: `localhost`
   - puerto: `3306`
   - base de datos: `clientes_pedidos`
   - usuario: `root`
   - clave: `1234` (password por defecto de root en XAMPP; ajustar segun tu instalacion)

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
3. Render no ofrece MySQL administrado; se recomienda usar un proveedor externo de MySQL o MariaDB (por ejemplo Railway, Clever Cloud o Aiven, todos compatibles) y crear la base de datos ahi ejecutando `database/database.sql`.
4. En la seccion de variables de entorno del servicio en Render, configurar:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_NAME`
   - `DB_USER`
   - `DB_PASS`
5. Desplegar. La aplicacion quedara accesible desde la URL publica que asigna Render.

## Validaciones

- **Frontend**: atributos HTML5 (`required`, `min`, etc.) y funciones en `js/validacion.js` (`validarFormularioCliente`, `validarFormularioPedido`) que revisan los campos con `alert()` e impiden el envio del formulario si hay datos invalidos.
- **Backend**: cada controlador vuelve a revisar los campos (que no esten vacios, correo valido, cantidad y precio mayores a 0, correo no duplicado) antes de tocar la base de datos. Ningun campo vacio o invalido llega a guardarse.
