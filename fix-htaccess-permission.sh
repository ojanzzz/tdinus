#!/bin/bash

# ============================================================
# FIX HTACCESS PERMISSION ERROR DI CPANEL
# ============================================================
# Error: Failed to open [/home/tdit5693/public_html/tdinus.com/.htaccess]: Permission denied

echo "🔧 Fixing .htaccess permission error..."
echo ""

# Set correct username (sesuaikan dengan akun cPanel Anda)
CPANEL_USER="tdit5693"
HOME_DIR="/home/$CPANEL_USER"
TDINUS_DIR="$HOME_DIR/public_html/tdinus.com"

echo "👤 cPanel User: $CPANEL_USER"
echo "📁 Directory: $TDINUS_DIR"
echo ""

# ============================================================
# 1. FIX .HTACCESS PERMISSION
# ============================================================

echo "📄 Fixing .htaccess permissions..."

# Navigate to directory
if [ ! -d "$TDINUS_DIR" ]; then
    echo "❌ Error: Directory not found: $TDINUS_DIR"
    echo ""
    echo "💡 Try these commands manually instead:"
    echo "   ssh $CPANEL_USER@yourdomain.com"
    echo "   cd ~/public_html/tdinus.com"
    echo "   ls -la .htaccess"
    exit 1
fi

cd "$TDINUS_DIR"

# Check if .htaccess exists
if [ ! -f ".htaccess" ]; then
    echo "❌ .htaccess file not found in $TDINUS_DIR"
    exit 1
fi

# Fix permissions
chmod 644 .htaccess
echo "✅ .htaccess permissions set to 644"

# ============================================================
# 2. FIX OWNERSHIP
# ============================================================

echo ""
echo "👥 Fixing ownership..."

# Check current ownership
OWNER=$(stat -c '%U:%G' .htaccess 2>/dev/null || stat -f '%Su:%Sg' .htaccess 2>/dev/null)
echo "Current owner: $OWNER"

# If we're root, fix ownership to cPanel user
if [ "$EUID" -eq 0 ]; then
    chown $CPANEL_USER:$CPANEL_USER .htaccess
    echo "✅ Ownership changed to $CPANEL_USER:$CPANEL_USER"
else
    echo "⚠️  Not running as root"
    echo "💡 If error persists, run with sudo:"
    echo "   sudo chown $CPANEL_USER:$CPANEL_USER .htaccess"
fi

# ============================================================
# 3. VERIFY FIX
# ============================================================

echo ""
echo "✅ Verification:"
ls -la .htaccess

echo ""
echo "✅ Fixed! Try accessing the domain now."
echo ""
echo "If error still persists:"
echo "1. Contact your hosting provider"
echo "2. They may need to fix permissions at server level"
echo "3. Or check if LiteSpeed/Apache is running with correct user"
