FROM php:8.4-fpm

# Install dependensi sistem untuk ekstensi PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Install dan aktifkan ekstensi PHP yang dibutuhkan Filament & Postgres
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    intl \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www