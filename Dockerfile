FROM php:8.1-apache

# Enable rewrite module
RUN a2enmod rewrite

# Install dependencies
COPY . /var/www/html/
WORKDIR /var/www/html/

RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer install

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Set DocumentRoot to /public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
