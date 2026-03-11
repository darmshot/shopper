FROM ghcr.io/darmshot/shopper-php85-base:latest AS base

FROM base AS build

WORKDIR /var/www/html

COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

RUN composer install --no-dev --optimize-autoloader --no-scripts  \
    && npm ci

COPY --chown=www:www . .

RUN composer install --no-dev --optimize-autoloader  \
    && npm run build

RUN php artisan view:cache  \
    && php artisan route:cache  \
    && php artisan event:cache


FROM base AS runtime

WORKDIR /var/www/html

COPY --from=build /var/www/html /var/www/html

USER www

CMD ["./docker/app/entrypoint.sh"]
