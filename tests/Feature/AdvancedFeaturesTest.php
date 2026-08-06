<?php

namespace Tests\Feature;

use App\Mail\NewServiceRequestMail;
use App\Models\AdminService;
use App\Models\Faq;
use App\Models\TaxSchedule;
use App\Models\Umkm;
use App\Models\Article;
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
        Article::create([
            'title' => 'Berita Uji Desa',
            'slug' => 'berita-uji-desa',
            'category' => 'KKN',
            'content' => '<p>Konten berita uji.</p>',
            'excerpt' => 'Ringkasan berita uji.',
            'is_published' => true,
            'published_at' => now()->subMinute(),
            'author_name' => 'Admin Desa',
        ]);
        Article::create([
            'title' => 'Berita Draft Uji',
            'slug' => 'berita-draft-uji',
            'category' => 'KKN',
            'content' => '<p>Draft.</p>',
            'is_published' => false,
            'published_at' => now()->addDay(),
            'author_name' => 'Admin Desa',
        ]);
        $this->get(route('umkm'))
            ->assertOk()
            ->assertSee('Pojok UMKM dan Pajak')
            ->assertSee('187')
            ->assertSee('UMKM terdaftar')
            ->assertSee('Distribusi UMKM Desa')
            ->assertSee(asset('images/peta-sebaran-umkm.jpg'), false)
            ->assertSee('Lihat Gambar Penuh')
            ->assertSee('Unduh Peta (JPG)')
            ->assertSee('id="map"', false)
            ->assertSee('UMKM Uji')
            ->assertSee('FAQ UMKM Uji?')
            ->assertSee('Kalender Kewajiban Pajak')
            ->assertSee('Agenda Pajak Uji')
            ->assertSee('umkm-map', false);

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('placeholder="nama@email.com"', false)
            ->assertSee('border border-slate-300', false)
            ->assertSee('bg-amber-500', false);

        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Pengajuan Layanan Online')
            ->assertSee('file:bg-amber-50', false)
            ->assertSee('placeholder="Alamat lengkap RT/RW dan dukuh"', false);

        $this->get(route('agriculture'))
            ->assertOk()
            ->assertSee('Video Panduan Pertanian')
            ->assertSee('https://drive.google.com/file/d/1PWNNgQXbN-8a2CAFGq6NTQSr_J3fTyTG/preview', false);

        $this->get(route('news.index', ['q' => 'Berita Uji']))
            ->assertOk()
            ->assertSee('Berita Uji Desa')
            ->assertSee('Ringkasan berita uji.');

        $this->get(route('news.index', ['category' => 'Pemerintah Desa']))
            ->assertOk()
            ->assertDontSee('Berita Uji Desa');

        $this->get(route('news.show', 'berita-uji-desa'))
            ->assertOk()
            ->assertSee('Berita Uji Desa')
            ->assertSee('<p>Konten berita uji.</p>', false)
            ->assertSee('Berita Terkait');

        $this->get(route('news.index', ['q' => 'Draft Uji']))
            ->assertOk()
            ->assertDontSee('Berita Draft Uji');
        $this->get(route('accounting'))
            ->assertOk()
            ->assertSee('Template Pembukuan UMKM Pringanom')
            ->assertSee('Unduh Template (Excel)')
            ->assertSee(asset('templates/template-pembukuan-umkm.xlsx'), false)
            ->assertSee('download="Template_Pembukuan_UMKM_Pringanom.xlsx"', false)
            ->assertSee('Panduan Penggunaan')
            ->assertSee('Buku Penjualan')
            ->assertSee('Rekap Penjualan Mingguan &amp; Bulanan', false)
            ->assertSee('Buku Kas Operasional')
            ->assertSee('Catatan Hutang Piutang')
            ->assertSee('Rekap Laba Rugi Bulanan')
            ->assertSee('🔵 Penjualan')
            ->assertSee('🟢 Kas Operasional')
            ->assertSee('🟢 Utang & Piutang')
            ->assertSee('⚫ Laba Rugi')
            ->assertSee('📖 Panduan')
            ->assertSee('Catatan Harian')
            ->assertSee('Rekap Mingguan')
            ->assertSee('Rekap Bulanan')
            ->assertSee('Total Qty Terjual')
            ->assertSee('Saldo Kas Operasional')
            ->assertSee('Piutang Belum Lunas')
            ->assertSee('Prive/Pribadi')
            ->assertSee('Hapus Semua Data')
            ->assertSee('umkm_jual_v2')
            ->assertSee('umkm_kaso_v2')
            ->assertSee('umkm_hp_v2')
            ->assertSee('renderMinggu')
            ->assertSee('renderBulan')
            ->assertSee('renderLaba')
            ->assertSee('toggleLunas')
            ->assertSee('exportCSV')
            ->assertSee('const seedJual = []')
            ->assertSee('const seedKaso = []')
            ->assertSee('const seedHP = []')
            ->assertDontSee('Toko Sumber Jaya');

        $this->assertFileExists(public_path('templates/template-pembukuan-umkm.xlsx'));
        $this->get(route('taxes'))->assertOk()->assertSee('Batas Pelaporan Pajak UMKM')->assertSee('Agenda Pajak Uji');
    }
}
