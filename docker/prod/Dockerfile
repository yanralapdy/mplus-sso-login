FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY src /var/www

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

