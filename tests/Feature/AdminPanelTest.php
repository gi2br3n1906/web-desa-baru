<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_is_redirected_to_the_admin_login_page(): void
    {
        $this->get('/admin')
            ->assertRedirect('/admin/login');

        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('Admin Pringanom');
    }

    public function test_admin_can_access_dashboard_and_all_resource_pages(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@desa.com'],
            User::factory()->make([
                'email' => 'admin@desa.com',
                'password' => 'password',
            ])->getAttributes(),
        );

        $this->actingAs($admin);

        $routes = [
            'filament.admin.pages.dashboard',
            'filament.admin.resources.accounting-templates.index',
            'filament.admin.resources.accounting-templates.create',
            'filament.admin.resources.admin-services.index',
            'filament.admin.resources.admin-services.create',
            'filament.admin.resources.agriculture-guides.index',
            'filament.admin.resources.agriculture-guides.create',
            'filament.admin.resources.posyandu-schedules.index',
            'filament.admin.resources.posyandu-schedules.create',
            'filament.admin.resources.public-facilities.index',
            'filament.admin.resources.public-facilities.create',
            'filament.admin.resources.tax-guides.index',
            'filament.admin.resources.tax-guides.create',
            'filament.admin.resources.village-potentials.index',
            'filament.admin.resources.village-potentials.create',
            'filament.admin.resources.village-profiles.index',
            'filament.admin.resources.village-profiles.create',
        ];

        foreach ($routes as $route) {
            $this->get(route($route))->assertOk();
        }
    }
}
