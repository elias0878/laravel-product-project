# Dockerfile for Laravel Production Deployment
# بناء صورة Docker للإنتاج لتطبيق لارافيل

# المرحلة الأولى: بناء التطبيق
# Stage 1: Build Application
FROM composer:2 AS builder

WORKDIR /app

# نسخ ملفات الاعتماد وتثبيت التبعيات
# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# المرحلة الثانية: صورة PHP النهائية
# Stage 2: Final PHP Image
FROM php:8.2-apache

# تثبيت التبعيات المطلوبة لـ PHP و Apache
# Install required PHP and Apache dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip bcmath \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# تكوين Apache لـ Laravel
# Configure Apache for Laravel
ENV APACHE_DOCUMENT_ROOT=/app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!</VirtualHost>!</VirtualHost>\n<Directory "${APACHE_DOCUMENT_ROOT}">\n    Options Indexes FollowSymLinks\n    AllowOverride All\n    Require all granted\n</Directory>!g' /etc/apache2/sites-available/*.conf

# إعادة توجيه CSS من HTTP إلى HTTPS
RUN echo '<IfModule mod_rewrite.c>\n    RewriteEngine On\n    RewriteCond %{HTTPS} off\n    RewriteRule ^css/(.*)$ https://%{HTTP_HOST}/css/$1 [R=301,L]\n</IfModule>' > /etc/apache2/mods-available/rewrite-css-https.conf && \
    a2enmod rewrite && \
    a2enconf rewrite-css-https

# نسخ تطبيق لارافيل
# Copy Laravel application
COPY --from=builder /app/vendor /app/vendor
COPY . /app

# تعيين صلاحيات المجلدات
# Set folder permissions
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app/storage /app/bootstrap/cache \
    && mkdir -p /app/public/images/products \
    && chown -R www-data:www-data /app/public/images/products \
    && chmod -R 775 /app/public/images/products

# نسخ ملف دخول Docker
# Copy Docker entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /app

# تعيين متغير البيئة للإنتاج
# Set production environment
ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
