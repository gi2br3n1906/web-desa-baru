<?php

namespace Database\Seeders;

use App\Models\AdminService;
use Illuminate\Database\Seeder;

class AdministrativeServiceSeeder extends Seeder
{
    /** Sumber: Data Website/Layanan Administrasi/Layanan Administrasi (1).pdf. */
    public function run(): void
    {
        $services = [
            ['Surat Keterangan Domisili', ['Surat pengantar dari RT/RW', 'Fotokopi KTP', 'Fotokopi KK']],
            ['Surat Keterangan Tidak Mampu', ['KK asli dan fotokopi KK', 'KTP asli dan fotokopi KTP', 'Surat pernyataan tidak mampu dari RT/RW', 'Surat pengantar dari RT/RW']],
            ['Surat Keterangan Usaha', ['Surat pengantar dari RT/RW', 'Fotokopi KTP', 'Informasi jenis usaha', 'Alamat usaha']],
            ['Surat Pengantar SKCK', ['Surat pengantar dari RT/RW', 'Fotokopi KTP', 'Tahun lulus SD, SMP, dan SMA/SMK atau jenjang berikutnya', 'Keterangan keperluan pengajuan']],
            ['Pembuatan atau Perubahan KK', ['Surat pengantar RT', 'KK lama asli dan fotokopi KK (1 lembar)', 'Surat pindah bagi penduduk dari luar wilayah', 'Dokumen pendukung identitas untuk ralat data', 'Surat bidan/dokter/rumah sakit untuk penambahan anak baru lahir']],
            ['Perpanjangan KTP', ['Surat pengantar RT', 'Fotokopi KK', 'Foto hitam putih 3×4 (1 lembar) bagi pemula', 'KTP asli yang diperpanjang']],
            ['Rujuk', ['Surat pengantar RT', 'KTP asli', 'Foto ukuran 2×3 (4 lembar)', 'Akta cerai asli keduanya']],
            ['Cerai', ['Surat pengantar RT', 'KTP asli', 'Buku nikah asli', 'Suami dan istri menghadap Kepala Desa']],
            ['Pembuatan Akta Kelahiran', ['Surat pengantar RT', 'Mengisi formulir', 'Fotokopi surat nikah orang tua yang dilegalisir KUA penerbit', 'Fotokopi KTP kedua orang tua', 'Fotokopi KTP pemohon bila sudah memiliki KTP', 'Fotokopi KK', 'Fotokopi ijazah bila sudah memiliki', 'Surat keterangan dokter/bidan atau duplikat surat kelahiran', 'Surat kematian bagi orang tua yang telah meninggal', 'Fotokopi KTP dua orang saksi', 'Surat cerai bila orang tua telah bercerai']],
            ['Pindah Penduduk', ['Surat pengantar RT', 'Mengisi formulir', 'KTP asli dan fotokopi KTP (2 lembar)', 'KK asli dan fotokopi KK (2 lembar)', 'Foto berwarna 4×6 (8 lembar)', 'Alamat tujuan yang lengkap dan jelas', 'SKCK untuk perpindahan antar kabupaten/provinsi bila dipersyaratkan']],
            ['Nikah atau Numpang Nikah', ['Surat pengantar RT', 'Fotokopi KTP', 'Fotokopi KK kedua calon mempelai', 'Fotokopi KTP saksi', 'Foto latar biru 3×4 (4 lembar) dan 4×6 (4 lembar)', 'Fotokopi buku nikah orang tua', 'Fotokopi ijazah', 'Khusus nikah gereja: foto calon satu bangku gereja', 'Surat cerai asli bagi yang pernah bercerai']],
            ['IMB atau HO', ['Surat pengantar RT', 'KTP asli', 'Mengisi blangko dari BPT Sragen', 'Izin lingkungan']],
            ['Surat Kematian', ['Surat pengantar RT', 'Mengisi formulir', 'Fotokopi KTP', 'KK asli dan fotokopi KK', 'Fotokopi KTP dua orang saksi']],
        ];

        $flow = '<ol><li>Pilih jenis layanan dan siapkan seluruh persyaratan.</li><li>Lengkapi data pengajuan kepada Pemerintah Desa Pringanom.</li><li>Petugas memverifikasi kelengkapan dokumen.</li><li>Surat yang telah selesai dapat diambil di Balai Desa Pringanom.</li></ol>';

        foreach ($services as [$name, $requirements]) {
            $items = implode('', array_map(
                static fn (string $requirement): string => '<li>'.htmlspecialchars($requirement, ENT_QUOTES, 'UTF-8').'</li>',
                $requirements,
            ));

            AdminService::updateOrCreate(
                ['nama_layanan' => $name],
                ['persyaratan' => '<ul>'.$items.'</ul>', 'alur_pengurusan' => $flow],
            );
        }
    }
}