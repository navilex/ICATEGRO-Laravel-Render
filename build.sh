#!/usr/bin/env bash
# Salir si hay errores
set -o errexit

composer install --no-dev --optimize-autoloader

# Instalar dependencias de JS (si usas Vite o Mix)
# npm install
# npm run build

# Generar caché y preparar el entorno
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
php artisan migrate --force