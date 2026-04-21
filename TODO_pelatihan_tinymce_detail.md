# TODO: Pelatihan TinyMCE + Detail Page

## Information Gathered:
- Admin: resources/views/admin/pelatihan/create.blade.php & edit.blade.php have `<textarea name="description">`
- Public list: resources/views/pelatihan.blade.php - change "Ambil Pelatihan" → "Lihat Selengkapnya" + link to detail
- Controller: app/Http/Controllers/Admin/PelatihanController.php, PublicController.php
- Routes: admin.pelatihan.*, public pelatihan
- Model: app/Models/Pelatihan.php (has slug)

## Plan:
1. **[x]** Add TinyMCE CDN/config to layouts/app.blade.php & admin.blade.php
2. **[x]** Update admin/pelatihan/create.blade.php & edit.blade.php: replace textarea with TinyMCE
3. **[x]** Create resources/views/pelatihan/detail.blade.php
4. **[x]** Update resources/views/pelatihan.blade.php: button text/link to detail + "Ambil Pelatihan" right side
5. **[x]** Add route for pelatihan/{slug}, PublicController@pelatihanDetail()
6. **[x]** npm run build + test

**Followup:** Confirm plan before edits.

