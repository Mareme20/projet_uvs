#!/bin/bash
set -e

echo "Installing PHP and Composer..."
apt-get update
apt-get install -y php php-curl php-xml php-pgsql php-bcmath php-json php-mbstring php-tokenizer php-ctype

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

echo "Installing PHP dependencies..."
composer install --no-dev

echo "Installing Node dependencies..."
npm install

echo "Building assets..."
npm run build

echo "Running migrations..."
php artisan migrate --force

echo "Build complete!"
