# 📋 SETUP CHECKLIST - TDINUS.COM DI CPANEL

Ikuti checklist ini saat setup tdinus.com di cPanel untuk memastikan aplikasi berjalan dengan sukses.

## ✅ PRE-DEPLOYMENT (Lokal - Selesai)

- [x] Aplikasi Laravel sudah dibuat
- [x] SSH keys sudah generated untuk GitHub
- [x] File-file setup sudah ready:
  - deploy.sh
  - fix-cpanel.sh
  - quick-setup.sh
  - fix-permissions.sh

---

## ✅ DEPLOYMENT CHECKLIST - CPANEL

### PHASE 1: SSH & CLONE (5 menit)

- [ ] **Login SSH ke cPanel**
  ```bash
  ssh username@yourdomain.com
  cd ~/public_html
  ```

- [ ] **Clone atau Pull Aplikasi**
  ```bash
  # Clone baru
  git clone git@github.com:yourusername/tdinus.git .
  
  # Atau update existing
  git pull origin main
  ```

- [ ] **Verifikasi file ada**
  ```bash
  # Pastikan ada file berikut
  ls -la artisan
  ls -la public/index.php
  ls -la .env.example
  ```

---

### PHASE 2: Setup Awal (5 menit)

- [ ] **Jalankan Quick Setup Script**
  ```bash
  chmod +x quick-setup.sh
  bash quick-setup.sh
  ```

- [ ] **Atau Manual Setup**
  ```bash
  composer install --no-dev --optimize-autoloader
  cp .env.example .env
  php artisan key:generate --force
  php artisan migrate --force
  ```

---

### PHASE 3: Configure cPanel (5 menit)

**CRITICAL - Ini adalah bagian paling penting!**

- [ ] **Login ke cPanel**

- [ ] **Buka: Addon Domains**

- [ ] **Cari atau Buat: tdinus.com**

- [ ] **SET DOCUMENT ROOT KE:**
  ```
  /home/tditis693/public_html/public
  ```
  ⚠️  Perhatian: Harus menunjuk ke folder `/public`, bukan root!

- [ ] **Klik Save/Add Domain**

- [ ] **Klik Manage (jika ada)**

- [ ] **Verifikasi Document Root sudah benar**

---

### PHASE 4: Environment Configuration (5 menit)

- [ ] **Edit .env file**
  ```bash
  nano .env
  ```

- [ ] **Update nilai berikut:**
  ```env
  APP_NAME="Teras Digital Nusantara"
  APP_ENV=production
  APP_DEBUG=false
  APP_URL=https://tdinus.com
  
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_DATABASE=tdinu_db        # Sesuaikan dengan cPanel Anda
  DB_USERNAME=tdinu_user      # Sesuaikan dengan cPanel Anda
  DB_PASSWORD=your_password   # Sesuaikan dengan cPanel Anda
  ```

- [ ] **Save file** (Ctrl+O, Enter, Ctrl+X untuk nano)

---

### PHASE 5: Database Setup (10 menit)

- [ ] **Create Database di cPanel**
  - Login cPanel → MySQL Databases
  - Database Name: `tdinu_db`
  - User: `tdinu_user`
  - Password: (generate strong password)
  - Privileges: All

- [ ] **Update .env dengan credentials yang tepat**

- [ ] **Verifikasi Koneksi**
  ```bash
  php artisan tinker
  >>> DB::connection()->getPdo();
  >>> exit
  ```

---

### PHASE 6: Permissions & Final Setup (5 menit)

- [ ] **Fix Permissions**
  ```bash
  chmod +x fix-permissions.sh
  bash fix-permissions.sh
  ```

- [ ] **Atau Manual**
  ```bash
  chmod -R 755 storage bootstrap/cache
  chmod 755 public
  ```

- [ ] **Create Storage Link**
  ```bash
  php artisan storage:link
  ```

- [ ] **Final Optimization**
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan optimize
  ```

---

### PHASE 7: Verification (10 menit)

- [ ] **Test di Browser**
  ```
  https://tdinus.com
  ```

- [ ] **Aplikasi tampil normal** (tidak error)

- [ ] **Check Logs jika ada error**
  ```bash
  tail -f storage/logs/laravel.log
  ```

---

## ❌ TROUBLESHOOTING - Jika Ada Masalah

### Masalah: "Not Found" atau "404"

**Cek 1: Document Root**
```bash
# Di cPanel, verifikasi document root menunjuk ke /public
# Buka cPanel → Addon Domains → tdinus.com
# Document Root harus: /home/tditis693/public_html/public
```

**Cek 2: .htaccess**
```bash
# Pastikan .htaccess ada
ls -la public/.htaccess

# Check contents
cat public/.htaccess
```

**Cek 3: Permissions**
```bash
# Pastikan readable
ls -la public/index.php

# Output seharusnya: -rw-r--r--
```

---

### Masalah: "500 Internal Server Error"

**Check logs:**
```bash
tail -20 storage/logs/laravel.log
```

**Kemungkinan penyebab:**

1. **Database tidak terkoneksi**
   ```bash
   # Cek .env credentials
   nano .env
   
   # Cek koneksi
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

2. **File permissions salah**
   ```bash
   bash fix-permissions.sh
   ```

3. **Missing dependency**
   ```bash
   composer install --no-dev
   ```

4. **Outdated cache**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan optimize:clear
   ```

---

### Masalah: "Connection refused" pada database

```bash
# Cek credentials di .env
grep DB_ .env

# Test manual
mysql -h 127.0.0.1 -u tdinu_user -p tdinu_db
# Masukkan password
# Ketik: exit
```

---

### Masalah: "Permission denied" pada storage

```bash
# Fix dengan script
bash fix-permissions.sh

# Atau manual
chmod -R 755 storage bootstrap/cache
```

---

## 📞 QUICK COMMAND REFERENCE

```bash
# View logs
tail -f storage/logs/laravel.log

# Test artisan
php artisan --version

# Test database
php artisan tinker

# Clear cache
php artisan config:clear

# Run migrations
php artisan migrate --force

# Check storage link
ls -la public/storage
```

---

## ✅ SUCCESS CHECKLIST - App Harus:

- [x] Responsive saat di-akses via browser
- [x] Database terkoneksi
- [x] Tidak ada error di terminal
- [x] Assets (CSS/JS) loading dengan benar
- [x] Login page muncul dan bisa diakses
- [x] Logs tidak penuh dengan error

---

## 📝 NEXT STEPS SETELAH SETUP

1. **Update DNS** - Pointing tdinus.com ke server cPanel
2. **Setup SSL** - Gunakan AutoSSL di cPanel untuk HTTPS
3. **Configure Email** - Setup mail settings di .env
4. **Regular Backups** - Setup backup strategy
5. **Monitor Logs** - Check logs secara berkala

---

## 🆘 STUCK? GABUNG STEP PENTING

Jika masih error, execute commands berikut IN ORDER:

```bash
# 1. Make sure in correct directory
pwd  # output: .../public_html

# 2. Pull latest
git pull origin main

# 3. Install deps
composer install --no-dev --optimize-autoloader

# 4. Setup env
cp .env.example .env
nano .env  # Edit dengan correct database credentials

# 5. Generate key
php artisan key:generate --force

# 6. Clear everything
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 7. Run migrations
php artisan migrate --force

# 8. Fix permissions
bash fix-permissions.sh

# 9. Create storage link
php artisan storage:link

# 10. Optimize
php artisan optimize

# 11. Check logs
tail -f storage/logs/laravel.log
```

---

**Last Updated:** April 16, 2026  
**Status:** Production Ready  
**Estimated Setup Time:** 30-45 minutes
