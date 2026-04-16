# 🚀 PANDUAN MENJALANKAN SCRIPTS - TDINUS

Dokumentasi lengkap cara menjalankan semua `.sh` scripts untuk setup TDINUS di cPanel.

---

## 📋 DAFTAR SCRIPTS

| Script | Fungsi | Waktu | Priority |
|--------|--------|-------|----------|
| `quick-setup.sh` | Setup awal (install deps, migrate) | 3-5 min | ⭐⭐⭐ |
| `create-htaccess.sh` | Buat file .htaccess | 1 min | ⭐⭐⭐ |
| `fix-cpanel.sh` | Fix khusus cPanel issues | 2 min | ⭐⭐ |
| `fix-permissions.sh` | Fix permission errors | 1 min | ⭐⭐ |
| `fix-htaccess-permission.sh` | Fix .htaccess permission | 1 min | ⭐ |

---

## 🎯 RUNDOWN SETUP - JALANKAN DALAM URUTAN INI

### STEP 1: Clone Aplikasi (SUDAH BISA SKIP JIKA SUDAH CLONE)

```bash
# SSH ke cPanel
ssh tdit5693@yourdomain.com

# Go to root
cd ~/public_html

# Clone atau pull
git clone git@github.com:yourusername/tdinus.git .
# atau
git pull origin main

# Verify
ls -la artisan
ls -la .env.example
```

---

### STEP 2: Jalankan quick-setup.sh ⭐⭐⭐ (PRIORITY UTAMA)

**Apa yang dilakukan:**
- ✅ Install composer dependencies
- ✅ Create .env dari .env.example
- ✅ Generate APP_KEY
- ✅ Run database migrations
- ✅ Clear cache
- ✅ Setup storage

**Cara jalankan:**

```bash
# Still in ~/public_html directory
chmod +x quick-setup.sh
bash quick-setup.sh
```

**Apa yang akan diminta:**
```
⚠️  IMPORTANT: Edit .env with your cPanel database credentials!
Press Enter after editing .env (or skip if already configured)...
```

**Saat diminta, buka terminal baru (atau pause script):**
```bash
# Terminal baru
nano .env

# Edit:
DB_HOST=127.0.0.1
DB_DATABASE=tdinu_db          # Sesuaikan dengan cPanel
DB_USERNAME=tdinu_user        # Sesuaikan dengan cPanel
DB_PASSWORD=your_password     # Sesuaikan dengan cPanel

# Save (Ctrl+O, Enter, Ctrl+X)
```

**Kembali ke script, tekan Enter untuk lanjut.**

---

### STEP 3: Jalankan create-htaccess.sh ⭐⭐⭐ (CRITICAL)

**Apa yang dilakukan:**
- ✅ Create .htaccess file di folder tdinus.com/
- ✅ Set correct permissions (644)
- ✅ Verify file berhasil dibuat

**Cara jalankan:**

```bash
# Navigate ke tdinus.com folder
cd ~/public_html/tdinus.com

# Verify lokasi
pwd
# Output seharusnya: /home/tdit5693/public_html/tdinus.com

# Make script executable
chmod +x create-htaccess.sh

# Run script
bash create-htaccess.sh
```

**Expected output:**
```
✅ .htaccess file created
✅ Permissions set to 644
✅ Verification:
-rw-r--r-- 1 tdit5693 tdit5693 123 Apr 16 10:31 .htaccess
```

---

### STEP 4: Jalankan fix-cpanel.sh ⭐⭐ (RECOMMENDED)

**Apa yang dilakukan:**
- ✅ Set folder permissions (755, 644)
- ✅ Create storage symlink
- ✅ Verify .htaccess
- ✅ Create artisan wrapper
- ✅ Setup redirects

**Cara jalankan:**

```bash
# Back to root folder
cd ~/public_html

# Make executable
chmod +x fix-cpanel.sh

# Run
bash fix-cpanel.sh
```

**Expected output:**
```
✅ Permissions fixed
✅ Storage symlink created
✅ .htaccess exists
✅ Main .htaccess created
✅ All fixes applied!
```

---

### STEP 5: Jalankan fix-permissions.sh ⭐⭐ (RECOMMENDED)

**Apa yang dilakukan:**
- ✅ Set all folder permissions (755)
- ✅ Set all file permissions (644)
- ✅ Fix storage permissions
- ✅ Fix bootstrap cache permissions
- ✅ Make scripts executable

**Cara jalankan:**

```bash
# Still in ~/public_html
chmod +x fix-permissions.sh

# Run
bash fix-permissions.sh
```

**Expected output:**
```
✅ Folder permissions set
✅ File permissions set
✅ Storage permissions set
✅ Bootstrap cache permissions set
✅ All permissions fixed!
```

---

### STEP 6: Fix .htaccess Permission (Jika Ada Error)

**HANYA jalankan jika ada error permission denied**

```bash
# Navigate to tdinus.com
cd ~/public_html/tdinus.com

# Make script executable
chmod +x fix-htaccess-permission.sh

# Run
bash fix-htaccess-permission.sh
```

---

## ⚡ QUICK COMMAND - COPY PASTE SEMUA SEKALIGUS

Jika ingin langsung copy-paste tanpa penjelasan:

```bash
# 1. SSH
ssh tdit5693@yourdomain.com

# 2. Navigate
cd ~/public_html

# 3. Pull latest
git pull origin main

# 4. Quick setup
chmod +x quick-setup.sh
bash quick-setup.sh
# ⚠️  PAUSE: Edit .env when prompted

# 5. Create htaccess
cd tdinus.com
chmod +x create-htaccess.sh
bash create-htaccess.sh
cd ..

# 6. Fix cPanel
chmod +x fix-cpanel.sh
bash fix-cpanel.sh

# 7. Fix permissions
chmod +x fix-permissions.sh
bash fix-permissions.sh

# 8. Done!
echo "✅ Setup complete!"
```

---

## 🔍 MANUAL COMMANDS - Jika Script Tidak Bisa Dijalankan

Jika `.sh` files tidak bisa dijalankan, jalankan command-nya manual:

```bash
# === Setup Awal ===
cd ~/public_html
composer install --no-dev --optimize-autoloader
cp .env.example .env
nano .env    # Edit database credentials
php artisan key:generate --force
php artisan migrate --force
php artisan cache:clear

# === Create .htaccess ===
cd tdinus.com
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
cd ..

# === Fix Permissions ===
chmod 755 .
chmod -R 755 storage bootstrap/cache
find . -type f -exec chmod 644 {} \;
php artisan storage:link

# === Optimize ===
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## ✅ VERIFICATION - Setelah Semua Script Selesai

```bash
# 1. Check .htaccess
ls -la ~/public_html/tdinus.com/.htaccess
cat ~/public_html/tdinus.com/.htaccess

# 2. Check permissions
ls -la ~/public_html/storage/ | head -5
ls -la ~/public_html/bootstrap/cache/

# 3. Test database
cd ~/public_html
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# 4. Check logs
tail -20 ~/public_html/storage/logs/laravel.log

# 5. Test domain
curl -I https://tdinus.com
```

---

## 🆘 TROUBLESHOOTING

### Error: "Permission denied" saat chmod

**Solusi:**
```bash
# Use sudo if available
sudo chmod +x script.sh
sudo bash script.sh

# Atau jalankan manual commands saja
```

### Error: "Script not found" atau "bad interpreter"

**Solusi:**
```bash
# Update line endings (Windows to Unix)
dos2unix script.sh

# Or create script manually:
bash create-htaccess.sh  # Instead of ./create-htaccess.sh
```

### Error: "composer: command not found"

**Solusi:**
```bash
# Use PHP composer
php ~/.composer/composer.phar install --no-dev

# Or use full path
/usr/local/bin/composer install --no-dev
```

---

## 📊 EXECUTION FLOW DIAGRAM

```
START
  ↓
[1] SSH to cPanel
  ↓
[2] Clone/Pull GitHub
  ↓
[3] Run: quick-setup.sh ← CRITICAL (install + migrate + cache)
  ↓
[4] Edit .env (database credentials)
  ↓
[5] Run: create-htaccess.sh ← CRITICAL (create .htaccess)
  ↓
[6] Run: fix-cpanel.sh (symlinks + redirects)
  ↓
[7] Run: fix-permissions.sh (folder permissions)
  ↓
[8] Verify: curl https://tdinus.com
  ↓
[9] SUCCESS ✅
```

---

## 📝 RECOMMENDED EXECUTION ORDER

### FIRST TIME SETUP:
1. ✅ quick-setup.sh
2. ✅ create-htaccess.sh
3. ✅ fix-cpanel.sh
4. ✅ fix-permissions.sh

### UPDATE FROM GITHUB:
1. ✅ git pull origin main
2. ✅ php artisan migrate --force
3. ✅ php artisan optimize

### TROUBLESHOOTING:
1. ✅ fix-permissions.sh
2. ✅ fix-cpanel.sh
3. ✅ fix-htaccess-permission.sh (if needed)

---

## 🎓 WHAT EACH SCRIPT DOES

### quick-setup.sh
```bash
# Install composer deps
composer install --no-dev --optimize-autoloader

# Setup environment
cp .env.example .env

# Generate key
php artisan key:generate --force

# Run migrations (database setup)
php artisan migrate --force

# Clear cache
php artisan config:clear
php artisan cache:clear

# Setup storage
php artisan storage:link

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### create-htaccess.sh
```bash
# Create .htaccess file with content

# Set permissions
chmod 644 .htaccess

# Verify
ls -la .htaccess
cat .htaccess
```

### fix-cpanel.sh
```bash
# Set permissions
chmod 755 storage bootstrap/cache

# Create symlinks
ln -s storage/app/public public/storage

# Verify .htaccess
# Create wrappers
# Setup redirects
```

### fix-permissions.sh
```bash
# Set all folders to 755
find . -type d -exec chmod 755 {} \;

# Set all files to 644
find . -type f -exec chmod 644 {} \;

# Fix special permissions for storage/bootstrap
chmod -R 755 storage bootstrap/cache
```

---

**Status:** Ready to Execute  
**Total Time:** ~15-20 minutes  
**Difficulty:** Easy - Just copy & paste commands

Coba jalankan sekarang dan report jika ada error! 🚀
