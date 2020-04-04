FROM php:5.6-apache
RUN apt-get -y update && apt-get upgrade -y
RUN docker-php-ext-install mysql && docker-php-ext-enable mysql