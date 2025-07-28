FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
