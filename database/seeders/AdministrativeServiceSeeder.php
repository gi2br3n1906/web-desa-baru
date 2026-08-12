<?php

namespace Database\Seeders;

use App\Models\AdminService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class AdministrativeServiceSeeder extends Seeder
{
    /** Sumber: Data Website/Layanan Administrasi/Layanan Administrasi (1).pdf. */
    public function run(): void
    {
        $services = [
            ['Keterangan Domisili', ['Surat pengantar RT', 'Fotokopi KTP', 'Fotokopi KK']],
            ['Surat Keterangan Tidak Mampu', ['Fotokopi KK', 'Fotokopi KTP', 'Surat pernyataan tidak mampu dari RT/RW']],
            ['Surat Keterangan Usaha', ['Fotokopi KTP', 'Informasi jenis usaha', 'Alamat usaha']],
            ['Surat Pengantar SKCK', ['Fotokopi KTP', 'Tahun lulus SD, SMP, dan SMA/SMK atau jenjang berikutnya', 'Keterangan keperluan pengajuan']],
            ['Pembuatan atau Perubahan KK', ['Fotokopi KK (1 lembar)', 'Surat pindah bagi penduduk dari luar wilayah', 'Dokumen pendukung identitas untuk ralat data', 'Surat bidan/dokter/rumah sakit untuk penambahan anak baru lahir']],
            ['Pembuatan KTP', ['Fotokopi KK', 'Foto hitam putih 3×4 (1 lembar) bagi pemula']],
            ['Rujuk', ['Fotokopi KTP', 'Foto ukuran 2×3 (4 lembar)', 'Akta cerai asli keduanya']],
            ['Cerai', ['Fotokopi KTP', 'Buku nikah asli', 'Suami dan istri menghadap Kepala Desa']],
            ['Pembuatan Akta Kelahiran', ['Mengisi formulir', 'Fotokopi surat nikah orang tua yang dilegalisir KUA penerbit', 'Fotokopi KTP kedua orang tua', 'Fotokopi KTP pemohon bila sudah memiliki KTP', 'Fotokopi KK', 'Fotokopi ijazah bila sudah memiliki', 'Surat keterangan dokter/bidan atau duplikat surat kelahiran', 'Surat kematian bagi orang tua yang telah meninggal', 'Fotokopi KTP dua orang saksi', 'Surat cerai bila orang tua telah bercerai']],
            ['Pindah Tempat', ['Surat pengantar RT', 'Mengisi formulir', 'Fotokopi KTP (2 lembar)', 'Fotokopi KK (2 lembar)', 'Foto berwarna 4×6 (8 lembar)', 'Alamat tujuan yang lengkap dan jelas', 'SKCK untuk perpindahan antar kabupaten/provinsi bila dipersyaratkan']],
            ['Nikah atau Numpang Nikah', ['Fotokopi KTP', 'Fotokopi KK kedua calon mempelai', 'Fotokopi KTP saksi', 'Foto latar biru 3×4 (4 lembar) dan 4×6 (4 lembar)', 'Fotokopi buku nikah orang tua', 'Fotokopi ijazah', 'Khusus nikah gereja: foto calon satu bangku gereja', 'Surat cerai asli bagi yang pernah bercerai']],
            ['Surat Kematian', ['Surat pengantar RT', 'Mengisi formulir', 'Fotokopi KTP', 'Fotokopi KK', 'Fotokopi KTP dua orang saksi']],
            ['Surat Kehilangan', ['Fotokopi KTP', 'Fotokopi KK', 'Keterangan alasan kehilangan']],
            ['Surat Kelahiran', ['Fotokopi surat dari bidan/rumah sakit', 'Fotokopi KK', 'Fotokopi KTP Orangtua']],
        ];

        $flow = '<ol><li>Pilih jenis layanan dan siapkan seluruh persyaratan.</li><li>Lengkapi data pengajuan kepada Pemerintah Desa Pringanom.</li><li>Petugas memverifikasi kelengkapan dokumen.</li><li>Surat yang telah selesai dapat diambil di Balai Desa Pringanom.</li></ol>';

        DB::transaction(function () use ($flow, $services): void {
            foreach ([
                'Surat Keterangan Domisili' => 'Keterangan Domisili',
                'Perpanjangan KTP' => 'Pembuatan KTP',
                'Pindah Penduduk' => 'Pindah Tempat',
            ] as $legacyName => $currentName) {
                $this->renameService($legacyName, $currentName);
            }

            $obsoleteService = AdminService::query()
                ->where('nama_layanan', 'IMB atau HO')
                ->first();

            if ($obsoleteService?->serviceRequests()->exists()) {
                throw new RuntimeException('Layanan IMB atau HO tidak dapat dihapus karena masih memiliki riwayat pengajuan. Arsipkan atau pindahkan riwayat tersebut terlebih dahulu.');
            }

            $obsoleteService?->delete();

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
        });
    }

    private function renameService(string $legacyName, string $currentName): void
    {
        $legacyService = AdminService::query()
            ->where('nama_layanan', $legacyName)
            ->first();

        if (! $legacyService) {
            return;
        }

        $currentService = AdminService::query()
            ->where('nama_layanan', $currentName)
            ->first();

        if (! $currentService) {
            $legacyService->update(['nama_layanan' => $currentName]);

            return;
        }

        $legacyService->serviceRequests()->update([
            'admin_service_id' => $currentService->id,
        ]);
        $legacyService->delete();
    }
}