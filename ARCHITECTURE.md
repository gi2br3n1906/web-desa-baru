# Arsitektur Aplikasi & Struktur Navigasi

Aplikasi ini menggunakan pendekatan arsitektur monolitik Laravel dengan pemisahan jalur (Routing) yang tegas antara halaman Publik (Frontend) dan halaman Kelola Data (Filament Admin).

## Routing & Folder Controller
- **Frontend Routing (`routes/web.php`):** Langsung mengarahkan data dari Model ke Blade View. Tidak memerlukan Controller kompleks karena sifatnya *read-only*.
- **Admin Routing:** Otomatis ditangani oleh Filament di `/admin`.

## Struktur Navbar Frontend (Grup Dropdown)
Mengingat terdapat 8 modul, navigasi diatur menggunakan dropdown Tailwind untuk mencegah penumpukan elemen di layar:

1. **Beranda (Home)**
2. **Pemerintahan & Layanan (Dropdown):**
   - Profil Pemerintah Desa (`/profil`)
   - Panduan Administrasi & Hukum (`/layanan`)
   - Potensi Desa Bilingual (`/potensi`)
3. **Fasilitas & Kesehatan (Dropdown):**
   - Peta Fasilitas Desa (`/fasilitas`)
   - Jadwal & Info Posyandu (`/posyandu`)
4. **Pemberdayaan & UMKM (Dropdown):**
   - Panduan Alat Tani (`/pertanian`)
   - Template Pembukuan (`/pembukuan`)
   - Panduan Pajak UMKM (`/pajak`)

## Layouting Blade
- `resources/views/layouts/app.blade.php`: Base layout frontend yang memuat Navbar dan Footer bertema Biru-Kuning.
- `resources/views/pages/*`: Folder penyimpan view per modul halaman.