FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip \
        curl \
        xml \
        opcache \
    && rm -rf /var/lib/apt/lists/* # Clean up apt cache to reduce image size

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /var/www/html/

WORKDIR /var/www/html/

# Install PHP dependencies
# For production, it's recommended to use --no-dev and --optimize-autoloader
RUN composer install --no-dev --optimize-autoloader

# Set correct ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    # Explicitly set write permissions for the writable directory
    && chmod -R 775 /var/www/html/writable \
    # Optional: If your app uses an app/Storage folder for caching/uploads
    && chown -R www-data:www-data /var/www/html/app/Storage \
    && chmod -R 775 /var/www/html/app/Storage

# Update Apache config to use public/ as DocumentRoot
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]