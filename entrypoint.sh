#!/bin/bash
set -e

echo "Running database migrations..."
php artisan migrate --force

echo "Starting Laravel application..."
php artisan serve --host 0.0.0.0 --port 10000
