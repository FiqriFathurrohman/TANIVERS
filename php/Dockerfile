FROM php:8.4-fpm

# Install dependensi sistem untuk ekstensi PHP (ditambahkan libpng, libjpeg, freetype)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Konfigurasi dan install ekstensi GD (KOREKSI: Hapus flag -y di sini)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install dan aktifkan ekstensi PHP lainnya termasuk opcache untuk performa
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    intl \
    zip \
    opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Atur permission agar PHP-FPM (www-data) bisa menulis ke volume src Laravel
RUN chown -R www-data:www-data /var/www

USER www-data