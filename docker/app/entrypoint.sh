#!/bin/sh
set -e

php artisan config:cache

exec php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
