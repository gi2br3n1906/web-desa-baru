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

        // Sumber: sheet "Kader per posyandu" pada DATA POSYANDU.xlsx.
        $officersByPosyandu = [
            'Posyandu Sari Mulyo I' => [
                ['Ketua', 'Tri Kayati'], ['Sekretaris', 'Yulianti'], ['Bendahara', 'Yeni Fatmawati'],
                ['Ketua Bidang Pendidikan', 'Asma Nur Pratiwi'], ['Ketua Bidang Kesehatan', 'Tutik Setyaningsih'], ['Anggota Bidang Kesehatan', 'Titin Purnamasari'],
                ['Ketua Bidang Pekerjaan Umum', 'Satini'], ['Ketua Bidang Sosial', 'Bp. Martono'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Tugino'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Sukamto'],
            ],
            'Posyandu Sari Mulyo II' => [
                ['Ketua', 'Endang Sukamti'], ['Sekretaris', 'Eli Zubaidah'], ['Bendahara', 'Nur Chayati'],
                ['Ketua Bidang Pendidikan', 'Sutarmi'], ['Ketua Bidang Kesehatan', 'Nuryati'], ['Anggota Bidang Kesehatan', 'Tri Wahyuni'],
                ['Ketua Bidang Pekerjaan Umum', 'Sugiyanti'], ['Ketua Bidang Sosial', 'Bp. Sardi'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Bekti Prayitno'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Supardi'],
            ],
            'Posyandu Sari Mulyo III' => [
                ['Ketua', 'Suyati'], ['Sekretaris', 'Avina Rani'], ['Bendahara', 'Suprihatin'],
                ['Ketua Bidang Pendidikan', 'Suparni'], ['Ketua Bidang Kesehatan', 'Darmi'], ['Anggota Bidang Kesehatan', 'Eka Daryani'],
                ['Ketua Bidang Pekerjaan Umum', 'Nanik Sunarni'], ['Ketua Bidang Sosial', 'Bp. Marindi'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Marno Susilo'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Tukiyanto'],
            ],
            'Posyandu Sari Mulyo IV' => [
                ['Ketua', 'Putri Sulistyoningrum'], ['Sekretaris', 'Sri Wulandari'], ['Bendahara', 'Purwani'],
                ['Ketua Bidang Pendidikan', 'Hartatik'], ['Ketua Bidang Kesehatan', 'Sulistyowati'], ['Anggota Bidang Kesehatan', 'Maryati'],
                ['Ketua Bidang Pekerjaan Umum', 'Warsi'], ['Ketua Bidang Sosial', 'Bp. Ali Shadiki'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Karno'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Suyatno'],
            ],
            'Posyandu Sari Mulyo V' => [
                ['Ketua', 'Sukamti'], ['Sekretaris', 'Sastri Nunggal'], ['Bendahara', 'Tugiyem'],
                ['Ketua Bidang Pendidikan', 'Muryani'], ['Ketua Bidang Kesehatan', 'Siti Sumanafti'], ['Anggota Bidang Kesehatan', 'Ida Mahmilawati'],
                ['Ketua Bidang Pekerjaan Umum', 'Sutiyem'], ['Ketua Bidang Sosial', 'Bp. Wiyono'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Sunaryo'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Wibowo'],
            ],
            'Posyandu Sari Mulyo VI' => [
                ['Ketua', 'Mulyati Nur Anisa'], ['Sekretaris', 'Suwarti'], ['Bendahara', 'Frida Frastika Yekti'],
                ['Ketua Bidang Pendidikan', 'Dwi Sugiyanti'], ['Ketua Bidang Kesehatan', 'Sarmini'], ['Anggota Bidang Kesehatan', 'Purwanti'],
                ['Ketua Bidang Pekerjaan Umum', 'Suginem'], ['Ketua Bidang Sosial', 'Bp. Supono'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Sayono'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Sastro Suwarno'],
            ],
            'Posyandu Sari Mulyo VII' => [
                ['Ketua', 'Ismiyati'], ['Sekretaris', 'Sunarsi'], ['Bendahara', 'Hetti Lilis Suryani'],
                ['Ketua Bidang Pendidikan', 'Reni Septiana Yus Sriyanti'], ['Ketua Bidang Kesehatan', 'Suharti'], ['Anggota Bidang Kesehatan', 'Kasinah'],
                ['Ketua Bidang Pekerjaan Umum', 'Zahbilla Indah Yuniati'], ['Ketua Bidang Sosial', 'Bp. Suharjo'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Agus Trio Wibowo'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Sutopo'],
            ],
            'Posyandu Sari Mulyo VIII' => [
                ['Ketua', 'Ngadiyem'], ['Sekretaris', 'Suryaningsih'], ['Bendahara', 'Tri Mulyani'],
                ['Ketua Bidang Pendidikan', 'Nining Iswahyuni'], ['Ketua Bidang Kesehatan', 'Sri Mulyani S'], ['Anggota Bidang Kesehatan', 'Nati Ramadhani'],
                ['Ketua Bidang Pekerjaan Umum', 'Sri Mulyani'], ['Ketua Bidang Sosial', 'Bp. Susilo'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Marimin'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Wagiman'],
            ],
            'Posyandu Sari Mulyo IX' => [
                ['Ketua', 'Juniati'], ['Sekretaris', 'Sumiyem'], ['Bendahara', 'Sugiyarti'],
                ['Ketua Bidang Pendidikan', 'Rumiyati'], ['Ketua Bidang Kesehatan', 'Ita Yuliani'], ['Anggota Bidang Kesehatan', 'Suprapti'],
                ['Ketua Bidang Pekerjaan Umum', 'Bp. Surono'], ['Ketua Bidang Sosial', 'Bp. Wijiyanto'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Wijiyanto'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Aris Triyanto'],
            ],
            'Posyandu Sari Mulyo X' => [
                ['Ketua', 'Nita Dwi Ningsih'], ['Sekretaris', 'Sri Lestari'], ['Bendahara', 'Dewi Ratnayani'],
                ['Ketua Bidang Pendidikan', 'Windi Widhyaningsih'], ['Ketua Bidang Kesehatan', 'Indarsih'], ['Anggota Bidang Kesehatan', 'Winarsih'],
                ['Ketua Bidang Pekerjaan Umum', 'Triyani'], ['Ketua Bidang Sosial', 'Bp. Abbas Supardi'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Rudiyanto'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Slamet Riyanto'],
            ],
            'Posyandu Sari Mulyo XI' => [
                ['Ketua', 'Sri Mulyani'], ['Sekretaris', 'Tri Wahyuni'], ['Bendahara', 'Sunarsi'],
                ['Ketua Bidang Pendidikan', 'Triana Puji Lestari'], ['Ketua Bidang Kesehatan', 'Ike Susanti'], ['Anggota Bidang Kesehatan', 'Umi Farida'],
                ['Ketua Bidang Pekerjaan Umum', 'Suryani'], ['Ketua Bidang Sosial', 'Bp. Diyono'], ['Ketua Bidang Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat', 'Bp. Alex Sangidi'], ['Ketua Bidang Perumahan Rakyat', 'Bp. Sukimin'],
            ],
        ];

        PosyanduOfficer::query()->delete();

        foreach ($officersByPosyandu as $posyandu => $officers) {
            foreach ($officers as $index => [$position, $name]) {
                PosyanduOfficer::create([
                    'nama_posyandu' => $posyandu,
                    'jabatan' => $position,
                    'nama' => $name,
                    'level' => $index === 0 ? 1 : ($index < 3 ? 2 : 3),
                    'urutan' => $index + 1,
                ]);
            }
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