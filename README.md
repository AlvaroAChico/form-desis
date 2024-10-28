# Instrucciones para Ejecutar el Proyecto de Registro de Productos

## Requisitos Previos

- PHP 7.0 o superior.
- Servidor MySQL.
- XAMPP (incluye Apache y PHP).
- Un navegador web.

## Pasos para Instalar en Local

1. **Instalar XAMPP**

   - Descarga e instala [XAMPP](https://www.apachefriends.org/es/index.html) en tu máquina.
   - Inicia el Panel de Control de XAMPP y activa los servicios de Apache y MySQL.

2. **Configurar la Base de Datos**

   - Abre phpMyAdmin dirigiéndote a `http://localhost/phpmyadmin` en tu navegador.
   - Crea una nueva base de datos para el proyecto.
   - Importa el archivo `sql/create_tables.sql` para crear las tablas necesarias en la base de datos.
     - Para hacer esto, selecciona tu nueva base de datos en phpMyAdmin, haz clic en "Importar", selecciona el archivo `create_tables.sql` y haz clic en "Continuar".
   - Luego, importa el archivo `sql/data.sql` para cargar los datos de prueba en las tablas.
     - Repite el proceso anterior, seleccionando el archivo `data.sql` esta vez.

3. **Actualizar Configuración de Conexión**

   - Edita el archivo `db.php` para añadir las credenciales correctas de la base de datos (`$DB_HOST`, `$DB_NAME`, `$DB_USER`, `$DB_PASSWORD`).
   - Asegúrate de que el usuario y la contraseña coincidan con los de tu instalación de MySQL en XAMPP (por defecto, el usuario es `root` y no hay contraseña).

4. **Subir los Archivos**

   - Copia todos los archivos del proyecto en la carpeta `htdocs` de XAMPP. La ruta típica es `C:\xampp\htdocs\`.
   - Puedes crear una carpeta con un nombre específico, por ejemplo, `form-desis`, y colocar todos los archivos dentro de esta carpeta.

5. **Probar el Aplicativo**
   - Abre tu navegador y dirígete a `http://localhost/form-desis` (o usa el nombre que le hayas dado a la carpeta en `htdocs`).

## Versión

- PHP: 7.4
- MySQL: 8.0 (incluido en XAMPP)

## Archivos SQL

- `sql/create_tables.sql`: Contiene las instrucciones para crear todas las tablas necesarias.
- `sql/data.sql`: Contiene datos precargados necesarios para el funcionamiento del proyecto.

Para cualquier pregunta, por favor contacta a alvaro.achico@gmail.com.
