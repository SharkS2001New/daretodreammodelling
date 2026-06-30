# Use the official PHP with Apache base image
FROM php:8.2-apache

# Install system packages and PHP extensions in a single RUN layer
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++ \
    nodejs \
    npm && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
        bz2 \
        intl \
        iconv \
        bcmath \
        opcache \
        calendar \
        pdo_mysql \
        gd && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Configure Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    a2enmod rewrite headers && \
    echo '<Directory /var/www/html/public>' >> /etc/apache2/apache2.conf && \
    echo '    Options Indexes FollowSymLinks' >> /etc/apache2/apache2.conf && \
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '    Require all granted' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf && \
    sed -i 's/Listen 80/Listen 8040/' /etc/apache2/ports.conf && \
    sed -i 's/:80/:8040/' /etc/apache2/sites-available/*.conf && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Ensure PHP logs show in Docker logs
ENV LOG_CHANNEL=stderr

# Copy Composer binary from official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy package files first to leverage Docker cache
COPY package.json package-lock.json* ./
RUN npm install

# Copy composer files next to leverage Docker cache
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of the application
COPY . .

# Build frontend assets
RUN npm run build

# Set Git safe directory and fix permissions
RUN git config --global --add safe.directory /var/www/html && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Preserve bundled uploads for PVC bootstrap (K8s mount hides image-layer storage/app/public)
RUN mkdir -p /var/www/html/storage-app-public-seed && \
    cp -a storage/app/public/. /var/www/html/storage-app-public-seed/ 2>/dev/null || true

COPY docker-bootstrap.sh /usr/local/bin/docker-bootstrap.sh
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-bootstrap.sh /usr/local/bin/docker-entrypoint.sh

# Runtime: docker-entrypoint.sh runs docker-bootstrap.sh (migrate + storage:link) before Apache.
EXPOSE 8040
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]