FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    icu-dev \
    linux-headers

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install exif \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install zip \
    && docker-php-ext-install intl \
    && docker-php-ext-install sockets

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions (only for files that exist in the image)
# Set permissions for the user namespace mapping
RUN chmod -R 775 /var/www/html/bootstrap/cache

# Create startup script
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'echo "Setting up Statamic directories and permissions..."' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/logs' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/statamic/stache-locks' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache/data/stache/timestamps/collections' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache/data/stache/timestamps/globals' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache/data/stache/timestamps/navigation' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache/data/stache/timestamps/taxonomies' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache/data/stache/timestamps/structures' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache/data/stache/timestamps/forms' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache/data/stache/timestamps/assets' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache/data/stache/timestamps/users' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache/data/stache/timestamps/entries' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/sessions' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/views' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/framework/cache' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/app/public' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/statamic/glide' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/statamic/search' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/statamic/updater' >> /start.sh && \
    echo 'mkdir -p /var/www/html/storage/debugbar' >> /start.sh && \
    echo 'mkdir -p /var/www/html/bootstrap/cache' >> /start.sh && \
    echo 'touch /var/www/html/resources/sites.yaml' >> /start.sh && \
    echo 'echo "Setting ownership and permissions..."' >> /start.sh && \
    echo 'chown -R 1000:1000 /var/www/html/storage' >> /start.sh && \
    echo 'chown -R 1000:1000 /var/www/html/bootstrap/cache' >> /start.sh && \
    echo 'chown -R 1000:1000 /var/www/html/public' >> /start.sh && \
    echo 'chown -R 1000:1000 /var/www/html/resources' >> /start.sh && \
    echo 'chown -R 1000:1000 /var/www/html/content' >> /start.sh && \
    echo 'chmod -R 775 /var/www/html/storage' >> /start.sh && \
    echo 'chmod -R 775 /var/www/html/bootstrap/cache' >> /start.sh && \
    echo 'chmod -R 755 /var/www/html/public' >> /start.sh && \
    echo 'chmod -R 775 /var/www/html/resources' >> /start.sh && \
    echo 'chmod -R 775 /var/www/html/content' >> /start.sh && \
    echo 'echo "Running Statamic setup..."' >> /start.sh && \
    echo 'php artisan statamic:install --no-interaction' >> /start.sh && \
    echo 'php artisan statamic:assets:generate' >> /start.sh && \
    echo 'echo "Final permission fix..."' >> /start.sh && \
    echo 'chown -R 1000:1000 /var/www/html/storage' >> /start.sh && \
    echo 'chown -R 1000:1000 /var/www/html/resources' >> /start.sh && \
    echo 'chown -R 1000:1000 /var/www/html/content' >> /start.sh && \
    echo 'chmod -R 775 /var/www/html/storage' >> /start.sh && \
    echo 'chmod -R 775 /var/www/html/resources' >> /start.sh && \
    echo 'chmod -R 775 /var/www/html/content' >> /start.sh && \
    echo 'echo "Starting PHP-FPM..."' >> /start.sh && \
    echo 'exec php-fpm' >> /start.sh && \
    chmod +x /start.sh

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start with permission fix
CMD ["/start.sh"]
