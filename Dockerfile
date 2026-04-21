FROM php:8.4-fpm-alpine

RUN apk update && apk upgrade --no-cache \
 && apk add --no-cache \
    bash git curl zip unzip \
    postgresql-dev libzip-dev \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    icu-dev oniguruma-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) \
    pdo_pgsql mbstring bcmath gd zip intl exif

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

EXPOSE 8000
