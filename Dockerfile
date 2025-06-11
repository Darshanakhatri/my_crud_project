#If you're using a different PHP version, update accordingly.
FROM php:8.4.7-fpm

# Install dependencies(required php extensions)
RUN apt-get update && apt-get install -y \
    git unzip curl libicu-dev libzip-dev zip mariadb-client \
    && docker-php-ext-install intl pdo pdo_mysql zip

# Install Composer . it's the cleanest way to get Composer into your image.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/my_crud_project

# Copies everything from the Docker build context (project root) to /var/www/my_crud_project.
COPY . .

# Installs Symfony and PHP dependencies.
RUN composer install --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/my_crud_project
