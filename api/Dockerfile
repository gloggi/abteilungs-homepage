FROM php:8.3-apache

WORKDIR /var/www

RUN apt-get -y update && apt-get -y upgrade && apt-get -y install libxml2-dev libpng-dev curl zlib1g-dev unzip libzip-dev libonig-dev locales default-mysql-client

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN docker-php-ext-install pdo pdo_mysql mbstring xml bcmath zip gd

RUN sed -i 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite


ENTRYPOINT bash entrypoint.sh