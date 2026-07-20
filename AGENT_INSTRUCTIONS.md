# Kredensial & Instruksi Agen AI (Cline)

Kamu adalah AI developer yang bertugas membangun website desa menggunakan Laravel 11, Filament v3, dan Tailwind CSS. Baca seluruh berkas `.md` di root sebelum menulis kode.

## Aturan Utama Pengembangan
1. **Filament First:** Untuk dashboard admin, gunakan Filament Resource generator. Jangan buat controller admin manual.
2. **Database Cleanliness:** Buat migrasi database yang clean sesuai dengan entitas di `DOMAIN_BLUEPRINT.md`.
3. **Bilingual Handle:** Untuk bagian Potensi Desa, gunakan kolom terpisah di database (`title_id`, `title_jp`, `content_id`, `content_jp`) agar mempermudah input di Filament form tanpa package translasi yang berat.
4. **Tailwind Design Theme:** 
   - Gunakan warna Biru (`#1e40af` / `bg-blue-800`) sebagai warna dominan navbar dan footer.
   - Gunakan warna Kuning (`#facc15` / `bg-yellow-400`) sebagai aksen (tombol aktif, border penanda, highlight).
5. **File Management:** Fitur download template pembukuan harus menggunakan `Filament\Forms\Components\FileUpload` yang disimpan ke disk publik agar bisa diunduh langsung dari frontend.

## Alur Kerja Terpandu
1. Konfigurasi `tailwind.config.js` untuk mendefinisikan warna kustom desa.
2. Generate semua Migration, Model, dan Factory sesuai `DOMAIN_BLUEPRINT.md`.
3. Generate Filament Resources untuk ke-8 modul tersebut.
4. Bangun layout frontend publik dengan navbar dropdown berbasis grup di `ARCHITECTURE.md`.
5. Hubungkan data dari database ke view frontend.