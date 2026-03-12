FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY docker/apache.conf /etc/apache2/conf-available/esitrana.conf
RUN a2enconf esitrana

WORKDIR /var/www/html
COPY . /var/www/html

RUN mkdir -p /var/www/html/uploads/doctors /var/www/html/uploads/images \
    && chown -R www-data:www-data /var/www/html/uploads \
    && find /var/www/html/uploads -type d -exec chmod 775 {} \; \
    && find /var/www/html/uploads -type f -exec chmod 664 {} \;
