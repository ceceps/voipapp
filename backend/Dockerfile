
FROM php:8.3-fpm

RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev 

# PHP Extension
RUN docker-php-ext-install gettext intl pdo_mysql gd

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --ansi --version --no-interaction

COPY ./composer.json ./
RUN composer install --no-scripts --no-autoloader --ansi --no-interaction
COPY . /var/www/html

RUN composer dump-autoload -o \
    && chown -R :www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000

