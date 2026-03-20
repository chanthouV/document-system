# Use official PHP 8.2 image for Render compatibility
FROM php:8.2-apache

# Set environment variables for Render
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV APACHE_RUN_USER=www-data
ENV APACHE_RUN_GROUP=www-data

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    && docker-php-ext-install \
        zip \
        pdo_mysql \
        gd \
        bcmath \
        pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite headers

# Configure Apache for Laravel and Render
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Create Laravel-specific Apache configuration
RUN printf '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files first for better layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies with optimization
RUN composer install --no-interaction --no-dev --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Create necessary directories with proper permissions
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache/data \
    storage/logs \
    bootstrap/cache \
    storage/app/public

# Set proper permissions for Laravel directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache \
    && chmod -R 755 public

# Create optimized startup script for Render
RUN printf '#!/bin/bash\n\
set -e\n\
\n\
# Check if this is first run (database not yet migrated)\n\
if [ ! -f "/var/www/html/storage/.migrated" ]; then\n\
    echo "First run detected - setting up database..."\n\
    \n\
    # Wait for database to be ready (Render specific)\n\
    if [ -n "$DATABASE_URL" ]; then\n\
        echo "Waiting for database connection..."\n\
        timeout 60 bash -c "until php artisan db:show; do sleep 2; done"\n\
    fi\n\
    \n\
    # Run migrations\n\
    echo "Running database migrations..."\n\
    php artisan migrate --force\n\
    \n\
    # Run seeders\n\
    echo "Running database seeders..."\n\
    php artisan db:seed --force\n\
    \n\
    # Clear and cache configurations\n\
    echo "Optimizing Laravel..."\n\
    php artisan config:clear\n\
    php artisan route:clear\n\
    php artisan view:clear\n\
    php artisan config:cache\n\
    php artisan route:cache\n\
    php artisan view:cache\n\
    \n\
    # Generate Swagger documentation\n\
    echo "Generating Swagger documentation..."\n\
    php artisan l5-swagger:generate\n\
    \n\
    # Create migration marker\n\
    touch /var/www/html/storage/.migrated\n\
else\n\
    echo "Application already set up, starting server..."\n\
fi\n\
\n\
# Set proper permissions for storage\n\
chown -R www-data:www-data /var/www/html/storage\n\
chmod -R 775 /var/www/html/storage\n\
\n\
echo "Starting Apache..."\n\
exec apache2-foreground\n' > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

# Expose port 8080 for Render (Render uses this port)
EXPOSE 8080

# Use the startup script
CMD ["/usr/local/bin/start.sh"]
