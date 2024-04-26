#!/bin/sh

# Load environment variables
source .env

# Export all variables loaded from .env# Export variables from .env file
export $(grep -v '^#' .env | grep -v '^\s*$' | sed 's/\r$//' | xargs)

# Clone your laravel repository if PROJECT_REPOSITORY is not empty
if [ -n "$PROJECT_REPOSITORY" ]; then
    git clone "$PROJECT_REPOSITORY" Web
else
    php composer create-project laravel/laravel Web
fi

# Change to the Web directory
cd Web

# Start PHP-FPM in the background
php-fpm -D

# Install or update Composer dependencies
composer install

# Copy .env.example to .env
cp .env.example .env

# Generate Laravel application key
php artisan key:generate

# Start Laravel's built-in development server
php artisan serve --host 0.0.0.0 --port 8000