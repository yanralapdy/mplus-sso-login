#!/bin/sh

set -e

echo "Running PROD bootstrap..."

echo "Installing composer dependencies (no-dev)..."
composer install \
  --no-dev \
  --optimize-autoloader \
  --no-interaction

echo "Running migrations..."
php artisan migrate --force

echo "Linking storage..."
php artisan storage:link || true

echo "Caching configuration..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "PROD setup completed successfully!"

