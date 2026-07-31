<?php

namespace Database\Seeders;

use App\Models\PosyanduEducation;
use App\Models\PosyanduGallery;
use App\Models\PosyanduOfficer;
use App\Models\PosyanduProfile;
use App\Models\PosyanduSchedule;
use App\Models\PublicFacility;
use Illuminate\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    /** Sumber: Data Website/Posyandu/DATA POSYANDU.xlsx. */
    public function run(): void
    {
        $bidan = 'Iis Nurdianawati (Bidan Desa)';

        PosyanduProfile::updateOrCreate(
            ['nama_bidan' => 'Iis Nurdianawati'],
            [
                'subtitle' => 'Bidan Desa — Penanggung Jawab & Pembina Seluruh Kader Posyandu',
                'wilayah' => 'Desa Pringanom, Kec. Masaran',
                'deskripsi' => 'Bidan yang bertanggung jawab membina dan mendampingi seluruh kader posyandu di wilayah Desa Pringanom.',
                'foto_path' => null,
            ],
        );

        $officers = [
            ['Ketua', 'Sri Mulyani', 1, 1],
            ['Sekretaris', 'Tri Wahyuni', 2, 1],
            ['Bendahara', 'Sunarsi', 2, 2],
            ['Ketua Bidang Pendidikan', 'Triana Puji Lestari', 3, 1],
            ['Ketua Bidang Kesehatan', 'Ike Susanti', 3, 2],
            ['Anggota Bidang Kesehatan', 'Umi Farida', 3, 3],
            ['Ketua Bidang Pekerjaan Umum', 'Suryani', 3, 4],
            ['Ketua Bidang Sosial', 'Bp. Diyono', 3, 5],
            ['Ketua Bidang Trantibumlinmas', 'Bp. Alex Sangidi', 3, 6],
            ['Ketua Bidang Perumahan Rakyat', 'Bp. Sukimin', 3, 7],
        ];

        foreach ($officers as [$position, $name, $level, $order]) {
            PosyanduOfficer::updateOrCreate(
                ['nama_posyandu' => 'Posyandu Sari Mulyo XI', 'jabatan' => $position],
                ['nama' => $name, 'level' => $level, 'urutan' => $order],
            );
        }

        $educations = [
            [
                'kategori' => 'PHBS',
                'judul' => 'Gomibunbetsu: Pilah Sampah dari Rumah',
                'deskripsi' => 'Budaya pemilahan sampah berdasarkan jenisnya sejak dari rumah: organik, anorganik, serta sampah berbahaya atau B3.',
                'drive_id' => '1iaTNqtK1mPTc1eUWoX1fxxn7CbQNvWZt',
                'urutan' => 1,
            ],
            [
                'kategori' => 'PHBS',
                'judul' => 'Leptospirosis dan PHBS pada Petani',
                'deskripsi' => 'Kenali risiko penularan melalui air, tanah, atau lumpur yang terkontaminasi dan langkah perlindungan bagi petani.',
                'drive_id' => '1lQwO1s1KLt2Ve19Rer8bMAHs5PCnTITq',
                'urutan' => 2,
            ],
            [
                'kategori' => 'PHBS',
                'judul' => 'Jangan Anggap Remeh Sampah',
                'deskripsi' => 'Materi dampak sampah terhadap lingkungan, banjir, dan kesehatan serta kebiasaan pengelolaan sampah yang benar.',
                'drive_id' => '1Hzg9rAPvq2O_RrAqCP0Ggw-7020gTJh9',
                'urutan' => 3,
            ],
        ];

        foreach ($educations as $education) {
            $driveId = $education['drive_id'];
            PosyanduEducation::updateOrCreate(
                ['judul' => $education['judul']],
                [
                    'kategori' => $education['kategori'],
                    'deskripsi' => $education['deskripsi'],
                    'poster_url' => "https://drive.google.com/file/d/{$driveId}/view",
                    'thumbnail_url' => "https://drive.google.com/thumbnail?id={$driveId}&sz=w1200",
                    'urutan' => $education['urutan'],
                ],
            );
        }

        $galleries = [
            ['Posyandu Dukuh Bakung Wetan', '2026-07-15', '1shcWXPdJGK-lWG0NKiPlHui2W4QmdTDQ'],
            ['Posyandu Dukuh Jetak', '2026-07-16', '1anUuLTz_gvzo4EZDOriYNFEAcyeTrr1Z'],
            ['Posyandu Dukuh Pakis', '2026-07-17', '1Oqd3s-JFj6tXJXN1S28uQ37q_aCvmnxL'],
            ['Posyandu Dukuh Pringanom', '2026-07-18', '136Gjgq9qOFXYfwCc2g1HHIexHCld4KeD'],
        ];

        foreach ($galleries as [$title, $date, $driveId]) {
            PosyanduGallery::updateOrCreate(
                ['judul' => $title],
                [
                    'tanggal' => $date,
                    'foto_url' => "https://drive.google.com/file/d/{$driveId}/view",
                    'thumbnail_url' => "https://drive.google.com/thumbnail?id={$driveId}&sz=w1200",
                ],
            );
        }
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