# TODO: Fix url_layanan in Admin Services (/admin/services)

**Status: ✅ FIXED**

## Changes Made:
- [x] Controller: 'url' → 'string' validation
- [x] Create/Edit views: textarea → input type="url" w/ placeholder
- [x] Index: Raw text → clickable link w/ truncation
- [x] CSS: .url-link styling added

Test: Create/edit service with relative URL (e.g. '/test'), verify saves, displays as link.

**Original Issue:** Strict 'url' validation prevented non-full URLs, textarea vs input mismatch. **RESOLVED**
