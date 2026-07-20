# Rencana Perjalanan Pengembangan (Roadmap)

Pengembangan dibagi menjadi 4 fase terukur untuk memastikan efisiensi budget dan waktu.

## Fase 1: Setup & Database (Hari 1)
- [ ] Inisialisasi projek Laravel 11 & install Tailwind CSS via Vite.
- [ ] Setup file environment (`.env`) untuk database lokal.
- [ ] Eksekusi seluruh berkas migrasi sesuai spesifikasi `DOMAIN_BLUEPRINT.md`.
- [ ] Jalankan `php artisan storage:link`.

## Fase 2: Pembangunan Panel Admin (Hari 2)
- [ ] Install Filament PHP v3.
- [ ] Generate 8 Filament Resource untuk manajemen CRUD konten desa.
- [ ] Kustomisasi form input Filament (RichEditor untuk panduan, FileUpload untuk template pembukuan, seksi input berdampingan untuk Potensi Desa Bilingual).

## Fase 3: Pembuatan Frontend Publik (Hari 3)
- [ ] Pembuatan Layout Utama dengan Navbar Dropdown (Tema Biru-Kuning).
- [ ] Hubungkan query database ke masing-masing halaman Blade sesuai spesifikasi menu.
- [ ] Uji coba fungsionalitas unduhan file Excel dan responsivitas tampilan mobile.

## Fase 4: Quality Assurance & Handover Persiapan (Hari 4)
- [ ] Pengisian data sampel awal untuk demo.
- [ ] Pembersihan kode dan optimasi query (`eager loading` jika diperlukan).
- [ ] Pembuatan akun admin final untuk diserahkan kepada pihak desa.