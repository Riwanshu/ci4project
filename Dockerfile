# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files to container
COPY . .

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends unzip libzip-dev && \
    docker-php-ext-install zip pdo_mysql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Set Apache DocumentRoot to CodeIgniter's public folder
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80
