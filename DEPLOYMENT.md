# Panduan Deployment Hemat Biaya

Panduan ini disiapkan khusus untuk arsitektur server dengan batasan anggaran ketat (Budget projek Rp 1.300.000 inklusif).

## Strategi Deployment Terpilih: Shared Hosting Ekonomis / Cloud Free Tier
Karena web ini bertipe informasional dengan *traffic* rendah hingga sedang, spesifikasi minimal sudah cukup memadai.

## Langkah Setup pada Shared Hosting (cPanel):
1. **Pemisahan Folder (Jika non-root public_html):**
   - Taruh seluruh core folder Laravel di root direktori (di luar `public_html`).
   - Pindahkan seluruh isi folder `public` bawaan Laravel ke dalam folder `public_html`.
   - Modifikasi file `public_html/index.php` untuk mengarahkan path `vendor/autoload.php` dan `bootstrap/app.php` ke folder core eksternal.
2. **Symlink Storage:**
   - Buat file `symlink.php` di dalam `public_html` berisi: `<?php symlink('/home/user/core/storage/app/public', '/home/user/public_html/storage'); ?>`.
   - Eksekusi file tersebut via browser sekali saja untuk menghubungkan penyimpanan aset upload Filament ke frontend.
3. **Optimasi Produksi:**
   - Jalankan `php artisan config:cache`, `php artisan route:cache`, dan `php artisan view:cache` sebelum atau sesudah deploy.

## Informasi Handover Klien:
Pihak desa hanya diberikan kredensial akses ke link URL `/admin` untuk melakukan pembaharuan data harian secara mandiri tanpa menyentuh area teknis hosting/server.