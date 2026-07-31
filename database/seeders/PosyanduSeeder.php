<?php

namespace Database\Seeders;

use App\Models\PosyanduSchedule;
use App\Models\PublicFacility;
use Illuminate\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    /** Sumber: Data Website/Posyandu/DATA POSYANDU.xlsx. */
    public function run(): void
    {
        $bidan = 'Iis Nurdianawati (Bidan Desa)';
        $generalInformation = <<<'HTML'
<p><strong>Bidan Desa:</strong> Iis Nurdianawati, penanggung jawab pembinaan dan pendampingan seluruh kader Posyandu di Desa Pringanom.</p>
<h4>Materi PHBS</h4>
<ul>
    <li><a href="https://drive.google.com/file/d/1iaTNqtK1mPTc1eUWoX1fxxn7CbQNvWZt/view?usp=sharing" target="_blank" rel="noopener">Gomibunbetsu — budaya pemilahan sampah</a></li>
    <li><a href="https://drive.google.com/file/d/1lQwO1s1KLt2Ve19Rer8bMAHs5PCnTITq/view?usp=sharing" target="_blank" rel="noopener">Leptospirosis dan PHBS pada petani</a></li>
    <li><a href="https://drive.google.com/file/d/1Hzg9rAPvq2O_RrAqCP0Ggw-7020gTJh9/view?usp=sharing" target="_blank" rel="noopener">Jangan anggap remeh sampah</a></li>
</ul>
HTML;

        $structureXi = <<<'HTML'
<h4>Struktur Posyandu Sari Mulyo XI Tahun 2026</h4>
<ul>
    <li>Ketua: Sri Mulyani</li><li>Sekretaris: Tri Wahyuni</li><li>Bendahara: Sunarsi</li>
    <li>Ketua Bidang Pendidikan: Triana Puji Lestari</li><li>Ketua Bidang Kesehatan: Ike Susanti</li>
    <li>Anggota Bidang Kesehatan: Umi Farida</li><li>Ketua Bidang Pekerjaan Umum: Suryani</li>
    <li>Ketua Bidang Sosial: Bp. Diyono</li><li>Ketua Bidang Trantibumlinmas: Bp. Alex Sangidi</li>
    <li>Ketua Bidang Perumahan Rakyat: Bp. Sukimin</li>
</ul>
HTML;

        // Tanggal berasal dari lembar "Galeri Posyandu". Dokumen tidak mencantumkan jam,
        // sehingga 00:00:00 dipakai sebagai sentinel dan ditampilkan sebagai "dikonfirmasi" oleh view.
        $schedules = [
            ['Posyandu Dukuh Bakung Wetan', '2026-07-15', $generalInformation],
            ['Posyandu Dukuh Jetak', '2026-07-16', $generalInformation],
            ['Posyandu Dukuh Pakis', '2026-07-17', $generalInformation],
            ['Posyandu Dukuh Pringanom', '2026-07-18', $generalInformation.$structureXi],
        ];

        foreach ($schedules as [$name, $date, $information]) {
            PosyanduSchedule::updateOrCreate(
                ['nama_posyandu' => $name],
                [
                    'tanggal_pelaksanaan' => $date,
                    'jam_mulai' => '00:00:00',
                    'jam_selesai' => '00:00:00',
                    'informasi_phbs' => $information,
                    'kontak_bidan' => $bidan,
                ],
            );
        }

        $facilities = [
            ['nama_fasilitas' => 'Kantor Desa Pringanom', 'kategori' => 'kantor', 'keterangan' => 'Pusat pemerintahan dan pelayanan administrasi Desa Pringanom, Kecamatan Masaran, Kabupaten Sragen.'],
            ['nama_fasilitas' => 'Posyandu Sari Mulyo XI', 'kategori' => 'kesehatan', 'keterangan' => 'Posyandu dengan pembinaan Bidan Desa Iis Nurdianawati dan kepengurusan kader tahun 2026.'],
            ['nama_fasilitas' => 'Puskesmas Pembantu Desa Pringanom', 'kategori' => 'kesehatan', 'keterangan' => 'Fasilitas pelayanan kesehatan tingkat desa. Lokasi peta akan dilengkapi setelah koordinat resmi tersedia.'],
        ];

        foreach ($facilities as $facility) {
            PublicFacility::updateOrCreate(
                ['nama_fasilitas' => $facility['nama_fasilitas']],
                $facility + ['google_maps_embed' => null],
            );
        }
    }
}