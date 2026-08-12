# 📘 BUKU PANDUAN PENGGUNAAN PORTAL RESMI DESA PRINGANOM

> **Status Dokumen:** Draf Modul Panduan Pengguna  
> **Nama Sistem:** Portal Resmi Desa Pringanom  
> **Instansi:** Pemerintah Desa Pringanom, Kecamatan Masaran, Kabupaten Sragen  
> **Sasaran Pengguna:** Masyarakat, Pelaku UMKM, Kader/Perangkat Desa, dan Administrator Desa  
> **Versi Aplikasi:** PWA/Service Worker v4  
> **Tahun:** 2026

---

## Identitas Dokumen

| Elemen | Keterangan |
|---|---|
| Judul | Buku Panduan Penggunaan Portal Resmi Desa Pringanom |
| Jenis dokumen | Modul panduan pengguna |
| Pengelola | Pemerintah Desa Pringanom |
| Pengguna utama | Warga, pelaku UMKM, kader/perangkat desa, dan administrator |
| Alamat portal | Isi dengan alamat resmi portal pada saat dokumen diterbitkan |
| Panel administrator | `/admin` |
| Penyusun/pemeriksa | `[Nama Penyusun/Pemeriksa]` |
| Tanggal pengesahan | `[Tanggal Pengesahan]` |

> **Petunjuk penyuntingan:** Ganti seluruh teks di dalam tanda kurung siku, termasuk placeholder screenshot, sebelum modul dicetak atau disebarluaskan.

[📷 Tampilkan Screenshot: Sampul Portal Desa Pringanom dan Logo Pemerintah Desa]

---

## Daftar Isi

1. [BAB 1: Pendahuluan](#bab-1-pendahuluan)
2. [BAB 2: Panduan Masyarakat & Pelaku UMKM (Fitur Publik)](#bab-2-panduan-masyarakat--pelaku-umkm-fitur-publik)
3. [BAB 3: Panduan Khusus PWA & Input Data Offline (Untuk Kader/Perangkat Desa)](#bab-3-panduan-khusus-pwa--input-data-offline-untuk-kaderperangkat-desa)
4. [BAB 4: Panduan Administrator Desa (Filament Panel)](#bab-4-panduan-administrator-desa-filament-panel)
5. [BAB 5: Troubleshooting & FAQ](#bab-5-troubleshooting--faq)
6. [Lampiran](#lampiran)

---

# BAB 1: PENDAHULUAN

## 1.1 Gambaran Umum Sistem

Portal Resmi Desa Pringanom adalah sistem informasi dan pelayanan desa berbasis web yang dapat dibuka melalui telepon pintar, tablet, maupun komputer. Portal ini menyatukan informasi pemerintahan, layanan administrasi, kabar desa, fasilitas publik, kesehatan, pertanian, potensi desa, direktori UMKM, perpajakan, dan pembukuan UMKM dalam satu aplikasi.

Portal memiliki kemampuan **Progressive Web App (PWA)**. Dengan kemampuan ini, pengguna dapat memasang portal seperti aplikasi pada layar utama perangkat. Sejumlah halaman publik juga disiapkan agar tetap dapat dibuka ketika koneksi internet tidak tersedia.

[📷 Tampilkan Screenshot: Halaman Utama Portal Desa Pringanom]

### 1.1.1 Tujuan Portal

Portal Desa Pringanom bertujuan untuk:

1. Memudahkan masyarakat memperoleh informasi resmi desa.
2. Mempermudah warga membaca persyaratan dan alur layanan administrasi.
3. Menyediakan pengajuan layanan secara daring.
4. Mempromosikan potensi dan pelaku UMKM Desa Pringanom.
5. Membantu pelaku UMKM melakukan pencatatan keuangan sederhana.
6. Menyediakan informasi perpajakan, kesehatan, Posyandu, dan pertanian.
7. Membantu perangkat desa melakukan pendataan UMKM, termasuk ketika berada di wilayah dengan sinyal internet terbatas.
8. Memusatkan pengelolaan konten melalui panel administrator.

### 1.1.2 Kelompok Pengguna

| Kelompok pengguna | Hak akses utama |
|---|---|
| Masyarakat umum/tamu | Membaca halaman publik, mencari informasi, mengunduh dokumen, mengajukan layanan, dan menggunakan pembukuan mode lokal |
| Pelaku UMKM dengan akun | Menggunakan halaman publik dan menyimpan transaksi pembukuan pribadi ke server |
| Kader/perangkat desa | Menggunakan fitur publik serta melakukan pendataan UMKM melalui akun admin yang diberikan secara resmi |
| Administrator desa | Mengelola seluruh data portal melalui panel Filament |

> **Penting:** Akun UMKM dan akun administrator memiliki kewenangan berbeda. Akun UMKM diarahkan ke halaman Pembukuan, sedangkan hanya akun berperan **Admin** yang dapat membuka panel `/admin`.

[📷 Tampilkan Screenshot: Perbandingan Tampilan Pengguna Tamu, Akun UMKM, dan Admin]

## 1.2 Persyaratan Perangkat

### 1.2.1 Perangkat yang Dapat Digunakan

Portal dapat digunakan pada:

- Telepon pintar Android.
- iPhone atau iPad.
- Tablet Android.
- Laptop atau komputer Windows.
- MacBook atau komputer macOS.
- Perangkat lain yang memiliki browser modern dan mendukung JavaScript.

### 1.2.2 Browser yang Disarankan

| Perangkat | Browser yang disarankan |
|---|---|
| Android | Google Chrome versi terbaru atau Microsoft Edge |
| iPhone/iPad | Safari versi terbaru |
| Windows | Google Chrome atau Microsoft Edge versi terbaru |
| macOS | Safari atau Google Chrome versi terbaru |

Browser harus mengizinkan:

- JavaScript.
- Cookie dan sesi login.
- Penyimpanan situs/IndexedDB.
- Service Worker.
- Pop-up unduhan jika pengguna akan mengunduh dokumen atau CSV.

> **Saran:** Lakukan pembaruan browser secara berkala untuk memperoleh keamanan dan dukungan PWA terbaik.

[📷 Tampilkan Screenshot: Contoh Ikon Google Chrome, Microsoft Edge, dan Safari]

### 1.2.3 Persyaratan Koneksi

- Koneksi internet diperlukan untuk kunjungan pertama, login, pengiriman formulir, sinkronisasi data, dan pemuatan konten eksternal.
- Halaman tertentu dapat dibuka offline setelah Service Worker aktif dan halaman telah tersimpan di perangkat.
- Video Google Drive, Google Maps, OpenStreetMap, serta tautan eksternal tidak dijamin tersedia ketika offline.

### 1.2.4 Persiapan Sebelum Menggunakan Portal

1. Pastikan tanggal dan waktu perangkat benar.
2. Pastikan browser telah diperbarui.
3. Hubungkan perangkat ke internet.
4. Buka alamat resmi Portal Desa Pringanom.
5. Tunggu hingga halaman selesai dimuat.
6. Jika akan melakukan pekerjaan lapangan, pasang PWA dan buka halaman yang akan digunakan saat perangkat masih online.

[📷 Tampilkan Screenshot: Portal Berhasil Dibuka pada Browser HP]

## 1.3 Keamanan Dasar Penggunaan

1. Jangan membagikan kata sandi akun kepada pihak yang tidak berwenang.
2. Gunakan menu **Logout** setelah menggunakan komputer bersama.
3. Jangan menyimpan kata sandi admin pada perangkat umum.
4. Jangan menghapus data situs ketika masih ada **Antrean Sync**.
5. Pastikan alamat portal menggunakan HTTPS dan domain resmi desa.
6. Hindari mengunggah dokumen warga melalui jaringan atau perangkat yang tidak dipercaya.

---

# BAB 2: PANDUAN MASYARAKAT & PELAKU UMKM (FITUR PUBLIK)

## 2.1 Navigasi Portal Desa

Navbar atau menu utama berada di bagian atas halaman. Pada layar laptop, menu tampil secara horizontal. Pada telepon pintar, tekan ikon menu untuk membuka daftar navigasi.

[📷 Tampilkan Screenshot: Navbar Portal pada Laptop]

[📷 Tampilkan Screenshot: Menu Portal pada Telepon Pintar]

### 2.1.1 Kelompok Menu Utama

#### A. Beranda

Beranda menampilkan:

- Carousel foto Desa Pringanom.
- Tombol **Jelajahi Layanan**.
- Kartu akses cepat.
- Tiga Kabar Desa terbaru.
- Informasi ringkas portal.

**Cara menggunakan:**

1. Buka alamat portal.
2. Gunakan tombol panah pada carousel untuk berpindah gambar.
3. Pilih salah satu kartu akses cepat.
4. Klik berita untuk membaca artikel lengkap.

[📷 Tampilkan Screenshot: Carousel dan Akses Cepat di Beranda]

#### B. Kabar Desa

Halaman **Kabar Desa** menyediakan berita, kegiatan, dan pengumuman resmi.

**Cara mencari berita:**

1. Pilih menu **Kabar Desa**.
2. Ketik kata kunci pada kolom **Cari berita**.
3. Pilih kategori jika diperlukan.
4. Tekan **Cari** atau tunggu pencarian otomatis.
5. Klik judul berita untuk membuka isi lengkap.
6. Tekan **Reset** untuk menghapus kata kunci dan filter.

[📷 Tampilkan Screenshot: Kolom Pencarian dan Filter Kategori Kabar Desa]

[📷 Tampilkan Screenshot: Halaman Detail Berita dan Berita Terkait]

#### C. Pemerintahan & Layanan

Kelompok menu ini mencakup:

- **Profil Pemerintah Desa**: visi, misi, struktur organisasi, dan kontak desa.
- **Panduan Administrasi & Hukum**: persyaratan layanan, alur pengurusan, pengajuan online, dan produk hukum.
- **Potensi Desa Bilingual**: informasi potensi dalam Bahasa Indonesia dan Bahasa Jepang.

[📷 Tampilkan Screenshot: Dropdown Pemerintahan & Layanan]

#### D. Fasilitas & Kesehatan

Kelompok menu ini mencakup:

- **Peta Fasilitas Desa**: daftar fasilitas, kategori, keterangan, dan lokasi peta.
- **Informasi Posyandu**: profil bidan, kader, edukasi kesehatan, dan galeri kegiatan.

[📷 Tampilkan Screenshot: Dropdown Fasilitas & Kesehatan]

#### E. Pemberdayaan & UMKM

Kelompok menu ini mencakup:

- Panduan Alat Tani.
- Pembukuan UMKM.
- Direktori UMKM.
- Panduan Pajak UMKM.

[📷 Tampilkan Screenshot: Dropdown Pemberdayaan & UMKM]

## 2.2 Membaca Profil dan Kontak Desa

1. Pilih **Pemerintahan & Layanan → Profil Pemerintah Desa**.
2. Baca bagian visi dan misi.
3. Lihat struktur organisasi pada bagian media/struktur desa.
4. Gunakan informasi pada kartu **Kontak Desa** untuk menghubungi pemerintah desa.

[📷 Tampilkan Screenshot: Halaman Profil, Struktur Organisasi, dan Kontak Desa]

## 2.3 Mencari Informasi Layanan Desa

### 2.3.1 Daftar Layanan dan Persyaratan Terbaru

Portal menyediakan 14 layanan administrasi. Siapkan dokumen berikut sesuai layanan yang akan diajukan.

| Layanan | Persyaratan |
|---|---|
| Keterangan Domisili | Surat pengantar RT; Fotokopi KTP; Fotokopi KK |
| Nikah atau Numpang Nikah | Fotokopi KTP; Fotokopi KK kedua calon mempelai; Fotokopi KTP saksi; Foto latar biru 3×4 (4 lembar) dan 4×6 (4 lembar); Fotokopi buku nikah orang tua; Fotokopi ijazah; khusus nikah gereja: foto calon satu bangku gereja; surat cerai asli bagi yang pernah bercerai |
| Pembuatan Akta Kelahiran | Mengisi formulir; Fotokopi surat nikah orang tua yang dilegalisir KUA penerbit; Fotokopi KTP kedua orang tua; Fotokopi KTP pemohon bila sudah memiliki KTP; Fotokopi KK; Fotokopi ijazah bila sudah memiliki; surat keterangan dokter/bidan atau duplikat surat kelahiran; surat kematian bagi orang tua yang telah meninggal; Fotokopi KTP dua orang saksi; surat cerai bila orang tua telah bercerai |
| Pembuatan atau Perubahan KK | Fotokopi KK (1 lembar); surat pindah bagi penduduk dari luar wilayah; dokumen pendukung identitas untuk ralat data; surat bidan/dokter/rumah sakit untuk penambahan anak baru lahir |
| Pembuatan KTP | Fotokopi KK; foto hitam putih 3×4 (1 lembar) bagi pemula |
| Pindah Tempat | Surat pengantar RT; mengisi formulir; Fotokopi KTP (2 lembar); Fotokopi KK (2 lembar); foto berwarna 4×6 (8 lembar); alamat tujuan yang lengkap dan jelas; SKCK untuk perpindahan antar kabupaten/provinsi bila dipersyaratkan |
| Cerai | Fotokopi KTP; buku nikah asli; suami dan istri menghadap Kepala Desa |
| Rujuk | Fotokopi KTP; foto ukuran 2×3 (4 lembar); akta cerai asli keduanya |
| Surat Kelahiran | Fotokopi surat dari bidan/rumah sakit; Fotokopi KK; Fotokopi KTP Orangtua |
| Surat Kehilangan | Fotokopi KTP; Fotokopi KK; keterangan alasan kehilangan |
| Surat Kematian | Surat pengantar RT; mengisi formulir; Fotokopi KTP; Fotokopi KK; Fotokopi KTP dua orang saksi |
| Surat Keterangan Tidak Mampu | Fotokopi KK; Fotokopi KTP; surat pernyataan tidak mampu dari RT/RW |
| Surat Keterangan Usaha | Fotokopi KTP; informasi jenis usaha; alamat usaha |
| Surat Pengantar SKCK | Fotokopi KTP; tahun lulus SD, SMP, dan SMA/SMK atau jenjang berikutnya; keterangan keperluan pengajuan |

> **Catatan:** Surat pengantar RT hanya menjadi persyaratan untuk **Keterangan Domisili**, **Pindah Tempat**, dan **Surat Kematian**. Layanan lainnya tidak mensyaratkan Surat pengantar RT.

[📷 Tampilkan Screenshot: Daftar Layanan Administrasi dan Persyaratan Terbaru]

### 2.3.2 Membaca Persyaratan dan Alur

1. Pilih **Pemerintahan & Layanan → Panduan Administrasi & Hukum**.
2. Cari nama layanan yang dibutuhkan.
3. Baca kolom **Persyaratan**.
4. Baca kolom **Alur Pengurusan**.
5. Siapkan dokumen sesuai petunjuk sebelum mengajukan layanan.

[📷 Tampilkan Screenshot: Kartu Persyaratan dan Alur Pengurusan Layanan]

### 2.3.3 Mengunduh Produk Hukum

1. Buka bagian **Produk Hukum Desa**.
2. Periksa judul, nomor/tahun, kategori, dan keterangan dokumen.
3. Tekan **Unduh Dokumen (PDF)**.
4. Buka file dari folder unduhan perangkat.

[📷 Tampilkan Screenshot: Daftar Produk Hukum dan Tombol Unduh PDF]

### 2.3.4 Mengajukan Layanan Online

1. Buka bagian **Pengajuan Layanan Online**.
2. Pilih jenis layanan.
3. Isi **Nama Lengkap**.
4. Isi **NIK** sebanyak 16 digit.
5. Isi alamat lengkap.
6. Isi nomor WhatsApp yang aktif.
7. Unggah berkas syarat jika diperlukan.
8. Pastikan berkas berformat PDF/JPG/JPEG/PNG dan tidak melebihi 5 MB.
9. Tekan tombol kirim.
10. Tunggu pesan bahwa pengajuan berhasil dikirim.
11. Petugas desa akan menindaklanjuti melalui nomor WhatsApp yang dicantumkan.

[📷 Tampilkan Screenshot: Form Pengajuan Layanan Online]

[📷 Tampilkan Screenshot: Pesan Pengajuan Berhasil]

> **Perhatian:** Pengiriman pengajuan membutuhkan koneksi internet. Jangan menutup halaman sebelum pesan berhasil tampil.

## 2.4 Menggunakan Informasi Fasilitas Desa

1. Pilih **Fasilitas & Kesehatan → Peta Fasilitas Desa**.
2. Cari fasilitas berdasarkan nama dan kategori yang ditampilkan.
3. Baca keterangan fasilitas.
4. Gunakan peta pada kartu fasilitas untuk melihat lokasi.

[📷 Tampilkan Screenshot: Daftar Fasilitas Publik dan Peta]

> **Catatan:** Peta yang disediakan oleh layanan eksternal memerlukan koneksi internet.

## 2.5 Menggunakan Halaman Posyandu

### 2.5.1 Melihat Profil Bidan dan Kader

1. Pilih **Fasilitas & Kesehatan → Informasi Posyandu**.
2. Baca profil bidan penanggung jawab.
3. Pada bagian kader, pilih tab Posyandu Sari Mulyo I–XI.
4. Daftar jabatan dan nama kader akan berubah sesuai tab yang dipilih.

[📷 Tampilkan Screenshot: Profil Bidan Penanggung Jawab]

[📷 Tampilkan Screenshot: Tab dan Tabel Kader Posyandu]

### 2.5.2 Membuka Materi Edukasi

1. Pilih kartu materi PHBS, gizi, atau imunisasi.
2. Klik **Lihat Poster**.
3. Baca poster dan deskripsinya.
4. Jika diperlukan, tekan **Buka Sumber Poster**.
5. Tutup pratinjau menggunakan tombol silang, klik area luar, atau tombol `Escape`.

[📷 Tampilkan Screenshot: Kartu Edukasi dan Modal Pratinjau Poster]

### 2.5.3 Menyaring Galeri Kegiatan

1. Buka bagian **Galeri Kegiatan Posyandu**.
2. Pilih **Semua** atau tahun yang diinginkan.
3. Klik foto untuk membuka dokumentasi pada tab baru.

[📷 Tampilkan Screenshot: Filter Tahun dan Galeri Posyandu]

## 2.6 Menggunakan Panduan Pertanian

1. Pilih **Pemberdayaan & UMKM → Panduan Alat Tani**.
2. Putar video panduan jika koneksi internet tersedia.
3. Pilih alat yang ingin dipelajari.
4. Baca **Panduan Perawatan**.
5. Perhatikan **Tips Keamanan** sebelum menggunakan alat.

[📷 Tampilkan Screenshot: Video dan Kartu Panduan Alat Pertanian]

## 2.7 Mengakses dan Menggunakan Pembukuan UMKM Desa

Halaman Pembukuan dapat digunakan oleh tamu maupun pemilik akun UMKM. Perbedaan utamanya terletak pada lokasi penyimpanan data.

| Mode | Lokasi data | Keterangan |
|---|---|---|
| Tamu/belum login | Browser pada perangkat | Tidak masuk ke server desa dan dapat hilang jika data browser dibersihkan |
| Akun UMKM/login | Server Desa Pringanom | Terhubung ke akun dan dapat dibuka kembali setelah login |

[📷 Tampilkan Screenshot: Informasi Mode Penyimpanan pada Halaman Pembukuan]

### 2.7.1 Login Akun UMKM

1. Tekan **Masuk** pada navbar.
2. Isi email dan kata sandi akun UMKM.
3. Aktifkan opsi ingat saya hanya pada perangkat pribadi.
4. Tekan **Masuk**.
5. Sistem akan mengarahkan pengguna ke halaman Pembukuan.

[📷 Tampilkan Screenshot: Form Login Akun Portal]

> Jika belum memiliki akun UMKM, hubungi administrator desa. Pembuatan akun dilakukan melalui panel admin.

### 2.7.2 Buku Penjualan

Gunakan Buku Penjualan hanya untuk transaksi penjualan produk.

1. Buka tab **🔵 Penjualan**.
2. Pilih **Catatan Harian**.
3. Isi tanggal transaksi.
4. Isi nama produk.
5. Isi jumlah/Qty.
6. Isi harga satuan.
7. Tekan **+ Simpan Penjualan**.
8. Sistem menghitung total `Qty × Harga Satuan`.
9. Buka **Rekap Mingguan** atau **Rekap Bulanan** untuk melihat ringkasan.

[📷 Tampilkan Screenshot: Form dan Tabel Buku Penjualan]

[📷 Tampilkan Screenshot: Rekap Mingguan dan Bulanan]

### 2.7.3 Buku Kas Operasional

Gunakan bagian ini untuk modal, pendapatan non-penjualan, dan seluruh pengeluaran usaha.

1. Buka tab **🟢 Kas Operasional**.
2. Isi tanggal.
3. Pilih **Kas Masuk** atau **Kas Keluar**.
4. Isi keterangan.
5. Pilih kategori, misalnya Modal, Pendapatan Lain, Bahan Baku, Transport, Operasional, Gaji, Prive, atau Lain-lain.
6. Isi nominal.
7. Tekan **+ Simpan Transaksi**.
8. Periksa saldo dan ringkasan yang dihitung otomatis.

[📷 Tampilkan Screenshot: Form Kas Operasional dan Ringkasan Saldo]

### 2.7.4 Buku Utang dan Piutang

1. Buka tab **🟢 Utang & Piutang**.
2. Isi tanggal.
3. Pilih:
   - **Piutang** untuk uang yang akan diterima.
   - **Hutang** untuk uang yang harus dibayar.
4. Isi nama orang/toko.
5. Isi nominal.
6. Tambahkan keterangan jika diperlukan.
7. Tekan **+ Simpan Catatan**.
8. Klik badge status untuk menandai **Lunas** atau **Belum**.

[📷 Tampilkan Screenshot: Form Utang/Piutang dan Badge Status]

### 2.7.5 Melihat Laba Rugi

1. Buka tab **⚫ Laba Rugi**.
2. Pilih bulan yang ingin ditinjau pada tabel.
3. Periksa nilai Penjualan, Pendapatan Lain, Pengeluaran Usaha, Prive, dan Laba/Rugi.

Rumus yang digunakan:

```text
Laba/Rugi = Penjualan + Pendapatan Lain − Pengeluaran Usaha
```

Prive ditampilkan terpisah dan tidak dihitung sebagai biaya usaha.

[📷 Tampilkan Screenshot: Tabel Rekap Laba Rugi Bulanan]

### 2.7.6 Mengunduh CSV dan Menghapus Data

- Tekan **Unduh CSV** pada buku yang ingin dicadangkan.
- Simpan file pada folder yang mudah ditemukan.
- Gunakan tombol **Hapus** untuk menghapus satu transaksi.
- Gunakan **Hapus Semua Data** hanya jika benar-benar diperlukan.
- Baca kotak konfirmasi sebelum menyetujui penghapusan.

[📷 Tampilkan Screenshot: Tombol Unduh CSV, Hapus Baris, dan Hapus Semua Data]

> **Saran untuk mode tamu:** Unduh CSV secara rutin karena data hanya tersimpan pada browser saat ini.

### 2.7.7 Mengunduh Template Excel

1. Gulir ke bagian **Template Pembukuan UMKM Pringanom**.
2. Tekan **Unduh Template (Excel)**.
3. Buka file menggunakan Microsoft Excel, LibreOffice Calc, atau aplikasi spreadsheet yang sesuai.
4. Template tambahan dari admin dapat diunduh pada bagian bawah halaman.

[📷 Tampilkan Screenshot: Tombol Unduh Template Excel]

## 2.8 Mencari Informasi di Direktori UMKM

### 2.8.1 Melihat Statistik UMKM

1. Pilih **Pemberdayaan & UMKM → Direktori UMKM**.
2. Buka bagian **Gambaran UMKM Desa Pringanom**.
3. Lihat grafik menurut jenis usaha dan dukuh.

[📷 Tampilkan Screenshot: Statistik dan Grafik Distribusi UMKM]

### 2.8.2 Menggunakan Peta UMKM

1. Buka bagian **Peta Sebaran UMKM**.
2. Tekan gambar peta untuk melihat ukuran penuh.
3. Tekan **Unduh Peta (JPG)** untuk menyimpan peta.
4. Pada peta interaktif, klik marker untuk melihat nama, kategori, dan dukuh UMKM.

[📷 Tampilkan Screenshot: Peta Kartografi dan Peta Interaktif UMKM]

> Peta interaktif menggunakan OpenStreetMap dan membutuhkan koneksi internet untuk memuat tile peta.

### 2.8.3 Mencari UMKM

1. Buka bagian **Direktori UMKM**.
2. Ketik nama usaha, nama pemilik, produk, atau kata pada deskripsi di kolom pencarian.
3. Pilih **Jenis Usaha** jika diperlukan.
4. Pilih **Dukuh** jika diperlukan.
5. Daftar kartu akan tersaring secara langsung.

[📷 Tampilkan Screenshot: Pencarian, Filter Jenis Usaha, dan Filter Dukuh]

### 2.8.4 Membaca FAQ dan Kalender Pajak

1. Buka bagian **FAQ Pajak UMKM**.
2. Klik pertanyaan untuk menampilkan jawaban.
3. Buka **Kalender Kewajiban Pajak** untuk melihat jadwal.
4. Gunakan tautan buku saku pajak jika koneksi internet tersedia.

[📷 Tampilkan Screenshot: FAQ dan Kalender Pajak pada Pojok UMKM]

## 2.9 Menggunakan Halaman Panduan Pajak

1. Pilih **Pemberdayaan & UMKM → Panduan Pajak UMKM**.
2. Periksa kalender bulan berjalan.
3. Perhatikan penanda batas pajak.
4. Baca panduan dan tarif sesuai kategori usaha.
5. Buka FAQ untuk jawaban pertanyaan umum.

[📷 Tampilkan Screenshot: Kalender, Tarif, Alur, dan FAQ Pajak]

---

# BAB 3: PANDUAN KHUSUS PWA & INPUT DATA OFFLINE (UNTUK KADER/PERANGKAT DESA)

## 3.1 Pengertian PWA dan Mode Offline

PWA memungkinkan Portal Desa Pringanom dipasang seperti aplikasi. Setelah dipasang dan disiapkan saat online, sejumlah halaman dapat dibuka kembali tanpa koneksi internet.

Halaman publik yang disiapkan untuk offline adalah:

1. Beranda — `/`.
2. Pembukuan — `/pembukuan`.
3. Direktori UMKM — `/umkm`.
4. Posyandu — `/posyandu`.
5. Profil — `/profil`.
6. Layanan — `/layanan`.
7. Daftar Kabar Desa — `/berita`.

> **Batasan:** Tersedianya halaman secara offline tidak menjamin video, peta, gambar eksternal, atau tautan pihak ketiga ikut tersedia.

[📷 Tampilkan Screenshot: Portal Berjalan sebagai Aplikasi Standalone]

## 3.2 Cara Menginstal PWA di Android

1. Sambungkan perangkat ke internet.
2. Buka portal menggunakan Google Chrome.
3. Tunggu halaman selesai dimuat.
4. Tekan menu tiga titik di kanan atas.
5. Pilih **Install app**, **Instal aplikasi**, atau **Tambahkan ke layar utama**.
6. Tekan **Install/Tambahkan**.
7. Tunggu ikon **Desa Pringanom** tampil pada layar utama.
8. Buka aplikasi satu kali saat masih online.

[📷 Tampilkan Screenshot: Menu Chrome “Tambahkan ke Layar Utama”]

[📷 Tampilkan Screenshot: Konfirmasi Instalasi PWA Android]

[📷 Tampilkan Screenshot: Ikon Desa Pringanom pada Home Screen]

## 3.3 Cara Menginstal PWA di iPhone/iPad

1. Sambungkan perangkat ke internet.
2. Buka portal melalui Safari.
3. Tekan ikon **Bagikan/Share**.
4. Pilih **Add to Home Screen/Tambahkan ke Layar Utama**.
5. Periksa nama aplikasi.
6. Tekan **Add/Tambah**.
7. Buka ikon portal dari layar utama saat masih online.

[📷 Tampilkan Screenshot: Tombol Share pada Safari]

[📷 Tampilkan Screenshot: Menu Add to Home Screen pada iPhone]

## 3.4 Cara Menginstal PWA di Laptop/Komputer

### Google Chrome atau Microsoft Edge

1. Buka portal melalui browser.
2. Klik ikon instalasi di sisi kanan address bar.
3. Jika ikon tidak tampil, buka menu browser lalu pilih **Apps → Install**.
4. Tekan **Install**.
5. Pilih apakah aplikasi akan dibuatkan pintasan desktop/taskbar.

[📷 Tampilkan Screenshot: Ikon Install pada Address Bar Laptop]

[📷 Tampilkan Screenshot: Dialog Konfirmasi Instalasi PWA Desktop]

## 3.5 Persiapan Sebelum Bertugas di Dusun Tanpa Internet

Lakukan checklist berikut ketika perangkat masih memiliki internet:

- [ ] PWA telah dipasang.
- [ ] Browser atau PWA dapat dibuka.
- [ ] Admin telah login.
- [ ] Menu **Direktori UMKM** dapat dibuka.
- [ ] Halaman **Tambah UMKM** telah dibuka.
- [ ] Badge menunjukkan **🟢 Online**.
- [ ] Baterai perangkat mencukupi.
- [ ] Tidak ada antrean sync lama yang belum selesai.
- [ ] Form dibiarkan terbuka sebelum berpindah ke wilayah tanpa sinyal.

[📷 Tampilkan Screenshot: Halaman Tambah UMKM dalam Kondisi Online]

> **Sangat penting:** Halaman admin tidak termasuk daftar halaman publik yang diprecache. Buka form **Tambah UMKM** saat masih online dan jangan me-refresh atau menutup tab setelah masuk area tanpa sinyal.

## 3.6 Memahami Indikator Status

### 3.6.1 Status 🟢 Online

Artinya browser mendeteksi koneksi internet. Operasi server seperti login, pengiriman form, dan sinkronisasi dapat dilakukan.

[📷 Tampilkan Screenshot: Badge 🟢 Online pada Navbar/Topbar]

### 3.6.2 Status 🟡 Offline

Label berubah menjadi **Mode Offline (Tersimpan Lokal)**. Data UMKM yang disimpan melalui form offline akan ditahan pada perangkat.

[📷 Tampilkan Screenshot: Badge 🟡 Mode Offline]

### 3.6.3 Badge 📥 Antrean Sync

- Badge tampil ketika terdapat data UMKM yang menunggu pengiriman.
- Angka pada badge menunjukkan jumlah data belum tersinkron.
- Jangan menghapus data situs selama angka masih lebih dari nol.

[📷 Tampilkan Screenshot: Badge Antrean Sync dengan Jumlah Data]

### 3.6.4 Tanda 🔒 pada Navbar

Saat offline, menu publik yang tidak disiapkan untuk offline akan:

- Dicoret.
- Ditampilkan lebih redup.
- Menggunakan kursor tidak aktif.
- Memiliki ikon `🔒`.

Jika menu tersebut diklik, portal menampilkan modal **Halaman Belum Tersedia Offline**. Tekan **Paham** untuk menutup modal.

[📷 Tampilkan Screenshot: Menu Dicoret dengan Ikon 🔒]

[📷 Tampilkan Screenshot: Modal Halaman Belum Tersedia Offline]

Saat koneksi kembali, tanda coret dan gembok hilang secara otomatis.

## 3.7 Input Data UMKM Saat Offline

> **Khusus pengguna berwenang:** Fitur ini hanya untuk administrator/kader/perangkat desa yang menggunakan akun ber-role **Admin**. Form offline berada pada `/admin/umkms/create`, bukan pada halaman direktori publik.

### 3.7.1 Membuka Form

1. Login sebagai admin ketika masih online.
2. Buka **Pemberdayaan & UMKM → Direktori UMKM**.
3. Tekan **Tambah UMKM**.
4. Pastikan form telah tampil lengkap.
5. Jika sinyal hilang, pastikan badge berubah menjadi 🟡.

[📷 Tampilkan Screenshot: Menu Direktori UMKM dan Tombol Tambah UMKM]

### 3.7.2 Mengisi Data Wajib

Isi sekurang-kurangnya:

1. **Nama Usaha**.
2. **Nama Pemilik**.
3. **Jenis Usaha**.
4. **Dukuh**.
5. **Alamat Lengkap**.
6. **Bentuk Usaha**.
7. **Nomor HP**, jika tersedia.

[📷 Tampilkan Screenshot: Field Form UMKM yang Wajib Diisi Saat Offline]

> **Catatan:** RT/RW dapat digunakan sebagai fallback alamat oleh skrip form, tetapi untuk kualitas data yang baik tetap isi alamat lengkap dengan benar.

### 3.7.3 Menyimpan Data Lokal

1. Periksa kembali ejaan nama pemilik dan usaha.
2. Tekan tombol simpan pada form.
3. Sistem mencegah pengiriman ke internet.
4. Data disimpan ke penyimpanan lokal perangkat.
5. Form dikosongkan setelah penyimpanan berhasil.
6. Toast amber akan menampilkan informasi bahwa data tersimpan lokal.
7. Angka **Antrean Sync** bertambah.

[📷 Tampilkan Screenshot: Toast Data UMKM Tersimpan Offline]

[📷 Tampilkan Screenshot: Form Kosong dan Antrean Sync Bertambah]

### 3.7.4 Data yang Perlu Dilengkapi Setelah Sync

Data offline tidak membawa seluruh field form lengkap. Setelah tersinkron, admin perlu memeriksa record dan melengkapi:

- RT/RW, karena server sementara mengisinya dengan tanda `-`.
- Deskripsi usaha yang lebih informatif.
- Latitude.
- Longitude.
- Foto UMKM.

[📷 Tampilkan Screenshot: Form Edit Record Hasil Sinkronisasi]

## 3.8 Alur Otomatis Sinkronisasi Saat Sinyal Kembali

### 3.8.1 Proses Normal

1. Perangkat kembali memperoleh internet.
2. Badge berubah dari 🟡 menjadi 🟢.
3. Sistem membaca antrean lokal.
4. Toast biru menampilkan proses pengiriman.
5. Data dikirim ke server secara otomatis.
6. Server menyimpan data tanpa menggandakan record yang sama.
7. Data yang berhasil dikirim dihapus dari antrean lokal.
8. Toast hijau menunjukkan jumlah data berhasil.
9. Badge antrean berkurang atau hilang jika semua data selesai.

[📷 Tampilkan Screenshot: Toast Proses Sinkronisasi]

[📷 Tampilkan Screenshot: Toast Sinkronisasi Berhasil]

### 3.8.2 Setelah Sinkronisasi

1. Buka **Direktori UMKM** pada panel admin.
2. Cari nama usaha yang baru didata.
3. Buka menu **Edit**.
4. Lengkapi RT/RW, deskripsi, koordinat, dan foto.
5. Simpan perubahan.
6. Periksa halaman publik `/umkm` untuk memastikan data tampil benar.

[📷 Tampilkan Screenshot: Data Hasil Sync pada Tabel Direktori UMKM]

[📷 Tampilkan Screenshot: Kartu UMKM pada Halaman Publik]

## 3.9 Larangan Saat Antrean Belum Selesai

Ketika badge antrean masih tampil, jangan:

- Menghapus cache dan data situs.
- Menghapus IndexedDB.
- Melakukan reset browser.
- Menghapus aplikasi PWA.
- Menggunakan mode incognito sebagai tempat pendataan utama.
- Logout jika data akan segera disinkronkan.
- Mematikan perangkat sebelum data dipastikan aman.

---

# BAB 4: PANDUAN ADMINISTRATOR DESA (FILAMENT PANEL)

## 4.1 Cara Akses dan Login Panel Admin

1. Buka browser.
2. Masukkan alamat portal diikuti `/admin`, contoh:

   ```text
   https://alamat-portal-desa/admin
   ```

3. Jika belum login, sistem mengarahkan ke `/admin/login`.
4. Masukkan email admin.
5. Masukkan kata sandi.
6. Centang **Remember me** hanya pada perangkat pribadi.
7. Tekan **Sign in/Masuk**.
8. Sistem membuka Dashboard Admin.

[📷 Tampilkan Screenshot: Halaman Login Filament Admin]

[📷 Tampilkan Screenshot: Dashboard Admin setelah Login]

> Percobaan login dibatasi. Jika terlalu banyak mencoba, tunggu beberapa saat sebelum mencoba kembali.

## 4.2 Mengenal Dashboard

Dashboard menampilkan statistik:

- **Total UMKM Terdaftar**.
- **Pengajuan Layanan Baru** berstatus Pending.
- **Berita Terbit**.

Statistik diperbarui berkala dan dapat diklik menuju resource terkait.

[📷 Tampilkan Screenshot: Kartu Statistik Dashboard]

Menu cepat menyediakan akses ke:

- Kelola UMKM.
- Pengajuan layanan masuk.
- Tulis berita desa.
- Edit profil desa.
- Produk hukum dan dokumen.

[📷 Tampilkan Screenshot: Menu Cepat Dashboard]

## 4.3 Pola Umum Pengelolaan Data

Sebagian besar menu Filament menggunakan alur yang sama.

### Menambah Data

1. Pilih menu pada sidebar.
2. Tekan tombol **Tambah/Create**.
3. Isi field yang bertanda wajib.
4. Unggah file jika diperlukan.
5. Tekan **Create/Simpan**.

### Mengubah Data

1. Buka daftar data.
2. Gunakan pencarian atau filter.
3. Tekan **Edit** pada record.
4. Ubah informasi.
5. Tekan **Save/Simpan**.

### Menghapus Data

1. Buka record yang akan dihapus.
2. Tekan **Delete/Hapus**.
3. Baca dialog konfirmasi.
4. Konfirmasi hanya jika data benar-benar tidak diperlukan.

### Menghapus Banyak Data

1. Centang beberapa baris.
2. Pilih aksi massal **Delete**.
3. Konfirmasi penghapusan.

[📷 Tampilkan Screenshot: Tombol Tambah, Edit, Hapus, dan Bulk Action]

## 4.4 Kelola Data UMKM

### 4.4.1 Menambah UMKM Secara Online

1. Pilih **Pemberdayaan & UMKM → Direktori UMKM**.
2. Tekan **Tambah UMKM**.
3. Isi:
   - Nama Usaha.
   - Nama Pemilik.
   - Jenis Usaha.
   - Dukuh.
   - RT/RW.
   - Alamat Lengkap.
   - Bentuk Usaha.
   - Nomor HP.
   - Deskripsi.
   - Latitude dan longitude jika tersedia.
   - Foto usaha.
4. Gunakan image editor jika diperlukan.
5. Tekan **Simpan/Create**.

[📷 Tampilkan Screenshot: Form Tambah UMKM Lengkap]

Pilihan bentuk usaha yang tersedia:

- Perorangan.
- UD.
- CV.
- Koperasi.
- PT.
- Kelompok.

### 4.4.2 Menentukan Koordinat

1. Ambil koordinat lokasi dari aplikasi peta.
2. Masukkan nilai latitude dan longitude pada field masing-masing.
3. Simpan data.
4. Periksa marker pada peta interaktif halaman publik.

[📷 Tampilkan Screenshot: Field Latitude dan Longitude]

### 4.4.3 Mencari dan Memfilter UMKM

- Gunakan kolom pencarian untuk nama usaha atau pemilik.
- Klik header kolom untuk mengurutkan.
- Gunakan filter kategori untuk membatasi jenis usaha.

[📷 Tampilkan Screenshot: Tabel dan Filter Direktori UMKM Admin]

## 4.5 Kelola Berita Desa

### 4.5.1 Membuat Berita

1. Pilih **Kabar & Informasi → Berita & Kabar Desa**.
2. Tekan **Tambah Berita**.
3. Isi judul.
4. Periksa slug yang dibuat dan pastikan unik.
5. Pilih kategori.
6. Unggah thumbnail.
7. Isi ringkasan.
8. Tulis konten pada rich editor.
9. Isi nama penulis.
10. Tentukan waktu terbit.
11. Aktifkan **Terbitkan Langsung** jika berita siap dipublikasikan.
12. Simpan.

[📷 Tampilkan Screenshot: Form Tambah Berita]

### 4.5.2 Memeriksa Publikasi

1. Buka halaman publik **Kabar Desa**.
2. Cari judul berita.
3. Pastikan thumbnail, tanggal, penulis, dan isi tampil benar.
4. Jika belum tampil, periksa status publikasi dan waktu terbit.

[📷 Tampilkan Screenshot: Berita Baru pada Halaman Publik]

## 4.6 Kelola Panduan dan Pengajuan Layanan

### 4.6.1 Mengelola Panduan Layanan

1. Pilih **Pemerintahan & Profil → Panduan Layanan**.
2. Tambahkan atau edit nama layanan.
3. Isi persyaratan melalui rich editor.
4. Isi alur pengurusan.
5. Simpan.

[📷 Tampilkan Screenshot: Form Panduan Layanan]

### 4.6.2 Menindaklanjuti Pengajuan Warga

1. Pilih **Pemerintahan & Profil → Pengajuan Layanan**.
2. Cari pengajuan berstatus **Pending**.
3. Buka/edit pengajuan.
4. Periksa:
   - Jenis layanan.
   - Nama warga.
   - NIK.
   - Alamat.
   - Nomor WhatsApp.
   - Lampiran.
5. Unduh lampiran jika diperlukan.
6. Hubungi warga melalui WhatsApp.
7. Ubah status menjadi **Diproses**.
8. Setelah selesai, ubah status menjadi **Selesai**.

[📷 Tampilkan Screenshot: Tabel Pengajuan dan Kolom Status]

[📷 Tampilkan Screenshot: Detail Pengajuan dan Lampiran]

## 4.7 Kelola Profil dan Dokumen Desa

### Profil Desa

- Visi.
- Misi.
- Struktur organisasi.
- Kontak desa.

[📷 Tampilkan Screenshot: Form Profil Desa]

### Produk Hukum & Dokumen

- Judul peraturan.
- Nomor dan tahun.
- Kategori.
- Keterangan.
- Dokumen PDF.

[📷 Tampilkan Screenshot: Form Produk Hukum dan Upload PDF]

### Potensi Desa

- Judul Bahasa Indonesia.
- Judul Bahasa Jepang.
- Konten Bahasa Indonesia.
- Konten Bahasa Jepang.
- Gambar potensi.

[📷 Tampilkan Screenshot: Form Potensi Desa Bilingual]

## 4.8 Kelola Fasilitas dan Kesehatan

### Fasilitas Publik

1. Pilih **Fasilitas & Kesehatan → Fasilitas Publik**.
2. Isi nama dan kategori fasilitas.
3. Tempel kode embed Google Maps.
4. Isi keterangan.
5. Simpan dan periksa halaman publik.

[📷 Tampilkan Screenshot: Form Fasilitas Publik dan Google Maps Embed]

### Kesehatan & Posyandu

Resource admin yang tersedia saat ini mengelola:

- Nama Posyandu.
- Tanggal pelaksanaan.
- Jam mulai dan selesai.
- Informasi PHBS.
- Kontak bidan.

[📷 Tampilkan Screenshot: Form Kesehatan & Posyandu]

> **Catatan implementasi saat ini:** Halaman Posyandu publik menampilkan profil bidan, kader, edukasi, dan galeri dari tabel konten khusus. Menu admin yang tersedia belum mengelola keempat konten tersebut secara langsung. Hubungi pengelola teknis jika perlu mengubah profil bidan, daftar kader, materi edukasi, atau galeri.

## 4.9 Kelola Pemberdayaan dan UMKM Lainnya

### Template Pembukuan

- Nama template.
- Deskripsi.
- Upload file template.

[📷 Tampilkan Screenshot: Form Template Pembukuan]

### Panduan Pertanian

- Nama alat.
- Panduan perawatan.
- Tips keamanan.

[📷 Tampilkan Screenshot: Form Panduan Pertanian]

### Panduan Pajak

- Kategori UMKM.
- Tarif/informasi pajak.
- Alur pajak.

[📷 Tampilkan Screenshot: Form Panduan Pajak]

### Jadwal Pajak

- Judul kegiatan.
- Tanggal.
- Keterangan.
- Penanda rutinitas bulanan.

[📷 Tampilkan Screenshot: Form Jadwal Pajak]

### FAQ

- Kategori UMKM atau Pajak.
- Pertanyaan.
- Jawaban.
- Urutan tampilan.

[📷 Tampilkan Screenshot: Form FAQ]

## 4.10 Kelola Buku Transaksi UMKM

Menu ini digunakan admin untuk melihat dan mengoreksi transaksi milik akun UMKM.

Data yang dikelola:

- Pemilik akun.
- Jenis buku.
- Tanggal.
- Keterangan/produk.
- Kategori.
- Jenis transaksi.
- Qty.
- Harga satuan.
- Nominal.
- Status.
- Catatan.

[📷 Tampilkan Screenshot: Tabel Buku Transaksi UMKM]

> Transaksi baru normalnya dibuat oleh pemilik akun melalui halaman Pembukuan. Resource admin tidak menyediakan halaman tambah transaksi baru.

## 4.11 Kelola Akun Portal

### Membuat Akun UMKM

1. Pilih **Sistem → Akun Portal**.
2. Tekan **Tambah Akun**.
3. Isi nama.
4. Isi email unik.
5. Pilih role **UMKM**.
6. Buat kata sandi awal yang kuat.
7. Simpan.
8. Sampaikan kredensial kepada pemilik melalui jalur aman.
9. Minta pengguna menjaga kerahasiaan kata sandi.

[📷 Tampilkan Screenshot: Form Tambah Akun UMKM]

### Membuat Akun Admin

Gunakan prosedur yang sama, tetapi pilih role **Admin**. Berikan role admin hanya kepada petugas yang benar-benar berwenang.

[📷 Tampilkan Screenshot: Pilihan Role Admin dan UMKM]

> Admin yang sedang login tidak dapat menghapus akun dirinya sendiri melalui aksi tabel.

## 4.12 Logout Admin

1. Buka menu akun pada panel.
2. Pilih **Sign out/Logout**.
3. Pastikan halaman kembali ke login atau portal publik.

[📷 Tampilkan Screenshot: Menu Logout Admin]

---

# BAB 5: TROUBLESHOOTING & FAQ

## 5.1 Web Tidak Bisa Dibuka

### Gejala

- Halaman kosong.
- Pesan server tidak ditemukan.
- Loading tidak selesai.
- Browser menampilkan tidak ada internet.

### Solusi

1. Periksa apakah mode pesawat aktif.
2. Periksa Wi-Fi atau data seluler.
3. Coba buka situs lain.
4. Pastikan alamat portal benar.
5. Tutup lalu buka kembali browser.
6. Coba browser lain yang didukung.
7. Nyalakan ulang perangkat.
8. Jika tetap gagal pada beberapa perangkat, hubungi pengelola teknis karena server atau domain mungkin bermasalah.

[📷 Tampilkan Screenshot: Contoh Pesan Koneksi Gagal pada Browser]

## 5.2 Halaman Offline Umum Tampil

Jika muncul halaman **Portal Desa belum dapat terhubung**:

1. Tekan **Coba Hubungkan Kembali** setelah sinyal tersedia.
2. Tekan **Kembali ke Beranda** untuk menuju halaman utama yang telah disiapkan offline.
3. Tekan **Kembali ke Halaman Sebelumnya** untuk kembali ke halaman sebelumnya.

[📷 Tampilkan Screenshot: Halaman Offline dan Tiga Tombol Navigasi]

## 5.3 Menu Dicoret dan Memiliki Ikon Gembok

Ini bukan kerusakan. Tanda tersebut berarti halaman belum disiapkan untuk dibuka tanpa internet.

1. Pilih halaman tanpa ikon gembok.
2. Atau tunggu koneksi kembali.
3. Setelah online, tanda akan hilang otomatis.

[📷 Tampilkan Screenshot: Navbar dalam Mode Offline]

## 5.4 Data Offline Belum Tersinkron

### Pemeriksaan Awal

1. Pastikan badge sudah berubah menjadi 🟢.
2. Pastikan akun admin masih login.
3. Biarkan portal terbuka selama beberapa saat.
4. Jangan membersihkan data browser.
5. Periksa apakah badge Antrean Sync berkurang.

### Jika Masih Belum Berhasil

1. Buka ulang portal saat online.
2. Login kembali sebagai admin jika sesi kedaluwarsa.
3. Buka Dashboard atau halaman Tambah UMKM.
4. Tunggu proses sinkronisasi otomatis.
5. Periksa toast pada layar.
6. Jika toast menyatakan sinkronisasi tertunda, jangan hapus data situs.
7. Catat jumlah antrean dan hubungi pengelola teknis.

[📷 Tampilkan Screenshot: Antrean Sync yang Belum Selesai]

> Sertakan informasi perangkat, browser, waktu kejadian, dan screenshot saat melapor.

## 5.5 Data Offline Hilang

Data lokal dapat hilang jika:

- Data situs dibersihkan.
- Browser dihapus/reset.
- PWA dicopot beserta data situs.
- Pendataan dilakukan pada mode incognito.
- Penyimpanan perangkat rusak atau penuh.

Jika data telah terhapus dari IndexedDB sebelum sync, data tidak dapat dipulihkan oleh server. Lakukan pendataan ulang dari catatan lapangan yang tersedia.

## 5.6 Login Gagal

1. Pastikan email ditulis benar.
2. Pastikan Caps Lock tidak aktif.
3. Coba ketik ulang kata sandi.
4. Jangan mencoba berulang kali secara cepat karena login memiliki pembatasan.
5. Hubungi admin utama untuk reset kata sandi.

[📷 Tampilkan Screenshot: Pesan Email atau Kata Sandi Tidak Sesuai]

## 5.7 Akun UMKM Tidak Bisa Masuk Panel Admin

Hal ini sesuai desain sistem. Akun UMKM hanya diarahkan ke Pembukuan. Panel Filament hanya dapat dibuka oleh akun ber-role Admin.

## 5.8 Berita Belum Tampil

Periksa:

- Toggle **Terbitkan Langsung** aktif.
- Waktu terbit tidak berada di masa depan.
- Slug valid dan unik.
- Data telah disimpan.

## 5.9 Pengajuan Warga Masuk tetapi Email Tidak Diterima

Pengajuan tetap disimpan walaupun notifikasi email gagal. Admin harus memeriksa menu **Pengajuan Layanan** secara berkala.

## 5.10 Peta atau Video Tidak Tampil

1. Pastikan perangkat online.
2. Nonaktifkan pemblokir konten sementara jika diizinkan.
3. Muat ulang halaman.
4. Coba browser lain.
5. Jika hanya satu sumber yang gagal, tautan atau izin sumber eksternal mungkin berubah.

## 5.11 File Tidak Bisa Diunduh

1. Pastikan browser mengizinkan unduhan.
2. Pastikan ruang penyimpanan cukup.
3. Coba tekan dan tahan tautan pada HP lalu pilih unduh.
4. Periksa folder Downloads/Unduhan.
5. Pastikan file masih tersedia di server.

## 5.12 PWA Tidak Menampilkan Opsi Install

1. Pastikan portal dibuka melalui HTTPS.
2. Gunakan browser yang didukung.
3. Tunggu halaman selesai dimuat.
4. Buka portal lebih dari satu kali jika diperlukan.
5. Periksa menu browser untuk opsi **Tambahkan ke layar utama**.
6. Pada iPhone, gunakan Safari dan menu Share.
7. Jika aplikasi sudah terpasang, opsi install mungkin tidak tampil lagi.

## 5.13 PWA Masih Menampilkan Tampilan Lama

1. Sambungkan perangkat ke internet.
2. Tutup seluruh tab portal.
3. Buka kembali portal.
4. Lakukan refresh satu kali.
5. Tunggu Service Worker memeriksa pembaruan.
6. Jika masih lama, hubungi pengelola teknis sebelum menghapus data situs, terutama jika terdapat antrean sync.

## 5.14 FAQ Singkat

### Apakah masyarakat harus login untuk membaca informasi?

Tidak. Sebagian besar halaman informasi dapat dibuka tanpa akun.

### Apakah masyarakat harus login untuk mengajukan layanan?

Tidak, tetapi pengiriman form memerlukan internet dan data identitas yang valid.

### Apakah pembukuan dapat digunakan tanpa akun?

Ya. Namun data hanya disimpan di browser perangkat tersebut dan tidak masuk ke server desa.

### Apa keuntungan akun UMKM?

Transaksi pembukuan tersimpan pada server dan terkait dengan akun pengguna.

### Apakah data pembukuan tamu otomatis pindah setelah login?

Tidak. Ekspor CSV sebelum beralih perangkat atau membersihkan browser.

### Apakah semua halaman dapat dibuka offline?

Tidak. Hanya route yang telah disiapkan oleh Service Worker. Konten eksternal juga tetap dapat membutuhkan internet.

### Siapa yang dapat memasukkan data UMKM secara offline?

Administrator/kader/perangkat desa yang login menggunakan akun ber-role Admin dan telah membuka form Tambah UMKM ketika masih online.

### Apakah data offline dapat terkirim dua kali?

Server menggunakan identitas sinkronisasi unik untuk mencegah duplikasi ketika batch yang sama dikirim ulang.

### Berapa banyak data yang dapat dikirim dalam satu batch sync?

Server menerima maksimal 100 record dalam satu batch.

### Apa yang harus dilakukan jika sesi admin habis sebelum sync?

Login kembali sebagai admin ketika online, buka portal, dan tunggu sinkronisasi dicoba kembali.

---

# LAMPIRAN

## Lampiran A: Daftar Halaman Portal

| Halaman | Alamat | Akses | Disiapkan offline |
|---|---|---|---|
| Beranda | `/` | Publik | Ya |
| Kabar Desa | `/berita` | Publik | Ya, daftar berita |
| Detail Berita | `/berita/{slug}` | Publik | Tidak dalam allowlist utama |
| Profil Desa | `/profil` | Publik | Ya |
| Layanan Desa | `/layanan` | Publik | Ya, pengiriman form tetap online |
| Fasilitas Publik | `/fasilitas` | Publik | Tidak |
| Pertanian | `/pertanian` | Publik | Tidak |
| Pembukuan | `/pembukuan` | Publik/Akun UMKM | Ya |
| Direktori UMKM | `/umkm` | Publik | Ya |
| Pajak | `/pajak` | Publik | Tidak |
| Potensi Desa | `/potensi` | Publik | Tidak |
| Posyandu | `/posyandu` | Publik | Ya |
| Login Umum | `/login` | Publik | Memerlukan internet |
| Panel Admin | `/admin` | Admin | Tidak diprecache sebagai halaman publik |

## Lampiran B: Daftar Menu Panel Administrator

### Pemerintahan & Profil

- Profil Desa.
- Panduan Layanan.
- Pengajuan Layanan.
- Produk Hukum & Dokumen.
- Potensi Desa.

### Kabar & Informasi

- Berita & Kabar Desa.
- Pertanyaan Umum (FAQ).

### Fasilitas & Kesehatan

- Fasilitas Publik.
- Kesehatan & Posyandu.

### Pemberdayaan & UMKM

- Direktori UMKM.
- Buku Transaksi UMKM.
- Template Pembukuan.
- Panduan Pertanian.
- Panduan Pajak.
- Jadwal Pajak.

### Sistem

- Akun Portal.

## Lampiran C: Formulir Checklist Pendataan UMKM Offline

### Sebelum Berangkat

- [ ] Perangkat telah terisi daya.
- [ ] PWA telah dipasang.
- [ ] Admin berhasil login.
- [ ] Form Tambah UMKM telah dibuka.
- [ ] Antrean lama telah tersinkron.
- [ ] Petugas membawa sumber data/catatan pendataan.

### Untuk Setiap UMKM

- [ ] Nama usaha.
- [ ] Nama pemilik.
- [ ] Jenis usaha.
- [ ] Dukuh.
- [ ] RT/RW dicatat pada catatan lapangan.
- [ ] Alamat lengkap.
- [ ] Bentuk usaha.
- [ ] Nomor HP.
- [ ] Data berhasil masuk antrean.

### Setelah Kembali Online

- [ ] Badge berubah 🟢.
- [ ] Toast sinkronisasi berhasil muncul.
- [ ] Antrean Sync kembali nol/hilang.
- [ ] Data ditemukan pada tabel UMKM.
- [ ] RT/RW dilengkapi.
- [ ] Deskripsi dilengkapi.
- [ ] Koordinat dilengkapi.
- [ ] Foto dilengkapi.
- [ ] Data diperiksa pada halaman publik.

[📷 Tampilkan Screenshot: Contoh Checklist Pendataan yang Telah Diisi]

## Lampiran D: Data yang Disiapkan untuk Pelaporan Gangguan

Saat menghubungi pengelola teknis, siapkan:

1. Nama petugas.
2. Nomor kontak.
3. Jenis perangkat.
4. Sistem operasi.
5. Nama dan versi browser.
6. Alamat halaman yang bermasalah.
7. Tanggal dan waktu kejadian.
8. Status koneksi 🟢 atau 🟡.
9. Jumlah Antrean Sync.
10. Screenshot pesan kesalahan.
11. Langkah yang dilakukan sebelum masalah terjadi.

## Lampiran E: Glosarium

| Istilah | Arti |
|---|---|
| PWA | Aplikasi web yang dapat dipasang pada perangkat seperti aplikasi biasa |
| Service Worker | Komponen browser yang mengatur cache, offline fallback, dan proses background |
| Cache | Salinan halaman/aset yang disimpan agar dapat dimuat lebih cepat atau offline |
| IndexedDB | Penyimpanan lokal browser yang digunakan untuk antrean UMKM offline |
| Local Storage | Penyimpanan browser yang digunakan pembukuan mode tamu |
| Antrean Sync | Daftar data lokal yang belum berhasil dikirim ke server |
| Auto-Sync | Pengiriman data otomatis ketika koneksi kembali tersedia |
| Filament | Panel administrator untuk mengelola data Portal Desa |
| Role | Jenis hak akses pengguna, misalnya Admin atau UMKM |
| CSV | Format file tabel yang dapat dibuka dengan aplikasi spreadsheet |
| Slug | Bagian alamat URL yang mewakili judul berita |

---

## Penutup

Portal Resmi Desa Pringanom diharapkan membantu masyarakat memperoleh informasi dan layanan secara lebih mudah, sekaligus mendukung perangkat desa dalam mengelola data secara tertib. Gunakan portal sesuai kewenangan, jaga kerahasiaan akun, dan pastikan seluruh data lapangan telah tersinkron sebelum membersihkan atau mengganti perangkat.

Apabila terdapat perbedaan tampilan akibat pembaruan aplikasi, ikuti istilah menu terbaru yang muncul pada layar dan hubungi pengelola teknis jika prosedur tidak dapat diselesaikan.

[📷 Tampilkan Screenshot: Halaman Penutup dengan Identitas Pemerintah Desa Pringanom]

---

**Kontak Pengelola Portal:** `[Nama/Unit Pengelola]`  
**Nomor WhatsApp:** `[Nomor WhatsApp Pengelola]`  
**Email:** `[Email Pengelola]`  
**Alamat Kantor Desa:** `[Alamat Kantor Desa Pringanom]`
