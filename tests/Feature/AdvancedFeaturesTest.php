<?php

namespace Tests\Feature;

use App\Mail\NewServiceRequestMail;
use App\Models\AdminService;
use App\Models\Faq;
use App\Models\TaxSchedule;
use App\Models\Umkm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdvancedFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_warga_can_submit_a_service_request(): void
    {
        Mail::fake();
        $service = AdminService::create(['nama_layanan' => 'Surat Uji', 'persyaratan' => 'KTP', 'alur_pengurusan' => 'Kirim']);
        $this->post(route('services.request.store'), ['admin_service_id' => $service->id, 'nama_lengkap' => 'Warga Uji', 'nik' => '1234567890123456', 'alamat' => 'Pringanom', 'no_whatsapp' => '08123456789'])->assertSessionHas('success');
        $this->assertDatabaseHas('service_requests', ['nama_lengkap' => 'Warga Uji', 'status' => 'pending']);
        Mail::assertSent(NewServiceRequestMail::class);
    }

    public function test_advanced_public_pages_render_data_and_book_contract(): void
    {
        Umkm::create(['nama_umkm' => 'UMKM Uji', 'pemilik' => 'Pemilik', 'kategori' => 'Kuliner', 'dusun' => 'Pringanom', 'rt_rw' => '01/02', 'deskripsi' => 'Deskripsi', 'latitude' => -7.43, 'longitude' => 110.93]);
        Faq::create(['kategori' => 'umkm', 'pertanyaan' => 'FAQ UMKM Uji?', 'jawaban' => 'Jawaban', 'urutan' => 1]);
        TaxSchedule::create(['judul_kegiatan' => 'Agenda Pajak Uji', 'tanggal' => now()->startOfMonth()->addDays(4)]);
        $this->get(route('umkm'))->assertOk()->assertSee('UMKM Uji')->assertSee('FAQ UMKM Uji?')->assertSee('umkm-map', false);
        $this->get(route('accounting'))->assertOk()->assertSee('umkm_jual_v2')->assertSee('renderLaba')->assertSee('exportCSV');
        $this->get(route('taxes'))->assertOk()->assertSee('Batas Pelaporan Pajak UMKM')->assertSee('Agenda Pajak Uji');
    }
}
