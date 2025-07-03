# Folosește PHP 8.3 cu Apache
FROM php:8.3-apache

# Instalează extensii PHP necesare Laravel
RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Instalare Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setare director de lucru
WORKDIR /var/www/html

# Copiază fișierele Laravel în container
COPY . .

# Rulează Composer în container (instalează vendor/)
RUN composer install --no-dev --optimize-autoloader

# Permisiuni corecte
RUN chmod -R 775 storage bootstrap/cache

# Expune portul pe care Laravel servește
EXPOSE 80

# Rulează Laravel
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
