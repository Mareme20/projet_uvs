#!/bin/bash
set -e

echo "Clearing Laravel cached configuration..."
php artisan config:clear

if [ "$DB_CONNECTION" = "pgsql" ] && [ -n "$DB_HOST" ]; then
    echo "Waiting for PostgreSQL at ${DB_HOST}:${DB_PORT:-5432}..."
    until pg_isready -h "$DB_HOST" -p "${DB_PORT:-5432}" -U "$DB_USERNAME" -d "$DB_DATABASE"; do
        sleep 2
    done
fi

echo "Running database migrations..."
php artisan migrate --force

echo "Seeding the database..."
php artisan db:seed --force

echo "Starting Laravel application..."
php artisan serve --host 0.0.0.0 --port "${PORT:-10000}"
