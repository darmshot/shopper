FROM phpswoole/swoole:php8.5-alpine

LABEL authors="darmshot"

ARG WWWUSER=1000
ARG WWWGROUP=1000

# gd dependences: freetype-dev, libjpeg-turbo-dev, libpng-dev, libwebp-dev, zlib-dev
# addgroup dependences: shadow
# intl dependences: icu-dev
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

# pcntl OS signals
# gd image manipulation
# intl number currency dependence
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install gd \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install intl

COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/html

RUN addgroup -g ${WWWGROUP} www \
    && adduser -D -u ${WWWUSER} -G www www \
    && chown -R www:www /var/www/html

USER www
