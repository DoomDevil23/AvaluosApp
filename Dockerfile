# Use an official PHP image
FROM php:8.2-fpm

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Install Composer and dependencies
RUN apt-get update && apt-get install -y unzip git curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 80

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]