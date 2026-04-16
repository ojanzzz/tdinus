# 🚀 SETUP TDINUS.COM DI CPANEL - PANDUAN LENGKAP

## Situasi Saat Ini (Dari Screenshot cPanel)
Anda memiliki struktur:
```
/home/tditis693/
├── public_html/          ← Root domain
│   ├── tdinus.com/       ← Addon domain folder
│   ├── .htaccess
│   ├── index.html
│   └── ...
└── (other domains)
```

Domain `tdinus.com` adalah **addon domain** yang perlu di-setup dengan benar.

---

## ✅ LANGKAH-LANGKAH SETUP

### STEP 1️⃣ - Pastikan Aplikasi Sudah di Tempat yang Benar

**Opsi A: TDINUS di root public_html** (Recommended)
```bash
ssh username@host
cd ~/public_html

# Clone atau copy aplikasi ke sini
git clone git@github.com:yourusername/tdinus.git .

# Atau jika sudah ada
cd ~/public_html
git pull origin main
```

**Opsi B: TDINUS di subfolder**
```bash
ssh username@host
cd ~/public_html

# Clone ke subfolder
git clone git@github.com:yourusername/tdinus.git tdinus
cd tdinus
```

---

### STEP 2️⃣ - Setup Document Root di cPanel

#### Untuk Addon Domain (tdinus.com):

1. **Login ke cPanel**
2. Buka **Addon Domains**
3. Cari atau buat **tdinus.com**
4. **Set Document Root** ke salah satu dari:
   
   **Jika TDINUS di root public_html:**
   ```
   /home/tditis693/public_html/public
   ```
   
   **Jika TDINUS di subfolder:**
   ```
   /home/tditis693/public_html/tdinus/public
   ```

5. **PENTING:** Letakkan di folder `/public`, BUKAN root aplikasi!

6. Klik **Save** / **Add Domain**

---

### STEP 3️⃣ - Jalankan Fix Script

```bash
ssh username@host
cd ~/public_html

# Jika masih di struktur saat installation
chmod +x fix-cpanel.sh
./fix-cpanel.sh
```

Script ini akan:
- ✅ Set folder permissions
- ✅ Create storage symlink
- ✅ Verify .htaccess
- ✅ Create artisan wrapper
- ✅ Setup redirects

---

### STEP 4️⃣ - Configure .env

```bash
nano .env
```

**Pastikan sesuai dengan server cPanel:**
```env
APP_NAME="Teras Digital Nusantara"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tdinus.com

# Database (sesuaikan dengan cPanel MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tdinu_db
DB_USERNAME=tdinu_user
DB_PASSWORD=<your_secure_password>

# Session & Security
SESSION_DRIVER=database
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
```

---

### STEP 5️⃣ - Jalankan Deployment

```bash
ssh username@host
cd ~/public_html

chmod +x deploy.sh
./deploy.sh
```

atau manual:

```bash
cd ~/public_html

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate key
php artisan key:generate --force

# Database setup
php artisan migrate --force

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:cache
php artisan view:cache

# Symlink storage
php artisan storage:link

# Optimize
php artisan optimize
```

---

### STEP 6️⃣ - Verifikasi & Test

```bash
# Cek apakah aplikasi berjalan
php artisan tinker

# Test database
>>> DB::connection()->getPdo();
>>> exit
```

**Atau buka di browser:**
```
https://tdinus.com
```

---

## 🔍 Troubleshooting

### Masalah: "Not Found" atau "404"

**Solusi 1:** Cek Document Root di cPanel
```bash
# Pastikan document root menunjuk ke folder /public
# Bukan ke root aplikasi
```

**Solusi 2:** Verify .htaccess
```bash
# Pastikan public/.htaccess ada
ls -la ~/public_html/public/.htaccess

# Jika tidak ada, jalankan
cd ~/public_html
./fix-cpanel.sh
```

**Solusi 3:** Verify index.php
```bash
# Pastikan index.php ada
ls -la ~/public_html/public/index.php
```

---

### Masalah: "500 Internal Server Error"

**Check logs:**
```bash
tail -f ~/public_html/storage/logs/laravel.log
```

**Kemungkinan penyebab & solusi:**

1. **Database connection error**
   ```bash
   # Cek credentials di .env
   nano .env
   
   # Test koneksi
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

2. **File permission error**
   ```bash
   chmod -R 755 ~/public_html/storage
   chmod -R 755 ~/public_html/bootstrap/cache
   ```

3. **Missing dependencies**
   ```bash
   compositor install --no-dev
   ```

---

### Masalah: "Composer not found"

**Install Composer di cPanel:**
```bash
cd ~
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=bin --filename=composer
php bin/composer --version
```

Gunakan:
```bash
php ~/bin/composer install
```

---

### Masalah: "Cannot write to storage"

```bash
# Fix permissions
chmod -R 755 ~/public_html/storage
chmod -R 755 ~/public_html/bootstrap/cache

# Atau gunakan
find ~/public_html/storage -type d -exec chmod 755 {} \;
find ~/public_html/storage -type f -exec chmod 644 {} \;
```

---

## 📋 Checklist Final

- [ ] Aplikasi sudah di-clone/di-pull ke cPanel
- [ ] Document root menunjuk ke folder `/public`
- [ ] .env file sudah dikonfigurasi
- [ ] Database sudah dibuat dan credentials benar
- [ ] Permissions sudah di-set (755 untuk folders, 644 untuk files)
- [ ] .htaccess sudah ada di public/
- [ ] Composer dependencies sudah di-install
- [ ] Migrations sudah di-run
- [ ] Storage symlink sudah di-create
- [ ] domain tdinus.com bisa diakses https://tdinus.com

---

## 🔗 Penting: Document Root Setting di cPanel

**JANGAN:**
```
❌ /home/tditis693/public_html
❌ /home/tditis693/public_html/
❌ /home/tditis693/public_html/tdinus
```

**HARUS:**
```
✅ /home/tditis693/public_html/public
atau
✅ /home/tditis693/public_html/tdinus/public
```

**Mengapa?** Karena Laravel hanya expose folder `public/` ke internet. File konfigurasi, database, dan file sensitif lainnya tinggal di luar folder `public/` dan aman.

---

## 🆘 Jika Masih Error

**Cek error log terperinci:**
```bash
tail -50 ~/public_html/storage/logs/laravel.log
```

**Cek file structure:**
```bash
ls -la ~/public_html/
ls -la ~/public_html/public/

# Pastikan ada:
# - .env
# - artisan
# - app/
# - bootstrap/
# - config/
# - database/
# - routes/
# - vendor/
# - public/index.php
```

**Test PHP execution:**
```bash
php -v
php -m | grep -E 'mysqli|pdo'
```

---

## 📞 Support Commands

```bash
# SSH ke server
ssh username@yourdomain.com

# Lihat file laravel
ls -la ~/public_html/

# Lihat logs realtime
tail -f ~/public_html/storage/logs/laravel.log

# Test database
php ~/public_html/artisan tinker

# Clear cache
php ~/public_html/artisan cache:clear

# Generate key
php ~/public_html/artisan key:generate

# Run migrations
php ~/public_html/artisan migrate --force
```

---

**Last Updated:** April 16, 2026  
**Status:** Ready for Production
