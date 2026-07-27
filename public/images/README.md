# Aset Identitas Desa Pringanom

Tempatkan aset final pada direktori ini menggunakan salah satu ekstensi `.png`, `.jpg`, atau `.jpeg`:

- `logo-sragen.png`, `logo-sragen.jpg`, atau `logo-sragen.jpeg` — logo resmi Kabupaten Sragen untuk navbar, favicon publik, dan branding panel admin.
- `logo-kkn-undip.png`, `logo-kkn-undip.jpg`, atau `logo-kkn-undip.jpeg` — logo Tim KKN Universitas Diponegoro untuk credit footer.

Layout publik dan panel admin akan mendeteksi kedua file tersebut secara otomatis dengan urutan prioritas `.png`, `.jpg`, lalu `.jpeg`. Saat file belum tersedia, aplikasi memakai fallback teks/monogram tanpa menampilkan gambar rusak.

## Aset Munggur Spec

Nama dasar berikut dideteksi otomatis dalam format `.webp`, `.png`, `.jpg`, atau `.jpeg`:

- `image_a462d7` — hero Gunung.
- `image_a46314` — hero Sawah.
- `image_a46339` — hero Jalan Sunset.
- `image_a4602a` atau `image_a45ff3` — anak-anak bermain layangan.
- `IMG_7053` — balita Posyandu.
- `traktor` — traktor membajak sawah.

Jika aset belum tersedia, frontend menampilkan skeleton/fallback visual dan tidak menghasilkan broken image.