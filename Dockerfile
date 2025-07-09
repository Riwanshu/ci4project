# Use a specific PHP 8.1 Apache image
FROM php:8.1-apache

# Set working directory inside the container
# This should be where your application code will reside
WORKDIR /var/www/html

# Enable Apache's rewrite module for clean URLs (common for frameworks)
RUN a2enmod rewrite

# Install common system dependencies and PHP extensions required by many applications
# Add any other specific libraries your app might need (e.g., libpng-dev for GD)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libxml2-dev \
    libicu-dev \
    libcurl4-openssl-dev \
    && rm -rf /var/lib/apt/lists/* \
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
        opcache

# Configure gd with freetype, jpeg, and webp support
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

# Copy your application code into the container
# It's important to copy *after* installing dependencies to leverage Docker's caching
COPY . /var/www/html/

# Install Composer globally in the container
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run Composer install for your project.
# Use --no-dev for production to skip dev dependencies.
# --optimize-autoloader improves performance for production.
RUN composer install --no-dev --optimize-autoloader

# Set appropriate permissions for the web server user
# This is crucial for web applications to be able to write to cache/logs etc.
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# If your CodeIgniter public directory is named 'public' (which is standard)
# then this step is correct to set the Apache DocumentRoot.
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expose port 80 for web traffic
EXPOSE 80

# Command to start the Apache server in the foreground
CMD ["apache2-foreground"]