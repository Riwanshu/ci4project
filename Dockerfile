# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files to container
COPY . .

# Update package list
RUN apt-get update

# Install unzip and libzip-dev dependencies
RUN apt-get install -y --no-install-recommends unzip libzip-dev

# Install PHP extensions zip and pdo_mysql
RUN docker-php-ext-install zip pdo_mysql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run composer install
RUN composer install

# Clean up apt caches to reduce image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Change Apache DocumentRoot to public folder of CodeIgniter
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/writable

# Expose port 80 for HTTP
EXPOSE 80
