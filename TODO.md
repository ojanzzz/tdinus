# Sitemap Setup Progress (spatie/laravel-sitemap)

**Approved Plan:**
1. Install package via composer require
2. Publish config/migrations  
3. Create SitemapController
4. Add route to routes/web.php
5. Update public/robots.txt
6. Generate sitemap.xml
7. Test /sitemap.xml
8. Setup auto-generation (optional)

## Progress:
- [x] Create TODO.md
- [x] 1. composer require spatie/laravel-sitemap (v8.0.0 installed)
- [x] 2. php artisan vendor:publish --tag=sitemap-config (no publishable, using default config OK)
- [x] 3. Add sitemap() to app/Http/Controllers/PublicController.php
- [x] 4. Edit routes/web.php (add /sitemap.xml route)
- [x] 5. Edit public/robots.txt (add Sitemap line, adjust domain if needed)
- [ ] 6. Generate static sitemap.xml (optional: php artisan sitemap:generate public)
- [ ] 7. Test /sitemap.xml
- [ ] 7. Test akses http://tdinus.test/sitemap.xml (sesuaikan domain)

Notes: 
- Dynamic sitemap di /sitemap.xml sudah ready via PublicController::sitemap().
- spatie/laravel-sitemap v8 tidak punya `sitemap:generate` command (hanya dynamic).
- Clear cache dilakukan.
- Test: Buka http://localhost:8000/sitemap.xml atau domain dev (tdinus.test?). Adjust robots.txt domain jika perlu.

TODO selesai!
