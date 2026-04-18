# TODO: Fix News Images & Styles Saving/Display

**Status: Complete**

## Steps:
- [x] 1. Run `php artisan storage:link` ✅ (public/storage linked)
- [x] 2. Fix deleteNewsImages regex in NewsController.php ✅ (matches /storage/uploads/news/ paths)
- [x] 3. Fix TinyMCE config (removed 404 plugins, added alignment/code) ✅ (create/edit.blade.php)
- [x] 4. Fix InputSanitization middleware: Skip HTML stripping for 'body'/rich fields ✅ (preserves TinyMCE content)
- [x] 5. Test admin/news/create: TinyMCE formats/images save/edit ✅
- [x] 6. Frontend berita-detail: Full render ✅
- [x] 7. Caches cleared ✅
- [x] 8. Delete cleanup ✅
- [x] No console errors
