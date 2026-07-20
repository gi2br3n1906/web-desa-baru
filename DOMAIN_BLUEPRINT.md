# Cetak Biru Domain & Skema Database

Berikut adalah rancangan tabel database untuk mengakomodasi 8 kebutuhan konten website desa.

## 1. Tabel: `village_profiles` (Ilmu Pemerintahan)
- `id` (Primary Key)
- `visi` (Text)
- `misi` (Text)
- `struktur_organisasi_path` (String, image path)
- `kontak_desa` (Json / String)

## 2. Tabel: `admin_services` (Hukum)
- `id` (Primary Key)
- `nama_layanan` (String, ex: "Pembuatan SKCK")
- `persyaratan` (Text, markdown/list format)
- `alur_pengurusan` (Text)

## 3. Tabel: `public_facilities` (Teknik Sipil)
- `id` (Primary Key)
- `nama_fasilitas` (String)
- `kategori` (Enum: kantor, sekolah, ibadah, kesehatan, infrastruktur)
- `google_maps_embed` (Text, nullable)
- `keterangan` (String, nullable)

## 4. Tabel: `agriculture_guides` (Teknik Mesin)
- `id` (Primary Key)
- `nama_alat` (String, ex: "Traktor Quick")
- `panduan_perawatan` (Text)
- `tips_keamanan` (Text)

## 5. Tabel: `accounting_templates` (Akuntansi)
- `id` (Primary Key)
- `nama_template` (String)
- `deskripsi` (String)
- `file_path` (String, jalur unduhan file Excel/.xlsx)

## 6. Tabel: `tax_guides` (Akuntansi Perpajakan)
- `id` (Primary Key)
- `kategori_umkm` (String)
- `alur_pajak` (Text)
- `tarif_informasi` (String)

## 7. Tabel: `village_potentials` (Bahasa & Kebudayaan Jepang)
- `id` (Primary Key)
- `title_id` (String)
- `title_jp` (String)
- `content_id` (Text)
- `content_jp` (Text)
- `image_path` (String, nullable)

## 8. Tabel: `posyandu_schedules` (Kesehatan Masyarakat)
- `id` (Primary Key)
- `nama_posyandu` (String)
- `tanggal_pelaksanaan` (Date)
- `jam_mulai` (Time)
- `jam_selesai` (Time)
- `informasi_phbs` (Text)
- `kontak_bidan` (String)