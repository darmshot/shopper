FROM phpswoole/swoole:php8.5-alpine

LABEL authors="darmshot"

ARG WWWUSER=1000
ARG WWWGROUP=1000

RUN apk add --no-cache \
    shadow \
    curl -fsSL https://alpine.nodesource.com/setup_24.x | sh \
        && apk add --no-cache nodejs npm

RUN docker-php-ext-install \
    pcntl # OS signals

COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/html

RUN addgroup -g ${WWWGROUP} www \
    && adduser -D -u ${WWWUSER} -G www www \
    && chown -R www:www /var/www/html

USER www
