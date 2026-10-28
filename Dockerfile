# My Recipes Book: Laravel 12 on PHP 8.3 + Apache, SQLite by default.
FROM php:8.3-apache

RUN apt-get update \
 && apt-get install -y --no-install-recommends unzip libzip-dev \
 && docker-php-ext-install zip \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Dependencies first so they are cached between builds.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --optimize --no-dev \
 && php artisan package:discover --ansi \
 && chown -R www-data:www-data storage bootstrap/cache database \
 && sed -i 's/^Listen 80$/Listen ${PORT}/' /etc/apache2/ports.conf \
 && chmod +x docker/start.sh

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

ENV PORT=8080 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/var/www/html/database/database.sqlite \
    SESSION_DRIVER=file \
    CACHE_DRIVER=file \
    MAIL_MAILER=log \
    MAIL_DRIVER=log

EXPOSE 8080
CMD ["docker/start.sh"]
