<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_the_admin_login_page(): void
    {
        $this->get('/admin')
            ->assertRedirect('/admin/login');

        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('Pemerintahan Desa Pringanom');
    }

    public function test_admin_can_access_dashboard_and_all_resource_pages(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@desa.com'],
            User::factory()->admin()->make([
                'email' => 'admin@desa.com',
                'password' => 'password',
            ])->getAttributes(),
        );

        $this->actingAs($admin);

        $routes = [
            'filament.admin.pages.dashboard',
            'filament.admin.resources.articles.index',
            'filament.admin.resources.articles.create',
            'filament.admin.resources.accounting-templates.index',
            'filament.admin.resources.accounting-templates.create',
            'filament.admin.resources.admin-services.index',
            'filament.admin.resources.admin-services.create',
            'filament.admin.resources.agriculture-guides.index',
            'filament.admin.resources.agriculture-guides.create',
            'filament.admin.resources.faqs.index',
            'filament.admin.resources.faqs.create',
            'filament.admin.resources.posyandu-schedules.index',
            'filament.admin.resources.posyandu-schedules.create',
            'filament.admin.resources.public-facilities.index',
            'filament.admin.resources.public-facilities.create',
            'filament.admin.resources.service-submissions.index',
            'filament.admin.resources.service-submissions.create',
            'filament.admin.resources.tax-guides.index',
            'filament.admin.resources.tax-guides.create',
            'filament.admin.resources.tax-schedules.index',
            'filament.admin.resources.tax-schedules.create',
            'filament.admin.resources.umkms.index',
            'filament.admin.resources.umkms.create',
            'filament.admin.resources.umkm-transactions.index',
            'filament.admin.resources.users.index',
            'filament.admin.resources.users.create',
            'filament.admin.resources.village-potentials.index',
            'filament.admin.resources.village-potentials.create',
            'filament.admin.resources.village-profiles.index',
            'filament.admin.resources.village-profiles.create',
            'filament.admin.resources.village-legal-products.index',
            'filament.admin.resources.village-legal-products.create',
        ];

        foreach ($routes as $route) {
            $this->get(route($route))->assertOk();
        }

        $this->get('/admin')
            ->assertOk()
            ->assertSee('Total UMKM Terdaftar')
            ->assertSee('Pengajuan Layanan Baru')
            ->assertSee('Berita Terbit')
            ->assertSee('Menu Pintas Perangkat Desa')
            ->assertSee('Kelola UMKM')
            ->assertSee('Pengajuan Layanan Masuk')
            ->assertSee('Tulis Berita Desa')
            ->assertSee('Edit Profil Desa')
            ->assertSee('Produk Hukum &amp; Dokumen', false)
            ->assertSee('/admin/service-submissions', false);
    }

    public function test_umkm_user_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create(['role' => 'umkm']);

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }
}
