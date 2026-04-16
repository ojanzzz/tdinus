# 📋 TDINUS - Panduan Deployment di cPanel

## Prasyarat
- SSH Access ke cPanel
- PHP 8.3+
- MySQL/MariaDB
- Composer sudah terinstall
- Git sudah terinstall

## Langkah-Langkah Deployment

### 1. **Akses Server via SSH**
```bash
ssh username@yourdomain.com
cd public_html  # atau folder yang sesuai dengan struktur cPanel Anda
```

### 2. **Clone Repository GitHub**
```bash
# Jika belum ada project di folder
git clone git@github.com:yourusername/tdinus.git .

# Atau jika sudah ada, lakukan pull
git pull origin main
```

### 3. **Setup Database di cPanel**
- Login ke cPanel
- Buka **MySQL Databases**
- Buat database baru: `tdinus_db`
- Buat user baru: `tdinus_user`
- Assign user ke database dengan all privileges
- Catat username dan password

### 4. **Configure .env File**
```bash
cp .env.example .env
nano .env  # atau editor lain
```

**Update bagian database:**
```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tdinus_db
DB_USERNAME=tdinus_user
DB_PASSWORD=your_secure_password
APP_URL=https://yourdomain.com
APP_DEBUG=false
APP_ENV=production
```

### 5. **Jalankan Deploy Script**
```bash
chmod +x deploy.sh
./deploy.sh
```

Script ini akan secara otomatis:
- ✅ Set folder permissions
- ✅ Install Composer dependencies
- ✅ Generate APP_KEY
- ✅ Clear cache
- ✅ Run migrations
- ✅ Optimize application

### 6. **Verifikasi Deployment**
```bash
# Check PHP artisan works
php artisan --version

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> quit
```

### 7. **Configure Web Root di cPanel**
- Login ke cPanel
- Buka **Addon Domains** atau **Document Root**
- Set document root ke: `/home/username/public_html/public`
- (Pastikan pointing ke folder `public/` bukan root!)

### 8. **Setup SSL Certificate**
- Di cPanel, gunakan **AutoSSL** atau **Let's Encrypt**
- Pastikan domain yang digunakan sudah ter-setup dengan SSL

## Troubleshooting

### Error: "Composer not found"
```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

### Error: "Permission denied" pada storage folder
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### Error: "Could not open input file: artisan"
```bash
# Pastikan berada di root folder project
pwd  # should show: .../public_html
ls -la  # harus ada file artisan
```

### Error: "SQLSTATE[HY000] [1045]"
```bash
# Cek database credentials di .env
# Verifikasi user dapat akses database di cPanel
php artisan tinker
>>> DB::connection()->getPdo();
```

### Error: "No such file or directory: .git"
```bash
# Initialize git repository
git init
git remote add origin git@github.com:yourusername/tdinus.git
git fetch origin
git checkout -b main origin/main
```

## Update/Pull Latest Changes

```bash
# Pull latest code
git pull origin main

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Run new migrations jika ada
php artisan migrate --force

# Optimize
php artisan optimize
```

## Monitoring & Logs

```bash
# View recent logs
tail -f storage/logs/laravel.log

# Check application health
php artisan about

# Queue status
php artisan queue:failed

# Clear failed jobs
php artisan queue:flush
```

## Security Checklist

- [ ] `.env` file tidak ter-upload ke GitHub (check `.gitignore`)
- [ ] `APP_DEBUG=false` di production
- [ ] `APP_ENV=production` di production
- [ ] SSL/HTTPS sudah aktif
- [ ] Database password strong dan aman
- [ ] Storage folder tidak accessible dari web
- [ ] Regular backups dilakukan

## Important Files & Folders

| File/Folder | Deskripsi | Permission |
|---|---|---|
| `.env` | Environment configuration | 644 |
| `storage/` | Logs, sessions, uploads | 755 |
| `bootstrap/cache/` | Application cache | 755 |
| `public/` | Web accessible folder | 755 |
| `public/uploads/` | User uploads | 755 |

## Support & Documentation

- Laravel Docs: https://laravel.com/docs
- cPanel Docs: https://documentation.cpanel.net/
- GitHub SSH Setup: https://docs.github.com/en/authentication/connecting-to-github-with-ssh

---
Last Updated: April 16, 2026
