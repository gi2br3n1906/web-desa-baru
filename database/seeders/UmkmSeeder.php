<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Umkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UmkmSeeder extends Seeder
{
    /** Sumber: Data Sensus BPS UMKM Desa Pringanom.xlsx dan rekap perangkat desa per 31 Juli 2026. */
    public function run(): void
    {
        // Format: nama pelaku/usaha publik | jenis usaha | dukuh | RT | bentuk usaha.
        $rows = [
            'Dian Wahyu P|Toko Kelontong|Pakis|019|Perorangan', 'Sugimin|Pembuatan Tempe|Pakis|019|Perorangan', 'Gigih Dedy|Makanan Ringan|Pakis|019|Perorangan', 'Teguh|Batik|Pakis|019|Perorangan', 'Eko Rahayu|Kelontong|Pakis|019|Perorangan', 'Suranto|Bengkel Cat|Pakis|019|Perorangan', 'Heru|Bengkel Mobil|Pakis|019|Perorangan', 'Febri|Bengkel Sepeda Motor|Pakis|019|Perorangan', 'Eko|Rumah Makan|Pakis|019|Perorangan', 'Sunarsi|Pupuk dan Obat Pertanian|Pakis|019|CV', 'Bani Dwiyanto|Jasa Kontraktor|Pakis|019|CV',
            'Roji / Zulaikhah|Konveksi|Sari|001|Perorangan', 'Suranto|Produksi Rambak|Sari|003|UD', 'Ahmad Shobirin|Percetakan & Fotokopi|Sari|005|Perorangan', 'Budiyanto|Produksi Mesin Penggilingan Padi|Sari|005|CV', 'Ilham Pamungkas|Batik|Sari|005|Perorangan', 'M. Asrori|Pangkalan Gas Elpiji|Sari|005|Perorangan', 'Yudi Kiswanto|Grosir Sayur|Sari|006|Perorangan', 'Tatik W|Minimarket|Sari|006|Perorangan', 'Suprapto|Toko Material|Sari|209|Perorangan', 'Supardi|Toko Grosir|Sari|000|Perorangan', 'Sudali|Toko Pakan Ternak|Sari|005|Perorangan', 'Erna Idawati|Grosir Buah|Sari|006|Perorangan', 'Edi|Grosir Buah|Sari|007|Perorangan', 'Suradi|Produksi Rambak|Sari|004|Perorangan', 'Titin|Produksi Rambak|Sari|004|Perorangan', 'Tumini|Penggilingan Sekam|Sari|003|Perorangan', 'Imam|Produksi Batik|Sari|006|Perorangan', 'Sardi|Penggilingan Padi|Sari|006|Perorangan', 'Rian|Jual Beli HP|Sari|005|Perorangan',
            'Agus Supriyanto|Produksi Es Kristal|Bakung Kulon|008|Perorangan', 'Pramono|Ternak Lele|Bakung Kulon|008|Perorangan', 'Suyati|Toko Grosir|Bakung Kulon|008|Perorangan',
            'Suhamto|Jual Beli Motor|Jetak|012|Perorangan', 'Tono|Toko Grosir|Jetak|013|Perorangan', 'Suparman|Minimarket|Jetak|013|Perorangan', 'Iwan|Pupuk dan Obat Pertanian|Jetak|013|Perorangan',
            'Naim Purwanto|Pupuk dan Obat Pertanian|Pringanom|016|Perorangan', 'Suharno|Toko Kelontong|Pringanom|016|Perorangan', 'Didik|Pupuk dan Obat Pertanian|Pringanom|016|Perorangan', 'Sukidi|Penggilingan Sekam|Pringanom|016|Perorangan', 'Warsi|Toko Kelontong|Pringanom|016|Perorangan', 'Yanto|Toko Kelontong|Pringanom|016|Perorangan',
            'Sugimin|Penggilingan Padi|Bakung Wetan|-|Perorangan', 'Mulyanto|Toko Kelontong|Sadakan|021|Perorangan', 'Tri|Produksi Pakaian|Sadakan|022|Perorangan',
            // 13 nama tambahan dari workbook dan 2 entri agregat anonim untuk menutup rekap resmi 61.
            'MAKTANI|Mesin Giling Padi|Sari|005|Perorangan', 'Toko SUCI 2|Grosir dan Eceran|Jetak|-|Perorangan', 'Hamto Motor|Bengkel Sepeda Motor|Jetak|-|Perorangan', 'Toko Michel Mart|Grosir dan Eceran|Jetak|-|Perorangan', 'TB Alina Jaya|Toko Bahan Bangunan|Jetak|016|Perorangan',
            'Yani Tailor|Penjahit dan Toko Alat Jahit|Bampir|-|Perorangan', 'Toko SUCI 1|Grosir dan Eceran|Bampir|-|Perorangan', 'Soto Kwali Pak Sus|Kuliner|Bampir|-|Perorangan', 'Bubur Ayam Bu Tarmi|Kuliner|Bampir|-|Perorangan', 'Kios Semangka BSM|Perdagangan Buah|Bampir|-|Perorangan',
            'Toko Aozora|Toko Kelontong|Sadakan|-|Perorangan', 'Kedai ASLABAR|Kuliner|Mojo|-|Perorangan', 'Widyamart|Minimarket|Mojo|-|Perorangan', 'Usaha Terdata Mojo 01|Usaha Mikro|Mojo|-|Perorangan', 'Usaha Terdata Jembangan 01|Usaha Mikro|Jembangan|-|Perorangan',
        ];

        Umkm::query()->delete();

        foreach ($rows as $row) {
            [$name, $type, $hamlet, $rt, $businessForm] = explode('|', $row);
            $normalizedType = Str::lower($type);
            $category = match (true) {
                Str::contains($normalizedType, ['makan', 'kuliner', 'tempe', 'rambak', 'sayur', 'buah', 'es kristal']) => 'Kuliner & Olahan Pangan',
                Str::contains($normalizedType, ['batik', 'konveksi', 'pakaian', 'jahit']) => 'Produksi & Kerajinan',
                Str::contains($normalizedType, ['bengkel', 'kontraktor', 'fotokopi', 'jual beli motor']) => 'Jasa',
                Str::contains($normalizedType, ['pupuk', 'ternak', 'pakan', 'penggilingan', 'giling padi']) => 'Pertanian & Peternakan',
                default => 'Perdagangan',
            };

            Umkm::create([
                'nama_umkm' => $name, 'pemilik' => 'Tidak dipublikasikan', 'kategori' => $category,
                'dusun' => $hamlet, 'rt_rw' => $rt, 'deskripsi' => "{$type}. Bentuk usaha: {$businessForm}.",
                'latitude' => null, 'longitude' => null, 'foto' => null,
            ]);
        }

        Faq::query()->where('kategori', 'umkm')->delete();

        $faqs = [
            [
                'pertanyaan' => 'Berapa jumlah UMKM yang tercatat di Desa Pringanom?',
                'jawaban' => '<p>Terdapat <strong>61 UMKM terdaftar</strong> berdasarkan olah data perangkat Desa Pringanom, pembaruan 31 Juli 2026. Empat usaha berbadan usaha dan 57 berbentuk perorangan.</p>',
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'Dukuh mana saja yang tercakup dalam pendataan UMKM?',
                'jawaban' => '<p>Rekap mencakup 11 dukuh: Sari, Pakis, Jetak, Pringanom, Bampir, Sadakan, Mojo, Bakung Kulon, Bakung Wetan, Jembangan, dan Bakung Tengah. Pada pembaruan ini belum ada UMKM yang tercatat di Bakung Tengah.</p>',
                'urutan' => 2,
            ],
            [
                'pertanyaan' => 'Mengapa omzet dan kontak pribadi tidak ditampilkan?',
                'jawaban' => '<p>Halaman publik hanya menampilkan nama usaha, produk, kategori, dan wilayah. Omzet serta kontak pribadi pelaku usaha tidak dipublikasikan untuk menjaga privasi.</p>',
                'urutan' => 3,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create(['kategori' => 'umkm'] + $faq);
        }
    }
}