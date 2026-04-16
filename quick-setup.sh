#!/bin/bash

# ============================================================
# QUICK START SETUP TDINUS di cPanel
# ============================================================
# Jalankan: bash quick-setup.sh

echo ""
echo "╔════════════════════════════════════════════════════╗"
echo "║    TDINUS QUICK SETUP untuk cPanel                ║"
echo "╚════════════════════════════════════════════════════╝"
echo ""

# ============================================================
# PART 1: Verify Setup Location
# ============================================================

echo "📍 Checking current location..."
pwd

if [[ ! -f "artisan" ]]; then
    echo "❌ Error: artisan file not found!"
    echo "⚠️  Please run this script from the Laravel root directory"
    echo ""
    echo "Expected files:"
    echo "  - artisan"
    echo "  - composer.json"
    echo "  - .env"
    exit 1
fi

echo "✅ Location verified (Laravel root directory)"
echo ""

# ============================================================
# PART 2: Composer Setup
# ============================================================

echo "📦 Step 1/5: Installing Composer dependencies..."

if [ ! -d "vendor" ]; then
    composer install --no-dev --optimize-autoloader
    echo "✅ Composer dependencies installed"
else
    echo "⚠️  vendor/ already exists, skipping..."
fi
echo ""

# ============================================================
# PART 3: Environment Setup
# ============================================================

echo "⚙️  Step 2/5: Setting up environment..."

if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "✅ .env file created from .env.example"
    echo ""
    echo "⚠️  IMPORTANT: Edit .env with your cPanel database credentials!"
    echo "   Edit with: nano .env"
    echo ""
    read -p "Press Enter after editing .env (or skip if already configured)..."
else
    echo "✅ .env file already exists"
fi
echo ""

# ============================================================
# PART 4: Application Key
# ============================================================

echo "🔑 Step 3/5: Generating application key..."
php artisan key:generate --force
echo "✅ Application key generated"
echo ""

# ============================================================
# PART 5: Database & Migrations
# ============================================================

echo "🗄️  Step 4/5: Running database migrations..."
php artisan migrate --force
echo "✅ Database migrations completed"
echo ""

# ============================================================
# PART 6: Cache & Storage
# ============================================================

echo "♻️  Step 5/5: Clearing cache and setting up storage..."

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Create storage link
php artisan storage:link 2>/dev/null || true

# Set permissions
chmod -R 755 storage bootstrap/cache
find storage -type f -exec chmod 644 {} \;

echo "✅ Cache cleared and storage configured"
echo ""

# ============================================================
# PART 7: Optimize
# ============================================================

echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize:clear
echo "✅ Application optimized"
echo ""

# ============================================================
# SUCCESS MESSAGE
# ============================================================

echo "╔════════════════════════════════════════════════════╗"
echo "║           ✅ SETUP COMPLETED SUCCESSFULLY!         ║"
echo "╚════════════════════════════════════════════════════╝"
echo ""
echo "📋 NEXT STEPS:"
echo ""
echo "1️⃣  VERIFY DOCUMENT ROOT in cPanel:"
echo "   - Login to cPanel → Addon Domains (or Manage Domains)"
echo "   - Find: tdinus.com"
echo "   - Set Document Root to: /home/USERNAME/public_html/public"
echo "   - (Replace USERNAME with your cPanel username)"
echo ""
echo "2️⃣  VERIFY DATABASE in .env:"
echo "   - Run: nano .env"
echo "   - Check: DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD"
echo ""
echo "3️⃣  TEST THE APPLICATION:"
echo "   - Open URL: https://tdinus.com"
echo ""
echo "4️⃣  IF ERROR, CHECK LOGS:"
echo "   - Run: tail -f storage/logs/laravel.log"
echo ""
echo "5️⃣  VERIFY DATABASE CONNECTION:"
echo "   - Run: php artisan tinker"
echo "   - Type: DB::connection()->getPdo();"
echo "   - Type: exit"
echo ""
echo "📝 Useful Commands:"
echo "   - php artisan migrate --force    : Run pending migrations"
echo "   - php artisan cache:clear        : Clear all cache"
echo "   - tail -f storage/logs/laravel.log : View logs in real-time"
echo ""
echo "✨ Happy coding!"
echo ""
