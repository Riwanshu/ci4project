# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files to container
COPY . .

# Install dependencies including intl extension support
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install zip pdo_mysql intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run composer install
RUN composer install

# Change Apache DocumentRoot to public folder of CodeIgniter
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/writable

# Expose port 80 for HTTP
EXPOSE 80
