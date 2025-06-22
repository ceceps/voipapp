FROM php:8.3-fpm

ARG HOST_USER_UID
ARG HOST_USER_GID

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update -y && apt-get install -y --no-install-recommends \
    build-essential  \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    libmhash-dev \
    libzip-dev \
    libonig-dev \
    libssl-dev \
    openssh-server \
    libmagickwand-dev \
    git \
    cron \
    nano

RUN set -ex \
    && pecl channel-update pecl.php.net \
    && yes no | pecl install redis-stable \
    && docker-php-ext-enable redis

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN pecl install openswoole

# PHP Extension
RUN docker-php-ext-configure intl
RUN docker-php-ext-install gettext intl mysqli pdo_mysql
RUN docker-php-ext-configure gd --with-webp=/usr/include/webp --with-jpeg=/usr/include --with-freetype=/usr/include/freetype2/ \
    && docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install ctype curl dom fileinfo
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install xml

# Optional: Remove build dependencies
RUN apt-get purge -y --auto-remove  && rm -rf /var/lib/apt/lists/*

# Use ARG to define environment variables passed from the Docker build command or Docker Compose.
ARG XDEBUG_ENABLED
ARG XDEBUG_MODE
ARG XDEBUG_HOST
ARG XDEBUG_IDE_KEY
ARG XDEBUG_LOG
ARG XDEBUG_LOG_LEVEL

# Configure Xdebug if enabled
RUN if [ "${XDEBUG_ENABLED}" = "true" ]; then \
    docker-php-ext-enable xdebug && \
    echo "xdebug.mode=${XDEBUG_MODE}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.idekey=${XDEBUG_IDE_KEY}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.log=${XDEBUG_LOG}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.log_level=${XDEBUG_LOG_LEVEL}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_host=${XDEBUG_HOST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ; \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ; \
fi

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html


# Set permission
RUN addgroup --gid $HOST_USER_GID appuser;
RUN adduser --uid $HOST_USER_UID --gid $HOST_USER_GID --disabled-password appuser;
RUN adduser www-data appuser;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer --ansi --version --no-interaction

COPY ./composer.json ./
RUN composer install --no-scripts --no-autoloader --ansi --no-interaction
COPY . /var/www/html

RUN composer dump-autoload -o \
    && chown -R :www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php-fpm"]

EXPOSE 9000

USER $HOST_USER_UID
