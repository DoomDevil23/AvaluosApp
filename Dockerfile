# Use an official PHP image
FROM php:8.2-fpm

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Install system dependencies
RUN apt-get update && apt-get install -y unzip git curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies and build assets
RUN npm install && npm run build

# Run Laravel setup commands
RUN php artisan migrate --force
RUN php artisan db:seed
RUN php artisan config:clear && php artisan cache:clear

# Expose the necessary port
EXPOSE 8000

# Start Laravel application
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]