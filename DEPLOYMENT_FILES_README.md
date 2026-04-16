# 🚀 FILES & SCRIPTS - SETUP GUIDE

Dokumentasi complete tentang semua file yang sudah di-generate untuk setup TDINUS.COM di cPanel.

---

## 📁 FILE STRUKTUR

```
tdinus/
├── 📄 SETUP_CHECKLIST.md          ← ⭐ START HERE! Checklist lengkap
├── 📄 CPANEL_SETUP_GUIDE.md       ← Panduan detail step-by-step
├── 📄 DEPLOYMENT.md               ← Info tentang deployment umum
├── 📄 DEPLOYMENT_FILES_README.md  ← File ini - dokumentasi lengkap
│
├── 🔧 SCRIPTS UNTUK CPANEL:
├── ├── quick-setup.sh             ← ⭐ JALANKAN INI TERLEBIH DAHULU
├── ├── fix-cpanel.sh              ← Perbaiki masalah cPanel
├── ├── fix-permissions.sh         ← Fix permission errors
├── ├── deploy.sh                  ← Full deployment script
│
├── 🔐 CONFIG FILES:
├── ├── .htaccess                  ← Sudah ada di public/
├── ├── .htaccess.backup           ← Backup original
├── ├── .htaccess.alternative      ← Jika root .htaccess perlu
│
└── 📚 SETUP FILES:
    ├── start.sh                   ← Development setup
    └── hooks/post-receive.example ← Git auto-deploy
```

---

## 🎯 CARA MENGGUNAKAN FILE-FILE INI

### UNTUK SETUP PERTAMA DI CPANEL:

**Step 1: Baca Panduan**
```bash
cat SETUP_CHECKLIST.md
```

**Step 2: SSH ke cPanel**
```bash
ssh username@yourdomain.com
cd ~/public_html
```

**Step 3: Clone Aplikasi**
```bash
git clone git@github.com:yourusername/tdinus.git .
```

**Step 4: Jalankan Setup Script**
```bash
chmod +x quick-setup.sh
bash quick-setup.sh
```

**Step 5: Configure .env**
```bash
nano .env
# Edit dengan database credentials cPanel Anda
```

**Step 6: Set Document Root di cPanel**
- Login to cPanel
- Addon Domains → tdinus.com
- Set Document Root to: `/home/USERNAME/public_html/public`

**Step 7: Verifikasi**
```bash
# Check browser: https://tdinus.com
```

---

## 📝 PENJELASAN TIAP FILE

### 🔴 CRITICAL - WAJIB BACA

#### `SETUP_CHECKLIST.md` ⭐⭐⭐
**Gunakan untuk:**
- Panduan step-by-step setup
- Troubleshooting checklist
- Verification steps
- Quick reference commands

**Isi:**
- Phase-based setup
- Detailed checklist
- Common issues & solutions
- Command reference

**Buka dengan:**
```bash
cat SETUP_CHECKLIST.md
# atau
less SETUP_CHECKLIST.md
```

---

#### `CPANEL_SETUP_GUIDE.md` ⭐⭐⭐
**Gunakan untuk:**
- Panduan detail implementasi
- Penjelasan setiap step
- Document root configuration
- cPanel-specific issues

**Isi:**
- Current setup status
- Step-by-step guide
- Database configuration
- Comprehensive troubleshooting
- Document root checklist

**Buka dengan:**
```bash
cat CPANEL_SETUP_GUIDE.md
```

---

### 🟠 PENTING - SERING DIGUNAKAN

#### `quick-setup.sh` ⭐⭐
**Gunakan untuk:**
- Setup otomatis saat clone pertama kali
- Install dependencies
- Setup environment
- Run migrations

**Fitur:**
- Check location (verify Laravel root)
- Install composer deps
- Create .env
- Generate APP_KEY
- Run migrations
- Clear cache
- Setup storage
- Optimize

**Cara jalankan:**
```bash
chmod +x quick-setup.sh
bash quick-setup.sh
```

**Waktu:** ~2-3 menit

---

#### `fix-cpanel.sh` ⭐⭐
**Gunakan untuk:**
- Fix masalah khusus cPanel
- Set folder permissions
- Create symlinks
- Verify .htaccess
- Create artisan wrapper

**Fitur:**
- Permission fixing
- Symlink setup
- .htaccess verification
- cagefs compatibility

**Cara jalankan:**
```bash
chmod +x fix-cpanel.sh
bash fix-cpanel.sh
```

**Waktu:** ~1 menit

---

#### `fix-permissions.sh` ⭐⭐
**Gunakan untuk:**
- Fix permission errors
- Reset file ownership
- Fix storage access
- Fix cache access

**Fitur:**
- Set folder 755
- Set files 644
- Fix storage permissions
- Fix bootstrap cache permissions
- Verify ownership

**Cara jalankan:**
```bash
chmod +x fix-permissions.sh
bash fix-permissions.sh
```

**Waktu:** ~1 menit

---

### 🟡 REFERENSI

#### `DEPLOYMENT.md`
**Gunakan untuk:**
- Informasi deployment umum
- Security checklist
- Monitoring & logs
- Update procedures

---

#### `deploy.sh`
**Gunakan untuk:**
- Automatic full deployment
- Install + migrate + optimize
- Jalankan di server production

```bash
bash deploy.sh
```

---

#### `start.sh`
**Gunakan untuk:**
- Local development quick start
- Setup dev environment
- Install npm dependencies

```bash
bash start.sh
```

---

### 🟢 OPSIONAL

#### `.htaccess` & `.htaccess.alternative`
- `.htaccess` sudah berada di `public/` folder
- `.htaccess.alternative` untuk jika document root tidak bisa di-set

**Jika butuh:**
```bash
# Jika document root masih di root
cp .htaccess.alternative .htaccess
```

---

#### `hooks/post-receive.example`
**Gunakan untuk:**
- Auto-deploy via git push
- Setup di git server

---

## ⚡ QUICK COMMAND REFERENCE

### Setup Awal
```bash
chmod +x quick-setup.sh
bash quick-setup.sh
```

### Jika Ada Error
```bash
bash fix-cpanel.sh
bash fix-permissions.sh
```

### Lihat Logs
```bash
tail -f storage/logs/laravel.log
```

### Test Database
```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Update dari Git
```bash
git pull origin main
php artisan migrate --force
php artisan optimize
```

---

## 🎓 WORKFLOW REKOMENDASI

### FIRST TIME SETUP
```
1. Clone aplikasi
   ↓
2. Baca SETUP_CHECKLIST.md
   ↓
3. Jalankan quick-setup.sh
   ↓
4. Edit .env dengan database credentials
   ↓
5. Set Document Root di cPanel
   ↓
6. Test di browser (https://tdinus.com)
```

### DEPLOYMENT UPDATE
```
1. SSH ke cPanel
   ↓
2. git pull origin main
   ↓
3. php artisan migrate --force
   ↓
4. php artisan optimize
   ↓
5. Test di browser
```

### FIX ERRORS
```
1. Check logs (tail -f storage/logs/laravel.log)
   ↓
2. Fix permissions (bash fix-permissions.sh)
   ↓
3. Fix cPanel issues (bash fix-cpanel.sh)
   ↓
4. Clear cache (php artisan config:clear)
   ↓
5. Test kembali
```

---

## 📞 TROUBLESHOOTING BY SYMPTOM

### "Not Found" 404
**Buka:**
- SETUP_CHECKLIST.md → Troubleshooting → Masalah: "Not Found"
- CPANEL_SETUP_GUIDE.md → Troubleshooting → Masalah: "Not Found"

**Juga jalankan:**
```bash
bash fix-cpanel.sh
```

### "500 Internal Server Error"
**Buka:**
- SETUP_CHECKLIST.md → Troubleshooting → Masalah: "500 Internal Server Error"
- CPANEL_SETUP_GUIDE.md → Troubleshooting → Masalah: "500 Internal Server Error"

**Juga jalankan:**
```bash
bash fix-permissions.sh
tail -f storage/logs/laravel.log
```

### "Permission denied" pada storage
**Jalankan:**
```bash
bash fix-permissions.sh
```

### "Database connection error"
**Buka:** SETUP_CHECKLIST.md → Phase 4 → Environment Configuration

**Juga:**
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

---

## ✅ VERIFICATION CHECKLIST

Setelah setup, verifikasi dengan:

```bash
# 1. Document Root benar
# → Check di cPanel Addon Domains

# 2. .env file ada dan configured
ls -la .env
cat .env

# 3. Vendor installed
ls -la vendor/ | head -5

# 4. Database connected
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# 5. Logs accessible
tail -5 storage/logs/laravel.log

# 6. Permissions correct
ls -la storage/
ls -la bootstrap/cache/

# 7. Public accessible
ls -la public/
ls -la public/index.php
```

---

## 📚 RECOMMENDED READING ORDER

1. **First time?** → Start with `SETUP_CHECKLIST.md`
2. **Need details?** → Read `CPANEL_SETUP_GUIDE.md`
3. **Have errors?** → Check troubleshooting section
4. **Want context?** → Read `DEPLOYMENT.md`
5. **Need quick ref?** → Use command reference in this file

---

## 🆘 STILL STUCK?

1. **Read SETUP_CHECKLIST.md completely**
2. **Check storage/logs/laravel.log**
3. **Run:**
   ```bash
   bash quick-setup.sh
   bash fix-cpanel.sh
   bash fix-permissions.sh
   ```
4. **Upload all errors ke text file dan share**

---

**Last Updated:** April 16, 2026  
**Status:** Complete & Ready for Production  
**Support:** Follow the guides in this directory
