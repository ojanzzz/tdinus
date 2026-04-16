# 📋 HTACCESS PERMISSION ERROR - SOLUSI

## Error Anda:
```
Failed to open [/home/tdit5693/public_html/tdinus.com/.htaccess]: Permission denied
```

---

## 🔧 SOLUSI CEPAT (SSH Commands):

```bash
# 1. SSH ke server
ssh tdit5693@yourdomain.com

# 2. Navigate ke folder
cd ~/public_html/tdinus.com

# 3. Fix permissions
chmod 644 .htaccess

# 4. Verify
ls -la .htaccess
# Output seharusnya: -rw-r--r--

# 5. Test
cat .htaccess
```

---

## ⚙️ ALTERNATIVE - Gunakan Script

```bash
# Download atau copy script ini:
bash fix-htaccess-permission.sh
```

---

## 🔍 DIAGNOSA

### Cek siapa punya file:
```bash
ls -la .htaccess
stat .htaccess
```

### Cek apa yang bisa mengakses:
```bash
whoami              # Current user
id                  # User ID & groups
```

### Cek web server user:
```bash
# Untuk Apache
ps aux | grep apache
ps aux | grep httpd

# Untuk LiteSpeed (cPanel default)
ps aux | grep httpd
ps aux | grep lsws
```

---

## 🛠️ DETAILED FIX

### Option 1: Simple Fix (Paling Likely Kerja)
```bash
cd ~/public_html/tdinus.com
chmod 644 .htaccess
chmod 755 .
```

### Option 2: Ensure Directory Permissions
```bash
cd ~/public_html
chmod 755 .
chmod 755 tdinus.com
chmod 644 tdinus.com/.htaccess
```

### Option 3: Full Permission Reset (JIKA PERLU)
```bash
cd ~/public_html/tdinus.com

# Set folder to 755
chmod 755 .

# Set files to 644
find . -type f -exec chmod 644 {} \;

# Set directories to 755
find . -type d -exec chmod 755 {} \;

# Special for .htaccess
chmod 644 .htaccess
```

---

## 🚀 PERMANENT FIX

Tambah ini ke file `~/.htaccess` (di root home):

```htaccess
<Files ~ "\.php$">
    Order Allow,Deny
    Allow from all
</Files>
```

Atau ke `~/public_html/.htaccess`:
```htaccess
# Allow .htaccess to be read
<Files ".htaccess">
    Order allow,deny
    Allow from all
</Files>
```

---

## ⚠️ JIKA MASIH ERROR

### Penyebab Kemungkinan:

1. **SELinux restrictions** (jika server punya SELinux)
   ```bash
   # Check if SELinux enabled
   getenforce
   
   # If enforcing, disable context
   semanage fcontext -d /home/tdit5693/public_html/
   restorecon -R /home/tdit5693/public_html/
   ```

2. **cPanel user mismatch**
   ```bash
   # Verify cPanel user
   whoami
   
   # Should be: tdit5693
   ```

3. **LiteSpeed/Apache permission issue**
   ```bash
   # Check if web server can read file
   su -s /bin/bash nobody -c "cat ~/public_html/tdinus.com/.htaccess"
   ```

4. **File corrupted or locked**
   ```bash
   # Delete and recreate
   rm .htaccess
   # Then paste clean .htaccess from public/.htaccess
   cp public/.htaccess .htaccess
   chmod 644 .htaccess
   ```

---

## 📞 CONTACT HOSTING PROVIDER

Jika semua solusi di atas tidak bekerja, contact hosting provider dengan info:

```
Error: Failed to open .htaccess permission denied
Location: /home/tdit5693/public_html/tdinus.com/.htaccess
Issue: Web server cannot read .htaccess file
Tried: chmod 644, verified ownership, checked permissions
```

---

## ✅ TESTING

Setelah fix, test dengan:

```bash
# 1. Direct read
cat .htaccess

# 2. Web server read
sudo -u nobody cat .htaccess

# 3. Access domain
curl -I https://tdinus.com

# 4. Check logs
tail -f ~/logs/error.log
```

---

**Status:** Ready untuk di-execute di cPanel  
**Waktu:** ~1 menit  
**Risk:** Low
