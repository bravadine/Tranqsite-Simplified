FROM php:8.1-apache
RUN apt update && apt install -y git libzip-dev zip unzip npm
RUN docker-php-ext-install pdo pdo_mysql zip
RUN a2enmod rewrite
