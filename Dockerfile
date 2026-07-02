FROM php:8.1-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    postgresql-client \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql \
    && docker-php-ext-install gd \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer Node.js pour Vite
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers du projet
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --no-scripts

# Installer les dépendances Node.js et builder les assets
RUN npm install && npm run build

# Générer la clé d'application
RUN php artisan key:generate --force

# Définir les permissions
RUN chmod -R 755 storage bootstrap/cache

# Exposer le port
EXPOSE 10000

# Démarrer l'application
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "10000"]
