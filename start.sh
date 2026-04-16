#!/bin/bash

# === Quick Start Script untuk Development ===
# Usage: ./start.sh

echo "🚀 TDINUS - Quick Start"
echo "======================="

# Check if .env exists
if [ ! -f ".env" ]; then
    echo "📋 Creating .env from .env.example..."
    cp .env.example .env
    sed -i 's/APP_ENV=production/APP_ENV=local/' .env
    sed -i 's/APP_DEBUG=false/APP_DEBUG=true/' .env
fi

# Install dependencies
if [ ! -d "vendor" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install
fi

if [ ! -d "node_modules" ]; then
    echo "📦 Installing NPM dependencies..."
    npm install
fi

# Generate key
echo "🔑 Generating APP_KEY..."
php artisan key:generate --force

# Setup storage
echo "📁 Setting up storage..."
php artisan storage:link 2>/dev/null || true

# Clear cache
echo "🧹 Clearing cache..."
php artisan config:clear
php artisan cache:clear

# Migrate database
echo "🗄️  Running migrations..."
php artisan migrate

# Build assets
echo "🎨 Building assets..."
npm run build

echo ""
echo "✅ All set! Ready to start development"
echo ""
echo "🌐 Available commands:"
echo "   php artisan serve          - Start development server (http://localhost:8000)"
echo "   npm run dev                - Watch for asset changes"
echo "   php artisan tinker         - Interactive PHP shell"
echo ""
echo "📝 Next: Open http://localhost:8000 in your browser"
