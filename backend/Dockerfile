
FROM php:8.3.22-zts-alpine3.22

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

WORKDIR /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY . .
RUN composer dump-autoload --optimize

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000