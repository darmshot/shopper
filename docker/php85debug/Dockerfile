FROM phpswoole/swoole:php8.5-alpine

LABEL authors="darmshot"

ARG WWWUSER=1000
ARG WWWGROUP=1000

RUN apk add --no-cache \
    shadow \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    zlib-dev \
    icu-dev \
    && curl -fsSL https://alpine.nodesource.com/setup_24.x | sh \
    && apk add --no-cache nodejs npm

RUN apk add --no-cache --virtual .build-deps \
        autoconf \
        build-base \
        linux-headers \
        git \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install gd \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install intl \
    && git clone https://github.com/xdebug/xdebug.git /tmp/xdebug \
    && cd /tmp/xdebug \
    && phpize \
    && ./configure \
    && make \
    && make install \
    && docker-php-ext-enable xdebug \
    && apk del .build-deps \
    && rm -rf /tmp/xdebug

COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/html

RUN addgroup -g ${WWWGROUP} www \
    && adduser -D -u ${WWWUSER} -G www www \
    && chown -R www:www /var/www/html

USER www
