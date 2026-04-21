# TODO: Fix CSP for TinyMCE in Admin News Create

**Status: In Progress**

## Steps:
- [x] 1. Update app/Http/Middleware/SecurityHeaders.php: Add TinyMCE domains to script-src CSP
- [x] 2. Clear caches (view/config)
- [ ] 3. Test /admin/news/create - TinyMCE loads without CSP block
- [ ] 4. Mark complete

**Issue:** CSP blocks https://cdn.tiny.cloud TinyMCE script.
