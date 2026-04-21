# Payment Integration for Pelatihan TODO

## Approved Plan Steps (Confirmed by user with bukti upload, free handling, invoice PDF):

1. [x] Update app/Models/User.php & app/Models/Pelatihan.php - Add payments() relations
2. [x] Update app/Http/Controllers/Member/PelatihanController.php - Modify take() to create Payment or Sertifikat (free)
3. [x] Create app/Http/Controllers/Member/PaymentController.php - index(), show() with upload logic
4. [x] Create app/Http/Controllers/Admin/PaymentController.php - index(), updateStatus() 
5. [x] Edit routes/web.php - Add payment routes
6. [x] Edit resources/views/pelatihan-detail.blade.php - JS popup/modal for payment/free
7. [x] Create resources/views/member/payments/index.blade.php & show.blade.php (invoice + upload bukti)
8. [x] Edited resources/views/member/pelatihan/index.blade.php - Add payment nav & column
9. [x] Created resources/views/admin/payments/index.blade.php - Standalone admin payments page
10. [x] Updated Payment model & migration for bukti_path
11. [x] Added admin nav link in payments view, full implementation complete
 
 Progress complete. Test the flow.
