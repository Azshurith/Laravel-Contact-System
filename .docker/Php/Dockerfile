# Use the official PHP 8.1 FPM image as the base image
FROM php:8.1-fpm

# Update package lists and install required packages
RUN apt-get update && \
    apt-get install -y \
    bash \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl

# Configure and install PHP extensions (gd, zip, pdo, pdo_mysql)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer