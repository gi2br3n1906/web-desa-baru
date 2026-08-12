<?php

namespace Tests\Feature;

use App\Models\AdminService;
use App\Models\VillageProfile;
use Database\Seeders\AdministrativeServiceSeeder;
use Database\Seeders\LegalProductSeeder;
use Database\Seeders\NewsSeeder;
use Database\Seeders\PosyanduSeeder;
use Database\Seeders\TaxAndFaqSeeder;
use Database\Seeders\UmkmSeeder;
use Database\Seeders\VillageProfileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfficialDataSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_official_data_seeders_populate_all_domains_idempotently(): void
    {
        $seeders = [
            VillageProfileSeeder::class,
            UmkmSeeder::class,
            TaxAndFaqSeeder::class,
            PosyanduSeeder::class,
            AdministrativeServiceSeeder::class,
            LegalProductSeeder::class,
            NewsSeeder::class,
        ];

        $this->seed($seeders);
        $this->seed($seeders);

        $this->assertDatabaseCount('village_profiles', 1);
        $this->assertDatabaseCount('village_potentials', 4);
        $this->assertDatabaseCount('umkms', 61);
        $this->assertDatabaseCount('faqs', 8);
        $this->assertDatabaseCount('tax_guides', 3);
        $this->assertDatabaseCount('tax_schedules', 5);
        $this->assertDatabaseCount('posyandu_schedules', 4);
        $this->assertDatabaseCount('posyandu_profiles', 1);
        $this->assertDatabaseCount('posyandu_officers', 110);
        $this->assertDatabaseCount('posyandu_educations', 3);
        $this->assertDatabaseCount('posyandu_galleries', 4);
        $this->assertDatabaseCount('public_facilities', 3);
        $this->assertDatabaseCount('admin_services', 14);
        $this->assertDatabaseCount('village_legal_products', 2);
        $this->assertDatabaseCount('articles', 4);

        $profile = VillageProfile::findOrFail(1);
        $this->assertSame('Desa Pringanom, Kecamatan Masaran, Kabupaten Sragen, Jawa Tengah', $profile->kontak_desa['Alamat']);
        $this->assertSame('seeded/struktur-organisasi-pringanom.svg', $profile->struktur_organisasi_path);
        $this->assertStringNotContainsString('://', $profile->struktur_organisasi_path);
        $this->assertDatabaseHas('village_potentials', ['title_id' => 'Profil Wilayah dan Demografi']);
        $this->assertDatabaseHas('umkms', ['nama_umkm' => 'Dian Wahyu P', 'dusun' => 'Pakis']);
        foreach (['Sari' => 20, 'Pakis' => 11, 'Jetak' => 8, 'Pringanom' => 6, 'Bampir' => 5, 'Sadakan' => 3, 'Mojo' => 3, 'Bakung Kulon' => 3, 'Bakung Wetan' => 1, 'Jembangan' => 1, 'Bakung Tengah' => 0] as $hamlet => $count) {
            $this->assertSame($count, \App\Models\Umkm::query()->where('dusun', $hamlet)->count(), "Distribusi UMKM {$hamlet} tidak sesuai.");
        }
        $this->assertDatabaseHas('faqs', ['kategori' => 'pajak', 'pertanyaan' => 'Apa itu PPh Final UMKM 0,5%?']);
        $this->assertDatabaseHas('tax_schedules', ['judul_kegiatan' => 'Setor PPh 21, PPh 25/UMKM PP 23', 'is_routine_monthly' => true]);
        $this->assertDatabaseHas('tax_schedules', ['judul_kegiatan' => 'Lapor SPT Masa & Upload Faktur Pajak', 'is_routine_monthly' => true]);
        $this->assertDatabaseHas('tax_schedules', ['judul_kegiatan' => 'Setor/Lapor SPT Masa PPN', 'is_routine_monthly' => true]);
        $this->assertDatabaseHas('posyandu_schedules', ['nama_posyandu' => 'Posyandu Dukuh Pringanom', 'kontak_bidan' => 'Iis Nurdianawati (Bidan Desa)']);
        $this->assertDatabaseHas('posyandu_profiles', ['nama_bidan' => 'Iis Nurdianawati']);
        $this->assertDatabaseHas('posyandu_officers', ['nama_posyandu' => 'Posyandu Sari Mulyo I', 'jabatan' => 'Ketua', 'nama' => 'Tri Kayati']);
        $this->assertDatabaseHas('posyandu_officers', ['nama_posyandu' => 'Posyandu Sari Mulyo XI', 'jabatan' => 'Ketua', 'nama' => 'Sri Mulyani']);
        $this->assertDatabaseHas('posyandu_educations', ['kategori' => 'PHBS', 'judul' => 'Gomibunbetsu: Pilah Sampah dari Rumah']);
        $this->assertDatabaseHas('posyandu_galleries', ['judul' => 'Posyandu Dukuh Pringanom', 'tanggal' => '2026-07-18 00:00:00']);
        $this->assertDatabaseHas('public_facilities', ['nama_fasilitas' => 'Posyandu Sari Mulyo XI', 'kategori' => 'kesehatan']);
        $this->assertDatabaseHas('admin_services', ['nama_layanan' => 'Keterangan Domisili']);
        $this->assertDatabaseHas('admin_services', ['nama_layanan' => 'Pembuatan KTP']);
        $this->assertDatabaseHas('admin_services', ['nama_layanan' => 'Surat Kehilangan']);
        $this->assertDatabaseHas('admin_services', ['nama_layanan' => 'Surat Kelahiran']);
        $this->assertDatabaseMissing('admin_services', ['nama_layanan' => 'Perpanjangan KTP']);
        $this->assertDatabaseMissing('admin_services', ['nama_layanan' => 'IMB atau HO']);

        $services = AdminService::query()->get();
        foreach ($services as $service) {
            $this->assertStringNotContainsString('KK asli', $service->persyaratan, "Persyaratan {$service->nama_layanan} masih memuat KK asli.");
            $this->assertStringNotContainsString('KTP asli', $service->persyaratan, "Persyaratan {$service->nama_layanan} masih memuat KTP asli.");
        }

        $this->assertEqualsCanonicalizing(
            ['Keterangan Domisili', 'Pindah Tempat', 'Surat Kematian'],
            $services
                ->filter(fn (AdminService $service): bool => str_contains($service->persyaratan, 'Surat pengantar RT'))
                ->pluck('nama_layanan')
                ->all(),
        );
        $this->assertDatabaseHas('village_legal_products', ['judul_peraturan' => 'Perdes APBDes Tahun Anggaran 2026']);
        $this->assertDatabaseHas('village_legal_products', ['judul_peraturan' => 'Perdes Rencana Kerja Pemerintah Desa (RKP Desa)']);
        $this->assertDatabaseHas('articles', ['slug' => 'pelaksanaan-program-kkn-undip-2026-di-desa-pringanom', 'category' => 'KKN']);

        $this->assertFileExists(storage_path('app/public/seeded/struktur-organisasi-pringanom.svg'));

        $profileResourceSource = file_get_contents(app_path('Filament/Resources/VillageProfileResource.php'));
        $this->assertStringContainsString("FileUpload::make('struktur_organisasi_path')", $profileResourceSource);
        $this->assertStringContainsString("->disk('public')", $profileResourceSource);
        $this->assertStringContainsString("->directory('uploads/village-profiles')", $profileResourceSource);

        $this->get(route('profile'))
            ->assertOk()
            ->assertSee('Desa Pringanom, Kecamatan Masaran, Kabupaten Sragen, Jawa Tengah')
            ->assertSee(asset('storage/seeded/struktur-organisasi-pringanom.svg'), false);

        $this->get(route('potentials'))
            ->assertOk()
            ->assertSee('4.778 jiwa')
            ->assertSee('Sugiyoto, S.H.');

        $this->get(route('umkm'))
            ->assertOk()
            ->assertSee('Dian Wahyu P')
            ->assertSee('61')
            ->assertSee('UMKM Terdaftar')
            ->assertSee('Berbadan Usaha (57 Perorangan)')
            ->assertSee('Sumber Data: Olah data perangkat desa Pringanom (update 31 Juli 2026)')
            ->assertSee('Unduh Buku Saku Pajak UMKM 2026')
            ->assertSee('Tiap Tgl 15')
            ->assertSee('Tiap Tgl 20')
            ->assertSee('Tiap Tgl 30/31')
            ->assertDontSee('SENSUS EKONOMI BPS 2024')
            ->assertDontSee('Rata-rata usia usaha');

        $this->get(route('taxes'))
            ->assertOk()
            ->assertSee('UMKM Orang Pribadi')
            ->assertSee('Apa itu PPh Final UMKM 0,5%?');

        $this->get(route('posyandu'))
            ->assertOk()
            ->assertSee('Informasi Posyandu Desa Pringanom')
            ->assertSee('Informasi Posyandu')
            ->assertSee('Struktur Pengurus &amp; Kader Posyandu Desa Pringanom', false)
            ->assertSee('Infografis &amp; Edukasi Kesehatan', false)
            ->assertSee('Galeri Kegiatan Posyandu')
            ->assertSee('Iis Nurdianawati')
            ->assertSee('Tri Kayati')
            ->assertSee('Posyandu Sari Mulyo XI')
            ->assertSee('selectedPosyandu')
            ->assertDontSee('Jadwal Pelayanan Posyandu')
            ->assertSee('Gomibunbetsu: Pilah Sampah dari Rumah')
            ->assertSee('selectedYear')
            ->assertSee('openPoster');

        $servicesResponse = $this->get(route('services'));
        $servicesResponse
            ->assertOk()
            ->assertSee('Produk Hukum Desa')
            ->assertSee('Perdes APBDes Tahun Anggaran 2026')
            ->assertSee('Perdes Rencana Kerja Pemerintah Desa (RKP Desa)')
            ->assertSee('Unduh Dokumen (PDF)')
            ->assertSee(asset('documents/produk-hukum/perdes-apbdes-2026.pdf'), false)
            ->assertSee(asset('documents/produk-hukum/perdes-rkpdesa.pdf'), false)
            ->assertSeeInOrder(['Produk Hukum Desa', 'Pengajuan Layanan Online']);

        $this->get(route('facilities'))
            ->assertOk()
            ->assertSee('Kantor Desa Pringanom')
            ->assertSee('Puskesmas Pembantu Desa Pringanom');

        $this->get(route('services'))
            ->assertOk()
            ->assertSee('14 layanan tersedia')
            ->assertSee('Keterangan Domisili')
            ->assertSee('Pembuatan KTP')
            ->assertSee('Pembuatan Akta Kelahiran')
            ->assertSee('Surat Kehilangan')
            ->assertSee('Keterangan alasan kehilangan')
            ->assertSee('Surat Kelahiran')
            ->assertSee('Fotokopi surat dari bidan/rumah sakit')
            ->assertDontSee('Perpanjangan KTP')
            ->assertDontSee('IMB atau HO')
            ->assertDontSee('KK asli')
            ->assertDontSee('KTP asli');

        $this->get(route('news.index'))
            ->assertOk()
            ->assertSee('Kabar Desa')
            ->assertSee('Pelaksanaan Program KKN Undip 2026 di Desa Pringanom')
            ->assertSee('Karang Taruna Pringanom Gelar Kerja Bakti Lingkungan')
            ->assertSee('Pemerintah Desa')
            ->assertSee('Cari berita');

        $this->get(route('news.show', 'pelaksanaan-program-kkn-undip-2026-di-desa-pringanom'))
            ->assertOk()
            ->assertSee('Tim KKN Undip 2026')
            ->assertSee('Program kerja berfokus pada literasi digital', false);
    }
}