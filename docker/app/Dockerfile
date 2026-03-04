FROM ghcr.io/darmshot/shopper-php84-base:latest

WORKDIR /var/www/html

# Copy dependences files first for caching
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Install dependencies (cached unless composer files change)
RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN npm ci

# Now copy the rest of the application
COPY --chown=www:www . .

RUN npm run build

# Run post-copy optimizations
RUN composer install --no-dev --optimize-autoloader
RUN php artisan view:cache
RUN php artisan route:cache
RUN php artisan event:cache

# Switch to non-root user
USER www

# Start Application
CMD ["./docker/app/entrypoint.sh"]
