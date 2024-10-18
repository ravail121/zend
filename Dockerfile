# Use an official PHP 8.1 image with Apache as the base image
FROM php:8.1-apache

# Install system dependencies, PHP extensions, and nano
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    git \
    unzip \
    nano \ 
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql mysqli \
    && docker-php-ext-install intl \
    && a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the project files into the container's working directory
COPY . /var/www/html/

# Install Composer (PHP dependency manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear Composer cache
RUN composer clear-cache

# Optional: Install PHP dependencies using Composer at build time (uncomment if you need it)
# RUN composer install --ignore-platform-reqs

# Set file permissions (optional, adjust as needed)
RUN chown -R www-data:www-data /var/www/html

# Expose Apache port
EXPOSE 80

# Configure Apache to serve your project
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Restart Apache to apply changes
RUN service apache2 restart

# Start Apache in the foreground (default)
CMD ["apache2-foreground"]
