#!/bin/bash

# ============================================================
# Fix for TDINUS Domain di cPanel
# Jalankan script ini setelah aplikasi di-pull ke cPanel
# ============================================================

echo "🔧 Fixing TDINUS Domain Setup di cPanel..."
echo ""

# Tentukan path (sesuaikan dengan struktur cPanel Anda)
# Opsi 1: Jika TDINUS di root public_html
CPANEL_ROOT="/home/tditis693/public_html"
APP_DIR="$CPANEL_ROOT"

# Opsi 2: Jika TDINUS di subfolder (uncomment jika perlu)
# APP_DIR="$CPANEL_ROOT/tdinus"

echo "📍 Application path: $APP_DIR"
echo ""

# ============================================================
# 1. SET FOLDER PERMISSIONS
# ============================================================
echo "📁 Setting folder permissions..."

chmod 755 "$APP_DIR"
chmod 755 "$APP_DIR/public"
chmod 755 "$APP_DIR/storage"
chmod 755 "$APP_DIR/bootstrap"
chmod 755 "$APP_DIR/bootstrap/cache"

find "$APP_DIR/storage" -type d -exec chmod 755 {} \;
find "$APP_DIR/storage" -type f -exec chmod 644 {} \;
find "$APP_DIR/bootstrap/cache" -type d -exec chmod 755 {} \;
find "$APP_DIR/bootstrap/cache" -type f -exec chmod 644 {} \;

echo "✅ Permissions fixed"
echo ""

# ============================================================
# 2. CREATE SYMLINK FOR STORAGE (if needed)
# ============================================================
echo "🔗 Setting up storage symlink..."

if [ ! -L "$APP_DIR/public/storage" ]; then
    ln -s "$APP_DIR/storage/app/public" "$APP_DIR/public/storage"
    echo "✅ Storage symlink created"
else
    echo "✅ Storage symlink already exists"
fi
echo ""

# ============================================================
# 3. VERIFY .HTACCESS
# ============================================================
echo "📄 Verifying .htaccess..."

if [ ! -f "$APP_DIR/public/.htaccess" ]; then
    echo "⚠️  .htaccess not found! Creating..."
    cat > "$APP_DIR/public/.htaccess" << 'EOF'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOF
    echo "✅ .htaccess created"
else
    echo "✅ .htaccess exists"
fi
echo ""

# ============================================================
# 4. VERIFY REQUIRED FILES
# ============================================================
echo "📋 Checking required files..."

files=(
    "$APP_DIR/public/index.php"
    "$APP_DIR/artisan"
    "$APP_DIR/composer.json"
    "$APP_DIR/.env"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "  ✅ $(basename $file)"
    else
        echo "  ❌ $(basename $file) - MISSING!"
    fi
done
echo ""

# ============================================================
# 5. CREATE CAGEFS COMPATIBLE VERSION
# ============================================================
echo "⚙️  Creating wrapper for cPanel/cagefs..."

cat > "$APP_DIR/public/artisan.php" << 'EOF'
<?php
require __DIR__.'/../artisan';
EOF

chmod 755 "$APP_DIR/public/artisan.php"
echo "✅ Artisan wrapper created"
echo ""

# ============================================================
# 6. VERIFY DOCUMENT ROOT IN CPANEL
# ============================================================
echo "⚠️  IMPORTANT - Check Document Root in cPanel:"
echo "=================================="
echo ""
echo "1. Login to cPanel"
echo "2. Go to: Addon Domains (or Manage Domains)"
echo "3. Find: tdinus.com"
echo "4. Set Document Root to:"
echo "   $APP_DIR/public"
echo ""
echo "5. If you don't see the option, use:"
echo "   /home/tditis693/public_html/public"
echo ""
echo "=================================="
echo ""

# ============================================================
# 7. CREATE .HTACCESS FOR MAIN DIRECTORY
# ============================================================
echo "🔒 Setting up main .htaccess..."

cat > "$APP_DIR/.htaccess" << 'EOF'
# Redirect to public folder
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOF

chmod 644 "$APP_DIR/.htaccess"
echo "✅ Main .htaccess created"
echo ""

# ============================================================
# 8. FINAL CHECKS
# ============================================================
echo "✅ All fixes applied!"
echo ""
echo "📋 Next steps:"
echo "1. Verify document root in cPanel (see above)"
echo "2. Check .env file has correct database"
echo "3. Visit: https://tdinus.com"
echo "4. If error, check: tail -f $APP_DIR/storage/logs/laravel.log"
echo ""
echo "✨ Done!"
