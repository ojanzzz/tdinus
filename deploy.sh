#!/bin/bash

# === TDINUS Laravel Deployment Script ===
# Jalankan script ini setelah pull dari GitHub di server cPanel

set -e

echo "🚀 Starting TDINUS deployment..."

# 1. Set proper permissions
echo "📁 Setting folder permissions..."
find storage -type d -exec chmod 755 {} \;
find storage -type f -exec chmod 644 {} \;
chmod -R 755 storage bootstrap/cache
chmod 755 public

# 2. Install/Update Composer dependencies
echo "📦 Installing Composer dependencies..."
if [ -f "composer.lock" ]; then
    composer install --no-dev --optimize-autoloader
else
    composer install --optimize-autoloader
fi

# 3. Copy .env if not exists
echo "⚙️  Checking .env file..."
if [ ! -f ".env" ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
    echo "⚠️  IMPORTANT: Update .env with your database credentials!"
else
    echo ".env file already exists"
fi

# 4. Generate APP_KEY if not set
echo "🔑 Generating APP_KEY..."
php artisan key:generate --force

# 5. Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 6. Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# 7. Seed database (optional - uncomment if needed)
# echo "🌱 Seeding database..."
# php artisan db:seed --force

# 8. Publish assets
echo "📄 Publishing assets..."
php artisan storage:link 2>/dev/null || true

# 9. Optimize
echo "⚡ Optimizing application..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "✅ Deployment completed successfully!"
echo ""
echo "📝 Next steps:"
echo "1. Verify .env file has correct database credentials"
echo "2. Check if database migrations ran successfully"
echo "3. Test the application: php artisan tinker"
echo "4. Monitor logs: tail -f storage/logs/laravel.log"
echo ""
