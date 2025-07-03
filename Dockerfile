# Dockerfile
FROM php:8.3-apache

# Instalare extensii PHP necesare
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip

# Instalare Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiază proiectul Laravel în container
COPY . /var/www/html

WORKDIR /var/www/html

# Permisiuni pentru storage și bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
