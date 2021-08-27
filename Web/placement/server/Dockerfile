FROM php:7.2-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN cd /etc/apache2/mods-available/ && a2enmod headers && service apache2 restart

WORKDIR /var/www/html
COPY . .
