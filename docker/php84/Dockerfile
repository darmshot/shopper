FROM php:8.4-cli-alpine

LABEL authors="stas"

ARG WWWUSER
ARG WWWGROUP

# Install system dependencies
RUN apk add --no-cache \
     bash \
     curl \
     zip \
     unzip \
     libzip-dev \
     libpng-dev \
     libjpeg-turbo-dev \
     freetype-dev \
     libxml2-dev \
     oniguruma-dev \
     autoconf \
     g++ \
     make \
     file \
     supervisor \
     shadow \
     linux-headers \
     libevent-dev \
     openssl-dev \
     icu-dev \
     pcre-dev

# Make log dir for Supervisor
RUN mkdir -p /var/log/supervisor

# Install PHP extensions
RUN docker-php-ext-configure zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring xml bcmath sockets intl pcntl

# Install Node.js 24 + npm + npx
RUN  curl -fsSL https://alpine.nodesource.com/setup_24.x | sh \
    && apk add --no-cache nodejs npm

# Install Redis and Swoole via PECL
RUN pecl install redis swoole \
    && docker-php-ext-enable redis swoole

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy your custom php.ini into the container
COPY php.ini /usr/local/etc/php/php.ini

# Set working directory
WORKDIR /var/www/html


# Create a user with UID 1000 and GID 1000
RUN adduser -D -u 1000 -g 'www' www
RUN groupmod --gid ${WWWGROUP} www
RUN usermod --uid ${WWWUSER} www
RUN usermod -a -G www www

# Set permissions on working directory
RUN chown -R www:www /var/www/html

# Switch to non-root user
USER www

# Expose Laravel's default port
EXPOSE 8000
