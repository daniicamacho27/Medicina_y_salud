FROM php:8.3-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
      mariadb-server git unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html

RUN cd laravel-medsalud \
    && composer install --no-dev --optimize-autoloader --no-interaction \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

RUN printf "<?php\ndefine('APP_NOMBRE', 'MedSalud');\ndefine('APP_EMAIL_CONTACTO', 'medsalud@info.ar');\ndefine('APP_ENV', 'production');\n" > config/env.php

COPY docker/apache.conf /etc/apache2/conf-available/medsalud.conf
RUN a2enconf medsalud
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

ENV DB_HOST=localhost DB_NAME=medsalud DB_USER=medsalud DB_PASS=medsalud_demo_2026
EXPOSE 80
CMD ["/start.sh"]
