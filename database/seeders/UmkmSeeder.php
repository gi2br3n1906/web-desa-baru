<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Umkm;
use Illuminate\Database\Seeder;

class UmkmSeeder extends Seeder
{
    /** Sumber: contoh tampilan web Pojok UMKM dan Pajak dan ringkasan Sensus BPS 2024. */
    public function run(): void
    {
        $businesses = [
            ['nama_umkm' => 'Dapur Bu Ratmi', 'kategori' => 'Kuliner & Olahan Pangan', 'dusun' => 'Pringanom', 'deskripsi' => 'Katering nasi kotak dan olahan ayam untuk hajatan warga.'],
            ['nama_umkm' => 'Kerupuk Rambak Pak Sunar', 'kategori' => 'Kuliner & Olahan Pangan', 'dusun' => 'Bakung Kulon', 'deskripsi' => 'Produksi kerupuk rambak sapi dalam kemasan siap jual.'],
            ['nama_umkm' => 'Warung Sembako Mekar Jaya', 'kategori' => 'Warung & Sembako', 'dusun' => 'Jetak', 'deskripsi' => 'Menyediakan kebutuhan pokok harian, gas LPG, dan pulsa elektrik.'],
            ['nama_umkm' => 'Konveksi Barokah', 'kategori' => 'Kerajinan', 'dusun' => 'Sari', 'deskripsi' => 'Jasa jahit seragam sekolah dan pakaian batik custom.'],
            ['nama_umkm' => 'Bengkel Motor Sumber Rejeki', 'kategori' => 'Jasa', 'dusun' => 'Mojo', 'deskripsi' => 'Servis dan penjualan onderdil sepeda motor.'],
            ['nama_umkm' => 'Salon Ayu Kencana', 'kategori' => 'Jasa', 'dusun' => 'Bakung Tengah', 'deskripsi' => 'Perawatan rambut, rias pengantin, dan pijat.'],
            ['nama_umkm' => 'Abon Lele Makmur', 'kategori' => 'Pertanian & Peternakan', 'dusun' => 'Jembangan', 'deskripsi' => 'Budidaya lele dan produksi olahan abon siap konsumsi.'],
            ['nama_umkm' => 'Tempe Pak Slamet', 'kategori' => 'Pertanian & Peternakan', 'dusun' => 'Pakis Kulon', 'deskripsi' => 'Produksi tempe kedelai harian untuk pasar dan warung.'],
            ['nama_umkm' => 'Toko Bangunan Sadakan Jaya', 'kategori' => 'Perdagangan Lainnya', 'dusun' => 'Sadakan', 'deskripsi' => 'Menyediakan material bangunan, cat, dan peralatan pertukangan.'],
        ];

        foreach ($businesses as $business) {
            Umkm::updateOrCreate(
                ['nama_umkm' => $business['nama_umkm']],
                $business + [
                    'pemilik' => 'Tidak dipublikasikan',
                    'rt_rw' => '-',
                    'latitude' => null,
                    'longitude' => null,
                    'foto' => null,
                ],
            );
        }

        $faqs = [
            [
                'pertanyaan' => 'Berapa jumlah UMKM yang tercatat dalam Sensus BPS 2024 Desa Pringanom?',
                'jawaban' => '<p>Terdapat <strong>187 UMKM terdaftar</strong> dengan rata-rata usia usaha 9 tahun. Sebanyak 16 usaha berbadan usaha atau berbentuk kelompok.</p>',
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'Dukuh mana saja yang tercakup dalam pendataan UMKM?',
                'jawaban' => '<p>Pendataan mencakup 11 dukuh: Pringanom, Bakung Kulon, Jetak, Sari, Mojo, Bakung Tengah, Jembangan, Pakis Kulon, Sadakan, Bakung Wetan, dan Bampir.</p>',
                'urutan' => 2,
            ],
            [
                'pertanyaan' => 'Mengapa omzet dan kontak pribadi tidak ditampilkan?',
                'jawaban' => '<p>Halaman publik hanya menampilkan nama usaha, produk, kategori, dan wilayah. Omzet serta kontak pribadi pelaku usaha tidak dipublikasikan untuk menjaga privasi.</p>',
                'urutan' => 3,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['kategori' => 'umkm', 'pertanyaan' => $faq['pertanyaan']],
                ['jawaban' => $faq['jawaban'], 'urutan' => $faq['urutan']],
            );
        }
    }
}