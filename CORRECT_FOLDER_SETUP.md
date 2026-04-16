# 📋 UPDATED INSTRUCTION - LARAVEL DI SUBFOLDER

⚠️ **PENTING:** Laravel berada di `~/public_html/tdinus.com/` bukan di root `~/public_html/`

---

## 📁 STRUKTUR FOLDER ANDA:

```
~/public_html/
├── tdinus.com/           ← ⭐️ LARAVEL BERADA DI SINI
│   ├── public/           ← Web-accessible folder
│   ├── app/
│   ├── artisan
│   ├── composer.json
│   ├── .env
│   ├── storage/
│   ├── bootstrap/
│   ├── routes/
│   └── ... (other files)
└── (other domains/files)
```

---

## 🚀 CORRECTED STEPS - JALANKAN INI:

### STEP 1: Navigate ke Laravel folder

```bash
ssh tdit5693@yourdomain.com
cd ~/public_html/tdinus.com
pwd  # Verify: /home/tdit5693/public_html/tdinus.com
```

---

### STEP 2: Pull dari GitHub

```bash
git pull origin main
```

---

### STEP 3: Jalankan quick-setup.sh

```bash
chmod +x quick-setup.sh
bash quick-setup.sh

# Saat diminta, edit .env:
nano .env
# Update database credentials
# Save: Ctrl+O, Enter, Ctrl+X
```

---

### STEP 4: Jalankan create-htaccess.sh

```bash
# Pastikan masih di folder tdinus.com
pwd  # /home/tdit5693/public_html/tdinus.com

chmod +x create-htaccess.sh
bash create-htaccess.sh
```

---

### STEP 5: Jalankan fix-cpanel.sh

```bash
chmod +x fix-cpanel.sh
bash fix-cpanel.sh
```

---

### STEP 6: Jalankan fix-permissions.sh

```bash
chmod +x fix-permissions.sh
bash fix-permissions.sh
```

---

### STEP 7: Verify Setup

```bash
# Check .htaccess ada
ls -la .htaccess

# Check public folder
ls -la public/

# Check storage
ls -la storage/

# Test database
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# Check logs
tail -20 storage/logs/laravel.log
```

---

## ⚡ SUPER SIMPLE VERSION:

```bash
ssh tdit5693@yourdomain.com
cd ~/public_html/tdinus.com

git pull origin main
chmod +x quick-setup.sh && bash quick-setup.sh
chmod +x create-htaccess.sh && bash create-htaccess.sh
chmod +x fix-cpanel.sh && bash fix-cpanel.sh
chmod +x fix-permissions.sh && bash fix-permissions.sh

echo "✅ Setup complete!"
```

---

## ⚠️ PENTING: SET DOCUMENT ROOT DI CPANEL

**Ini adalah step yang TIDAK bisa dilupakan:**

1. Login ke cPanel
2. Buka: **Addon Domains**
3. Cari: **tdinus.com**
4. Klik **Manage**
5. Set **Document Root** ke:
   ```
   /home/tdit5693/public_html/tdinus.com/public
   ```
   
   ⚠️ **Harus `/public`** bukan `/tdinus.com` atau `/public_html`!

6. Click **Save**
7. Wait 5-10 minutes untuk propagate

---

## ✅ VERIFICATION

Setelah semua langkah:

```bash
# Di terminal
curl -I https://tdinus.com

# Expected output:
# HTTP/1.1 200 OK
# atau redirect ke login page
```

**Di Browser:**
```
https://tdinus.com
```

Seharusnya muncul login page atau welcome page Laravel, bukan error.

---

## 📝 MANUAL COMMANDS (Jika script error)

Jika tidak bisa jalankan script, jalankan manual:

```bash
cd ~/public_html/tdinus.com

# Install deps
composer install --no-dev --optimize-autoloader

# Setup .env
cp .env.example .env
nano .env  # Edit database credentials

# Generate key
php artisan key:generate --force

# Migrate database
php artisan migrate --force

# Create .htaccess
cat > .htaccess << 'EOF'
# php -- BEGIN cPanel-generated handler, do not edit
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
EOF

chmod 644 .htaccess

# Fix permissions
chmod -R 755 storage bootstrap/cache
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Setup storage link
php artisan storage:link

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo "✅ Done!"
```

---

## 🔍 VERIFY STEPS

```bash
# 1. Check location
pwd
# Output: /home/tdit5693/public_html/tdinus.com

# 2. Check .htaccess
ls -la .htaccess
cat .htaccess

# 3. Check Laravel files
ls -la artisan
ls -la public/index.php

# 4. Check .env
cat .env | grep DB_

# 5. Check storage permissions
ls -la storage/ | head -3

# 6. Check bootstrap cache
ls -la bootstrap/cache/ | head -3

# 7. Test database
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# 8. Check logs
tail -f storage/logs/laravel.log
```

---

## 🎯 EXPECTED RESULT

Setelah all steps:

✅ File `.htaccess` ada di `/home/tdit5693/public_html/tdinus.com/.htaccess`  
✅ Database migrations successfully run  
✅ Storage symlink created  
✅ No permission denied errors  
✅ Browser access: https://tdinus.com → Works!  

---

**Jalankan commands di atas dan report hasilnya!** 🚀
