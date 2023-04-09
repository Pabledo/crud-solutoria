
# CRUD Solutoria

## Proceso de instalación

Navegar al directorio del proyecto y ejecutar los siguientes comandos en la terminal
```
npm install
composer install
// Copiar el archivo .env.example y renombrarlo como .env; En la propiedad DB_DATABASE, asignar el valor de crud-solutoria
php artisan key:generate
npm run dev
php artisan migrate:fresh --seed
php artisan serve
```
