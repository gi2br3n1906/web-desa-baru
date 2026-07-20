# Cetak Biru Teknologi & Konfigurasi Stack

Dokumen ini mendefinisikan konfigurasi teknis yang harus diterapkan.

## Arsitektur Stack
- **Framework:** Laravel 11.x (LTS/Latest)
- **Admin Panel:** Filament PHP v3.x (Sangat ringan, integrasi database cepat)
- **Frontend CSS:** Tailwind CSS via Vite
- **Database Engine:** InnoDB (MySQL)

## Konfigurasi Tailwind CSS (`tailwind.config.js`)
```javascript
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        desaBlue: {
          DEFAULT: '#1e40af',
          dark: '#1e3a8a',
        },
        desaYellow: {
          DEFAULT: '#facc15',
          dark: '#eab308',
        }
      },
    },
  },
  plugins: [],
}

## Kebijakan File Storage
Semua file unduhan (accounting_templates) dan gambar (village_potentials, village_profiles) wajib menggunakan disk public.
Jangan lupa jalankan perintah php artisan storage:link saat inisialisasi awal.