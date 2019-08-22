FROM php:7.1-fpm-alpine3.4
RUN  docker-php-ext-install pdo pdo_mysql
RUN apk update \
    apk install git zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
