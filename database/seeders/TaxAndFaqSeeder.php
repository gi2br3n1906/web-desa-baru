<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\TaxGuide;
use App\Models\TaxSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TaxAndFaqSeeder extends Seeder
{
    /** Sumber: Data Website/Pojok UMKM dan Pajak/contoh tampilan web pojok umkm dan pajak.pdf. */
    public function run(): void
    {
        $faqs = [
            ['Apa itu PPh Final UMKM 0,5%?', '<p>PPh Final UMKM adalah pajak penghasilan final sebesar <strong>0,5% dari omzet bulanan</strong> berdasarkan PP 55/2022, untuk pelaku usaha dengan omzet sampai Rp4,8 miliar per tahun.</p>', 1],
            ['Apakah semua UMKM orang pribadi wajib membayar PPh Final?', '<p>Tidak. Untuk orang pribadi, omzet sampai dengan <strong>Rp500 juta per tahun dibebaskan</strong> dari PPh Final. Pajak baru dihitung atas bagian omzet di atas batas tersebut.</p>', 2],
            ['Berapa lama tarif final 0,5% dapat digunakan?', '<p>Maksimal 7 tahun untuk orang pribadi, 4 tahun untuk koperasi/CV/firma, dan 3 tahun untuk PT, dihitung sejak mengikuti ketentuan ini.</p>', 3],
            ['Kapan batas waktu lapor SPT Tahunan?', '<p>SPT Tahunan wajib pajak orang pribadi paling lambat <strong>31 Maret</strong> tahun berikutnya, sedangkan badan usaha paling lambat <strong>30 April</strong>.</p>', 4],
            ['Bagaimana cara mengurus NPWP dan NIB usaha baru?', '<p>NIB diajukan secara daring melalui OSS (Online Single Submission), sedangkan NPWP diajukan melalui administrasi perpajakan/KPP Pratama setempat. Konfirmasikan persyaratan terbaru kepada petugas pajak.</p>', 5],
        ];

        foreach ($faqs as [$question, $answer, $order]) {
            Faq::updateOrCreate(
                ['kategori' => 'pajak', 'pertanyaan' => $question],
                ['jawaban' => $answer, 'urutan' => $order],
            );
        }

        $guides = [
            [
                'kategori_umkm' => 'UMKM Orang Pribadi',
                'tarif_informasi' => '0,5% di atas omzet Rp500 juta/tahun',
                'alur_pajak' => '<ol><li>Catat omzet usaha setiap bulan.</li><li>Akumulasikan omzet sejak awal tahun.</li><li>Bagian omzet sampai Rp500 juta per tahun bebas PPh Final.</li><li>Hitung 0,5% atas bagian omzet yang dikenai pajak.</li><li>Setor dan laporkan sesuai ketentuan yang berlaku.</li></ol><p>Masa penggunaan tarif final maksimal 7 tahun. Konfirmasikan ketentuan terbaru kepada KPP setempat.</p>',
            ],
            [
                'kategori_umkm' => 'Koperasi, CV, dan Firma',
                'tarif_informasi' => 'PPh Final 0,5% · maksimal 4 tahun',
                'alur_pajak' => '<ol><li>Rekap omzet bulanan.</li><li>Hitung PPh Final sebesar 0,5% dari omzet yang memenuhi ketentuan.</li><li>Setor paling lambat sesuai jadwal perpajakan.</li><li>Laporkan SPT Tahunan Badan paling lambat 30 April.</li></ol>',
            ],
            [
                'kategori_umkm' => 'Perseroan Terbatas (PT)',
                'tarif_informasi' => 'PPh Final 0,5% · maksimal 3 tahun',
                'alur_pajak' => '<ol><li>Rekap omzet dan dokumen transaksi.</li><li>Hitung dan setor pajak sesuai ketentuan PPh Final UMKM.</li><li>Laporkan SPT Tahunan Badan paling lambat 30 April.</li></ol><p>Masa penggunaan tarif final untuk PT maksimal 3 tahun.</p>',
            ],
        ];

        foreach ($guides as $guide) {
            TaxGuide::updateOrCreate(['kategori_umkm' => $guide['kategori_umkm']], $guide);
        }

        $year = (int) now()->year;
        $month = (int) now()->month;
        $schedules = [
            ['Setor PPh Final UMKM', Carbon::create($year, $month, 10), 'Atas omzet bulan sebelumnya.', true],
            ['Lapor setoran bulanan', Carbon::create($year, $month, 20), 'Dilakukan bila diwajibkan lapor terpisah.', true],
            ['Lapor SPT Tahunan Orang Pribadi', Carbon::create($year, 3, 31), 'Batas pelaporan untuk pelaku usaha perorangan.', false],
            ['Lapor SPT Tahunan Badan', Carbon::create($year, 4, 30), 'Batas pelaporan untuk usaha CV, PT, koperasi, dan badan lainnya.', false],
        ];

        foreach ($schedules as [$title, $date, $description, $monthly]) {
            TaxSchedule::updateOrCreate(
                ['judul_kegiatan' => $title],
                ['tanggal' => $date->toDateString(), 'keterangan' => $description, 'is_routine_monthly' => $monthly],
            );
        }
    }
}