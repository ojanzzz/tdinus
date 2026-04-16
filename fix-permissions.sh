#!/bin/bash

# ============================================================
# COMPLETE PERMISSIONS & OWNERSHIP FIX
# ============================================================
# Jalankan script ini jika aplikasi sudah di-setup tapi ada error permissions
# Usage: bash fix-permissions.sh

echo "🔧 Fixing all permissions and ownership..."
echo ""

# Get current user and group
CURRENT_USER=$(whoami)
CURRENT_GROUP=$(id -gn)
APP_DIR=$PWD

echo "👤 Current user: $CURRENT_USER"
echo "👥 Current group: $CURRENT_GROUP"
echo "📁 Application directory: $APP_DIR"
echo ""

# ============================================================
# 1. FIX FOLDER PERMISSIONS (755)
# ============================================================

echo "📁 Setting folder permissions to 755..."

chmod 755 "$APP_DIR"
chmod 755 "$APP_DIR/public"
chmod 755 "$APP_DIR/app"
chmod 755 "$APP_DIR/bootstrap"
chmod 755 "$APP_DIR/config"
chmod 755 "$APP_DIR/database"
chmod 755 "$APP_DIR/routes"
chmod 755 "$APP_DIR/storage"

# Set all subdirectories to 755
find "$APP_DIR" -type d -exec chmod 755 {} \;

echo "✅ Folder permissions set"
echo ""

# ============================================================
# 2. FIX FILE PERMISSIONS (644)
# ============================================================

echo "📄 Setting file permissions to 644..."

find "$APP_DIR" -type f ! -name "*.sh" -exec chmod 644 {} \;

echo "✅ File permissions set"
echo ""

# ============================================================
# 3. FIX STORAGE FOLDER SPECIAL PERMISSIONS
# ============================================================

echo "🗂️  Setting storage folder permissions..."

chmod -R 755 "$APP_DIR/storage"
find "$APP_DIR/storage" -type f -exec chmod 644 {} \;

# Make sure framework subdirectories are accessible
chmod 755 "$APP_DIR/storage/framework"
chmod 755 "$APP_DIR/storage/framework/sessions"
chmod 755 "$APP_DIR/storage/framework/cache"
chmod 755 "$APP_DIR/storage/framework/views"

# Make sure logs is writable
chmod 755 "$APP_DIR/storage/logs"

echo "✅ Storage permissions set"
echo ""

# ============================================================
# 4. FIX BOOTSTRAP CACHE
# ============================================================

echo "♻️  Setting bootstrap cache permissions..."

chmod -R 755 "$APP_DIR/bootstrap/cache"
find "$APP_DIR/bootstrap/cache" -type f -exec chmod 644 {} \;

echo "✅ Bootstrap cache permissions set"
echo ""

# ============================================================
# 5. FIX PUBLIC FOLDER
# ============================================================

echo "🌐 Setting public folder permissions..."

chmod 755 "$APP_DIR/public"
find "$APP_DIR/public" -type d -exec chmod 755 {} \;
find "$APP_DIR/public" -type f -exec chmod 644 {} \;

# Public uploads should be writable
if [ -d "$APP_DIR/public/uploads" ]; then
    chmod 755 "$APP_DIR/public/uploads"
fi

if [ -d "$APP_DIR/public/storage" ]; then
    chmod 755 "$APP_DIR/public/storage"
fi

echo "✅ Public folder permissions set"
echo ""

# ============================================================
# 6. FIX ARTISAN AND SCRIPTS
# ============================================================

echo "🔨 Setting script permissions..."

chmod 755 "$APP_DIR/artisan"

# Make all shell scripts executable
find "$APP_DIR" -name "*.sh" -type f -exec chmod 755 {} \;

echo "✅ Script permissions set"
echo ""

# ============================================================
# 7. VERIFY KEY FILES
# ============================================================

echo "✅ Verifying key files..."

files=(
    "artisan"
    "public/index.php"
    "composer.json"
    ".env"
    "storage"
    "bootstrap"
)

for file in "${files[@]}"; do
    if [ -e "$APP_DIR/$file" ]; then
        echo "  ✅ $file"
    else
        echo "  ⚠️  $file - NOT FOUND"
    fi
done

echo ""

# ============================================================
# 8. FIX OWNERSHIP IF NEEDED
# ============================================================

echo "👥 Checking ownership..."

# Only try to change ownership if user has permission
if [ "$CURRENT_USER" != "root" ]; then
    echo "ℹ️  Running as user: $CURRENT_USER"
    echo "ℹ️  Not changing ownership (requires root or cPanel)"
else
    echo "📝 Changing ownership to: $CURRENT_USER:$CURRENT_GROUP"
    chown -R "$CURRENT_USER:$CURRENT_GROUP" "$APP_DIR"
    echo "✅ Ownership updated"
fi

echo ""

# ============================================================
# FINAL VERIFICATION
# ============================================================

echo "═══════════════════════════════════════════════════"
echo "FILES PERMISSIONS VERIFICATION"
echo "═══════════════════════════════════════════════════"
echo ""

echo "Folders (should be 755):"
ls -ld "$APP_DIR" | awk '{print $1, $NF}'
ls -ld "$APP_DIR/storage" | awk '{print $1, $NF}'
ls -ld "$APP_DIR/bootstrap/cache" | awk '{print $1, $NF}'

echo ""
echo "Files (should be 644):"
ls -l "$APP_DIR/.env" | awk '{print $1, $NF}'
ls -l "$APP_DIR/artisan" | awk '{print $1, $NF}'
ls -l "$APP_DIR/public/index.php" | awk '{print $1, $NF}'

echo ""
echo "═══════════════════════════════════════════════════"
echo ""

echo "✅ All permissions fixed!"
echo ""
echo "If you still get permission errors:"
echo ""
echo "1️⃣  Make sure web server has access:"
echo "   chmod -R a+r storage/"
echo "   chmod -R a+w storage/"
echo ""
echo "2️⃣  Check web server user (usually www-data, nobody, or apache):"
echo "   ps aux | grep -E 'apache|nginx|www-data'"
echo ""
echo "3️⃣  If using cPanel with suPHP or php-fpm:"
echo "   Make sure files are owned by your cPanel user"
echo ""
