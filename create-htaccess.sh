#!/bin/bash

# ============================================================
# CREATE & UPLOAD .HTACCESS TO CPANEL
# Run this in SSH terminal at: /home/tdit5693/public_html/tdinus.com
# ============================================================

echo "📝 Creating .htaccess in current directory..."
echo ""

# Create .htaccess file
cat > .htaccess << 'HTACCESS_END'
# php -- BEGIN cPanel-generated handler, do not edit
# Set the "ea-php74" package as the default "PHP" programming language.
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php74___lsphp .php .php7 .phtml
</IfModule>
# php -- END cPanel-generated handler, do not edit

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [QSA,L]
</IfModule>
HTACCESS_END

echo "✅ .htaccess file created"
echo ""

# Fix permissions
echo "🔧 Setting permissions..."
chmod 644 .htaccess
echo "✅ Permissions set to 644"
echo ""

# Verify
echo "✅ Verification:"
ls -la .htaccess
echo ""
echo "📋 Content:"
cat .htaccess
echo ""
echo "✅ Done! Try accessing the domain now."
