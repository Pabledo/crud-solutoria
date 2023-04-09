
# CRUD Solutoria
Desarrollado por Pablo Muñiz Campos en Laravel 8 con PHP 7.4 y MySQL
## Proceso de instalación

Navegar al directorio del proyecto y ejecutar los siguientes comandos en la terminal
```
npm install
composer install
// Copiar el archivo .env.example y renombrarlo como .env; En la propiedad DB_DATABASE, asignar el nombre de la base de datos a utilizar; Cambiar DB_USERNAME y DB_PASSWORD a las de su conexión MySQL de ser necesario.
php artisan key:generate
npm run dev
php artisan migrate:fresh --seed
php artisan serve
```
