<?php

namespace Tests\Feature;

use App\Models\VillageProfile;
use Database\Seeders\AdministrativeServiceSeeder;
use Database\Seeders\LegalProductSeeder;
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
        ];

        $this->seed($seeders);
        $this->seed($seeders);

        $this->assertDatabaseCount('village_profiles', 1);
        $this->assertDatabaseCount('village_potentials', 4);
        $this->assertDatabaseCount('umkms', 9);
        $this->assertDatabaseCount('faqs', 8);
        $this->assertDatabaseCount('tax_guides', 3);
        $this->assertDatabaseCount('tax_schedules', 4);
        $this->assertDatabaseCount('posyandu_schedules', 4);
        $this->assertDatabaseCount('posyandu_profiles', 1);
        $this->assertDatabaseCount('posyandu_officers', 10);
        $this->assertDatabaseCount('posyandu_educations', 3);
        $this->assertDatabaseCount('posyandu_galleries', 4);
        $this->assertDatabaseCount('public_facilities', 3);
        $this->assertDatabaseCount('admin_services', 13);
        $this->assertDatabaseCount('village_legal_products', 2);

        $this->assertSame('Desa Pringanom, Kecamatan Masaran, Kabupaten Sragen, Jawa Tengah', VillageProfile::findOrFail(1)->kontak_desa['Alamat']);
        $this->assertDatabaseHas('village_potentials', ['title_id' => 'Profil Wilayah dan Demografi']);
        $this->assertDatabaseHas('umkms', ['nama_umkm' => 'Dapur Bu Ratmi', 'dusun' => 'Pringanom']);
        $this->assertDatabaseHas('faqs', ['kategori' => 'pajak', 'pertanyaan' => 'Apa itu PPh Final UMKM 0,5%?']);
        $this->assertDatabaseHas('tax_schedules', ['judul_kegiatan' => 'Setor PPh Final UMKM', 'is_routine_monthly' => true]);
        $this->assertDatabaseHas('posyandu_schedules', ['nama_posyandu' => 'Posyandu Dukuh Pringanom', 'kontak_bidan' => 'Iis Nurdianawati (Bidan Desa)']);
        $this->assertDatabaseHas('posyandu_profiles', ['nama_bidan' => 'Iis Nurdianawati']);
        $this->assertDatabaseHas('posyandu_officers', ['jabatan' => 'Ketua', 'nama' => 'Sri Mulyani']);
        $this->assertDatabaseHas('posyandu_educations', ['kategori' => 'PHBS', 'judul' => 'Gomibunbetsu: Pilah Sampah dari Rumah']);
        $this->assertDatabaseHas('posyandu_galleries', ['judul' => 'Posyandu Dukuh Pringanom', 'tanggal' => '2026-07-18 00:00:00']);
        $this->assertDatabaseHas('public_facilities', ['nama_fasilitas' => 'Posyandu Sari Mulyo XI', 'kategori' => 'kesehatan']);
        $this->assertDatabaseHas('admin_services', ['nama_layanan' => 'Surat Keterangan Domisili']);
        $this->assertDatabaseHas('village_legal_products', ['judul_peraturan' => 'Perdes APBDes Tahun Anggaran 2026']);
        $this->assertDatabaseHas('village_legal_products', ['judul_peraturan' => 'Perdes Rencana Kerja Pemerintah Desa (RKP Desa)']);

        $this->assertFileExists(storage_path('app/public/seeded/struktur-organisasi-pringanom.svg'));

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
            ->assertSee('Dapur Bu Ratmi')
            ->assertSee('187 UMKM terdaftar');

        $this->get(route('taxes'))
            ->assertOk()
            ->assertSee('UMKM Orang Pribadi')
            ->assertSee('Apa itu PPh Final UMKM 0,5%?');

        $this->get(route('posyandu'))
            ->assertOk()
            ->assertSee('Informasi Posyandu Desa Pringanom')
            ->assertSee('Struktur Pengurus &amp; Kader Posyandu Desa Pringanom', false)
            ->assertSee('Infografis &amp; Edukasi Kesehatan', false)
            ->assertSee('Galeri Kegiatan Posyandu')
            ->assertSee('Iis Nurdianawati')
            ->assertSee('Sri Mulyani')
            ->assertDontSee('Jadwal Pelayanan Posyandu')
            ->assertSee('Gomibunbetsu: Pilah Sampah dari Rumah')
            ->assertSee('selectedYear')
            ->assertSee('openPoster');

        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Produk Hukum Desa')
            ->assertSee('Perdes APBDes Tahun Anggaran 2026')
            ->assertSee('Perdes Rencana Kerja Pemerintah Desa (RKP Desa)')
            ->assertSee('Unduh Dokumen (PDF)')
            ->assertSee(asset('documents/produk-hukum/perdes-apbdes-2026.pdf'), false)
            ->assertSee(asset('documents/produk-hukum/perdes-rkpdesa.pdf'), false);

        $this->get(route('facilities'))
            ->assertOk()
            ->assertSee('Kantor Desa Pringanom')
            ->assertSee('Puskesmas Pembantu Desa Pringanom');

        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Surat Keterangan Domisili')
            ->assertSee('Pembuatan Akta Kelahiran');
    }
}