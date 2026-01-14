#!/bin/bash
# Docker Entrypoint Script for Laravel
# سكريبت دخول Docker لتطبيق لارافيل

set -e

# انتظار قاعدة البيانات جاهزة
# Wait for database to be ready
wait_for_db() {
    echo "Waiting for database to be ready..."
    local max_attempts=30
    local attempt=1

    while [ $attempt -le $max_attempts ]; do
        if php /app/artisan db:show --json 2>/dev/null || \
           mysqladmin ping -h "${DB_HOST:-localhost}" --silent 2>/dev/null || \
           true; then
            echo "Database is ready!"
            return 0
        fi

        echo "Attempt $attempt/$max_attempts: Database not ready yet, waiting..."
        sleep 2
        attempt=$((attempt + 1))
    done

    echo "Warning: Database connection timeout, continuing anyway..."
    return 0
}

# التحقق من وجود ملف البيئة
# Check if .env file exists
if [ ! -f /app/.env ]; then
    echo "Creating .env file from example..."
    if [ -f /app/.env.example ]; then
        cp /app/.env.example /app/.env
    else
        echo "Warning: .env.example not found!"
    fi
fi

# تكوين ملف البيئة للإنتاج
# Configure .env file for production
if [ -f /app/.env ]; then
    echo "Configuring environment variables..."

    # تعيين مفتاح التطبيق إذا لم يكن موجوداً
    # Set APP_KEY if not set
    if ! grep -q "APP_KEY=" /app/.env || grep "APP_KEY=$" /app/.env; then
        echo "Generating APP_KEY..."
        php /app/artisan key:generate --show
    fi

    # تعيين الوضع للإنتاج
    # Set production mode
    sed -i 's/APP_ENV=local/APP_ENV=production/g' /app/.env 2>/dev/null || true
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' /app/.env 2>/dev/null || true
fi

# الانتظار للقاعدة البيانية
# Wait for database
wait_for_db

# تشغيل التهجيرات
# Run migrations
echo "Running database migrations..."
php /app/artisan migrate --force --step || echo "Migration failed or no database configured"

# مسح وتحسين التخزين المؤقت
# Clear and optimize cache
echo "Optimizing application..."
php /app/artisan config:cache 2>/dev/null || true
php /app/artisan route:cache 2>/dev/null || true
php /app/artisan view:cache 2>/dev/null || true

# إنشاء روابط التخزين
# Create storage links
php /app/artisan storage:link 2>/dev/null || true

echo "Starting application..."
exec "$@"
