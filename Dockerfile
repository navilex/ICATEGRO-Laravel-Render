# 1. Usamos una imagen oficial que ya tiene PHP 8.2 y el servidor Apache instalados
FROM php:8.2-apache

# 2. Instalamos herramientas necesarias del sistema (Git, Zip, etc.)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    curl

# Limpiamos la caché de apt para que la imagen no pese tanto
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Instalamos las extensiones de PHP que Laravel necesita para funcionar
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# 4. Activamos el "mod_rewrite" de Apache (necesario para las rutas de Laravel)
RUN a2enmod rewrite

# 5. Copiamos Composer desde su imagen oficial a nuestra caja
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Nos situamos en la carpeta donde vivirá la web
WORKDIR /var/www/html

# 7. Copiamos todo nuestro proyecto de Windows a la caja
COPY . .

# 8. Instalamos las dependencias de PHP (sin las de desarrollo para que pese menos)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 9. Damos permisos a Laravel para que pueda escribir en sus carpetas de logs y caché
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Configuramos Apache para que su "punto de entrada" sea la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 11. Exponemos el puerto 80 (el estándar de la web)
EXPOSE 80