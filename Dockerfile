# Folosim imagine oficială PHP 8.3 cu Apache
FROM php:8.3-apache

# Instalăm extensiile necesare Laravel (inclusiv oniguruma pentru mbstring)
RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev libpq-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Instalăm Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setăm directorul de lucru
WORKDIR /var/www/html

# Copiem fișierele Laravel în container
COPY . .

# Instalăm pachetele Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisiuni
RUN chmod -R 775 storage bootstrap/cache

# Portul expus
EXPOSE 80

# Pornim Laravel
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
