#!/bin/sh

set -e

echo "Running DEV bootstrap..."

echo "Installing composer dependencies..."
composer install

echo "Generating APP_KEY..."
php artisan key:generate --force

echo "Generating JWT secret..."
php artisan jwt:secret --force

echo "Resetting database..."
php artisan migrate:fresh --seed

echo "Linking storage..."
php artisan storage:link || true

echo "Clearing caches..."
php artisan optimize:clear

echo "DEV setup completed successfully!"

