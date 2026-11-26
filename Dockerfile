FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first (better caching)
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

# Copy application code
COPY . .

# Verify critical files exist (will fail build if missing)
RUN test -f public/index.php || { echo "ERROR: public/index.php not found!"; exit 1; }
RUN test -f artisan || { echo "ERROR: artisan not found!"; exit 1; }

# Complete composer setup
RUN composer dump-autoload --optimize

# Create directories
RUN mkdir -p storage/framework/sessions \
             storage/framework/views \
             storage/framework/cache \
             storage/logs \
             bootstrap/cache

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# List files for verification
RUN echo "=== Files in /var/www/html ===" \
    && ls -la \
    && echo "=== Files in public/ ===" \
    && ls -la public/

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
