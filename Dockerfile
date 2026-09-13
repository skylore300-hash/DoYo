# =========================
# Stage 1 : Build Vite
# =========================
FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY resources ./resources
COPY vite.config.js ./

RUN npm run build


# =========================
# Stage 2 : Laravel + Apache
# =========================
FROM php:8.3-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libonig-dev \
        libsqlite3-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install \
        pdo_sqlite \
        mbstring \
        bcmath \
        exif \
        pcntl \
        zip \
        opcache \
    && a2enmod rewrite \
    && sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" \
        /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's/AllowOverride None/AllowOverride All/' \
        /etc/apache2/sites-available/000-default.conf \
    && rm -rf /var/lib/apt/lists/*


# =========================
# Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

COPY . .

COPY --from=assets /app/public/build public/build

RUN composer dump-autoload --no-dev --optimize \
    && mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        bootstrap/cache \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache


# =========================
# Render
# =========================
EXPOSE 10000

CMD ["sh", "-c", "PORT=${PORT:-10000}; sed -ri \"s/Listen [0-9]+/Listen ${PORT}/\" /etc/apache2/ports.conf; sed -ri \"s/\\*:[0-9]+/*:${PORT}/\" /etc/apache2/sites-available/000-default.conf; apache2-foreground"]