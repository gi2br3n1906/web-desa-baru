# Aset Identitas Desa Pringanom

Tempatkan aset final pada direktori ini menggunakan salah satu ekstensi `.png`, `.jpg`, atau `.jpeg`:

- `logo-sragen.png`, `logo-sragen.jpg`, atau `logo-sragen.jpeg` — logo resmi Kabupaten Sragen untuk navbar, favicon publik, dan branding panel admin.
- `logo-kkn-undip.png`, `logo-kkn-undip.jpg`, atau `logo-kkn-undip.jpeg` — logo Tim KKN Universitas Diponegoro untuk credit footer.

Layout publik dan panel admin akan mendeteksi kedua file tersebut secara otomatis dengan urutan prioritas `.png`, `.jpg`, lalu `.jpeg`. Saat file belum tersedia, aplikasi memakai fallback teks/monogram tanpa menampilkan gambar rusak.

## Aset Munggur Spec

Nama dasar berikut dideteksi otomatis dalam format `.webp`, `.png`, `.jpg`, atau `.jpeg`:

- `hero-banner-1` — hero Gunung.
- `hero-banner-2` — hero Sawah.
- `hero-banner-3` — hero Jalan Sunset.
- `potensi-layangan` — anak-anak bermain layangan.
- `posyandu-balita` — balita Posyandu.
- `alat-tani-traktor` — traktor membajak sawah.

Jika aset belum tersedia, frontend menampilkan skeleton/fallback visual dan tidak menghasilkan broken image.