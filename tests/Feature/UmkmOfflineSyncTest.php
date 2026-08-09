<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UmkmOfflineSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_sync_an_offline_umkm_batch_idempotently(): void
    {
        $admin = User::factory()->admin()->create();
        $items = [
            [
                'id' => 'offline-umkm-001',
                'nama_usaha' => 'Warung Offline Makmur',
                'pemilik' => 'Siti Uji',
                'dukuh' => 'Sari',
                'alamat_lengkap' => 'RT 001/RW 001, Dukuh Sari',
                'bentuk_usaha' => 'Perorangan',
                'jenis_usaha' => 'Perdagangan',
                'no_hp' => '081234567890',
                'created_at_offline' => '2026-08-09T05:00:00.000Z',
                'status_sync' => false,
            ],
            [
                'id' => 'offline-umkm-002',
                'nama_usaha' => 'Jasa Offline Pringanom',
                'pemilik' => 'Budi Uji',
                'dukuh' => 'Pringanom',
                'alamat_lengkap' => 'RT 016, Dukuh Pringanom',
                'bentuk_usaha' => 'CV',
                'jenis_usaha' => 'Jasa',
                'no_hp' => null,
                'created_at_offline' => '2026-08-09T05:01:00.000Z',
                'status_sync' => false,
            ],
        ];

        $response = $this->actingAs($admin)->postJson(route('api.umkm.sync-offline'), ['items' => $items]);

        $response->assertOk()->assertJson([
            'success' => true,
            'synced_count' => 2,
            'synced_ids' => ['offline-umkm-001', 'offline-umkm-002'],
        ]);
        $this->assertDatabaseHas('umkms', [
            'offline_sync_id' => 'offline-umkm-001',
            'nama_umkm' => 'Warung Offline Makmur',
            'alamat_lengkap' => 'RT 001/RW 001, Dukuh Sari',
            'no_hp' => '081234567890',
        ]);

        $this->actingAs($admin)->postJson(route('api.umkm.sync-offline'), ['items' => $items])->assertOk();
        $this->assertDatabaseCount('umkms', 2);
    }

    public function test_offline_sync_requires_an_admin_and_pwa_assets_are_exposed(): void
    {
        $payload = ['items' => [[
            'id' => 'offline-forbidden', 'nama_usaha' => 'Uji', 'pemilik' => 'Uji', 'dukuh' => 'Sari',
            'alamat_lengkap' => 'Alamat', 'bentuk_usaha' => 'Perorangan', 'jenis_usaha' => 'Jasa', 'no_hp' => null,
        ]]];

        $this->postJson(route('api.umkm.sync-offline'), $payload)->assertUnauthorized();
        $this->actingAs(User::factory()->create(['role' => 'umkm']))
            ->postJson(route('api.umkm.sync-offline'), $payload)
            ->assertForbidden();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('rel="manifest" href="/manifest.json"', false)
            ->assertSee('name="theme-color" content="#1e3a8a"', false)
            ->assertSee('/js/offline-db.js', false)
            ->assertSee('/js/offline-sync.js', false)
            ->assertSee('data-pwa-connection', false);

        $this->assertFileExists(public_path('manifest.json'));
        $this->assertFileExists(public_path('sw.js'));
        $this->assertFileExists(public_path('offline.html'));
        $this->assertFileExists(public_path('js/offline-db.js'));
        $this->assertFileExists(public_path('js/offline-sync.js'));
        $this->assertFileExists(public_path('images/pwa-icon-192.png'));
        $this->assertFileExists(public_path('images/pwa-icon-512.png'));

        $serviceWorker = file_get_contents(public_path('sw.js'));
        foreach (['/', '/pembukuan', '/umkm', '/posyandu', '/profil', '/layanan', '/berita', '/offline.html'] as $url) {
            $this->assertStringContainsString("'{$url}'", $serviceWorker);
        }
        $this->assertStringContainsString('caches.match(request, { ignoreSearch: true })', $serviceWorker);
        $this->assertStringContainsString('caches.match(OFFLINE_URL)', $serviceWorker);

        $admin = User::factory()->admin()->create();
        $this->actingAs($admin)->get(route('filament.admin.resources.umkms.create'))
            ->assertOk()
            ->assertSee('rel="manifest" href="/manifest.json"', false)
            ->assertSee('/js/offline-db.js', false)
            ->assertSee('data-pwa-connection', false)
            ->assertSee('Nama Usaha')
            ->assertSee('Alamat Lengkap')
            ->assertSee('Bentuk Usaha');
    }
}