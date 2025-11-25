# Sistema de Reservaciones de Servicios

## Descripción
Este proyecto es un sistema de reservaciones de servicios desarrollado con **Laravel** y **MySQL**, diseñado para gestionar reservas, pagos y usuarios de manera segura y escalable.  
Incluye autenticación con **JWT**, integración de pagos con **Stripe** y gestión de imágenes con **Cloudinary**.  
Se aplicaron buenas prácticas de desarrollo como **FormRequests**, **Services**, **Filters**, **Middleware**, **Observers** y **DTOs con Spatie**, y todas las APIs fueron probadas con **Postman**.

---

## Tecnologías
- **Backend:** Laravel  
- **Base de datos:** MySQL  
- **Autenticación:** JWT  
- **Pagos:** Stripe  
- **Gestión de imágenes:** Cloudinary  
- **Buenas prácticas:** FormRequests, Services, Filters, Middleware, Observers, DTOs con Spatie  
- **Control de versiones:** Git  
- **Testing de APIs:** Postman  

---

## Requisitos previos
Antes de comenzar, asegúrate de tener instalado:
- PHP >= 8.1  
- Composer  
- MySQL  
- Node.js y NPM (para manejar dependencias opcionales del frontend si se agregan)  

---

## Instalación

Sigue los pasos para ejecutar el proyecto localmente:

```bash
# 1. Clona el repositorio
git clone https://github.com/ArgentinoM/Reservly.git

# 2. Ingresa al proyecto
cd Reservly

# 3. Instala las dependencias de Laravel
composer install

# 4. Copia el archivo de entorno de ejemplo
cp .env.example .env

# 5. Configura el archivo .env con tu base de datos, Stripe y Cloudinary

# 6. Genera la clave de aplicación
php artisan key:generate

# 7. Ejecuta las migraciones
php artisan migrate

# 8. (Opcional) Llena la base de datos con datos de prueba
php artisan db:seed

# 9. Inicia el servidor de desarrollo
php artisan serve
# Reservly-backend
# Reservly-backend
