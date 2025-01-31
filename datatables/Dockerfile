FROM php:apache

# Install dependencies for the PHP extensions.
# RUN apt-get update -y \
    #    && apt-get install -y libcurl4-openssl-dev libmcrypt-dev libpng-dev libpq-dev libxml2-dev libyaml-dev unzip wget

# Install PHP extensions.
# RUN docker-php-ext-install bcmath curl gd mbstring mysqli pdo pdo_mysql pgsql
# RUN pecl install mcrypt-1.0.1 yaml-2.0.0 && docker-php-ext-enable mcrypt yaml
RUN docker-php-ext-install pdo_mysql

# Enable mod_rewrite and the site configuration for the Apache HTTP server.
# RUN a2enmod rewrite && a2enconf redfly-site
# RUN a2enmod rewrite

# Expose a mount point for mounting and working with web application files.
VOLUME ["/var/www"]
WORKDIR /var/www
