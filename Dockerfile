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

# Préparer le fichier d'environnement et générer la clé d'application
RUN cp .env.example .env && php artisan key:generate --force

# Définir les permissions
RUN chmod -R 755 storage bootstrap/cache

# Copier et rendre exécutable le script d'entrée
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Exposer le port
EXPOSE 10000

# Démarrer l'application
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
