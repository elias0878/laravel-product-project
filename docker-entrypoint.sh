#!/bin/bash
# Docker Entrypoint Script for Laravel

set -e

# مسح جميع أنواع الكاش
echo "Clearing all caches..."
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# تحسين التخزين المؤقت للإنتاج
echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# تشغيل التهجيرات
echo "Running migrations..."
php artisan migrate --force || true

echo "Starting application..."
exec "$@"
