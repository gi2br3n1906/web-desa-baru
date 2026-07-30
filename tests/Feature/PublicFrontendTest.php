<?php

namespace Tests\Feature;

use App\Models\AccountingTemplate;
use App\Models\AdminService;
use App\Models\AgricultureGuide;
use App\Models\PosyanduSchedule;
use App\Models\PublicFacility;
use App\Models\TaxGuide;
use App\Models\VillagePotential;
use App\Models\VillageProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFrontendTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_public_pages_are_accessible_without_content(): void
    {
        $routes = [
            'home',
            'profile',
            'services',
            'facilities',
            'agriculture',
            'accounting',
            'umkm',
            'taxes',
            'potentials',
            'posyandu',
        ];

        foreach ($routes as $route) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee('Desa Pringanom')
                ->assertSee('Dikembangkan oleh Tim KKN Undip 2026');
        }
    }

    public function test_homepage_uses_the_final_pringanom_identity(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Portal Informasi dan Layanan Desa Pringanom')
            ->assertSee('Kecamatan Masaran, Kabupaten Sragen')
            ->assertSee('Portal Resmi Pemerintahan Desa Pringanom, Kecamatan Masaran, Kabupaten Sragen.')
            ->assertSee('bg-slate-950/45', false)
            ->assertSee('data-carousel-next', false)
            ->assertSee('lg:grid-cols-6', false);
    }

    public function test_public_pages_render_managed_content_and_storage_urls(): void
    {
        VillageProfile::create([
            'visi' => '<p><strong>Visi desa teruji</strong></p>',
            'misi' => '<ul><li>Misi desa teruji</li></ul>',
            'struktur_organisasi_path' => 'uploads/struktur.png',
            'kontak_desa' => ['Telepon' => '081234567890'],
        ]);

        AdminService::create([
            'nama_layanan' => 'Layanan Uji',
            'persyaratan' => '<ul><li>Syarat uji</li></ul>',
            'alur_pengurusan' => '<ol><li>Alur uji</li></ol>',
        ]);

        PublicFacility::create([
            'nama_fasilitas' => 'Fasilitas Uji',
            'kategori' => 'kantor',
            'google_maps_embed' => '<iframe title="Peta uji"></iframe>',
            'keterangan' => 'Keterangan fasilitas uji',
        ]);

        AgricultureGuide::create([
            'nama_alat' => 'Alat Tani Uji',
            'panduan_perawatan' => '<p>Panduan uji</p>',
            'tips_keamanan' => '<p>Keamanan uji</p>',
        ]);

        AccountingTemplate::create([
            'nama_template' => 'Template Uji',
            'deskripsi' => 'Deskripsi template uji',
            'file_path' => 'uploads/template.xlsx',
        ]);

        TaxGuide::create([
            'kategori_umkm' => 'UMKM Uji',
            'alur_pajak' => '<p>Alur pajak uji</p>',
            'tarif_informasi' => '0,5%',
        ]);

        VillagePotential::create([
            'title_id' => 'Potensi Uji Indonesia',
            'title_jp' => '日本語テスト',
            'content_id' => '<p>Konten Indonesia uji</p>',
            'content_jp' => '<p>日本語コンテンツ</p>',
            'image_path' => 'uploads/potensi.jpg',
        ]);

        PosyanduSchedule::create([
            'nama_posyandu' => 'Posyandu Uji',
            'tanggal_pelaksanaan' => '2026-08-17',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
            'informasi_phbs' => '<p>PHBS uji</p>',
            'kontak_bidan' => '081122334455',
        ]);

        $this->get(route('profile'))
            ->assertSee('<strong>Visi desa teruji</strong>', false)
            ->assertSee(asset('storage/uploads/struktur.png'), false)
            ->assertSee('081234567890');

        $this->get(route('services'))
            ->assertSee('<li>Syarat uji</li>', false)
            ->assertSee('<li>Alur uji</li>', false);

        $this->get(route('facilities'))
            ->assertSee('<iframe title="Peta uji"></iframe>', false);

        $this->get(route('agriculture'))
            ->assertSee('<p>Panduan uji</p>', false)
            ->assertSee('<p>Keamanan uji</p>', false);

        $this->get(route('accounting'))
            ->assertSee(asset('storage/uploads/template.xlsx'), false);

        $this->get(route('taxes'))
            ->assertSee('<p>Alur pajak uji</p>', false);

        $this->get(route('potentials'))
            ->assertSee('Potensi Uji Indonesia')
            ->assertSee('日本語テスト')
            ->assertSee('<p>日本語コンテンツ</p>', false)
            ->assertSee(asset('storage/uploads/potensi.jpg'), false);

        $this->get(route('posyandu'))
            ->assertSee('Posyandu Uji')
            ->assertSee('<p>PHBS uji</p>', false);
    }
}
