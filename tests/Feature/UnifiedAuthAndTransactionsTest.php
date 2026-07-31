<?php

namespace Tests\Feature;

use App\Filament\Pages\Auth\Login as FilamentLogin;
use App\Models\UmkmTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UnifiedAuthAndTransactionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_redirects_users_based_on_role(): void
    {
        $umkm = User::factory()->create([
            'email' => 'umkm@example.com',
            'password' => 'password',
            'role' => 'umkm',
        ]);

        $this->post(route('login.store'), [
            'email' => $umkm->email,
            'password' => 'password',
        ])->assertRedirect(route('accounting'));

        $this->post(route('logout'))->assertRedirect(route('home'));

        $admin = User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect('/admin');
    }

    public function test_accounting_page_shows_storage_mode_for_guest_and_authenticated_user(): void
    {
        $this->get(route('accounting'))
            ->assertOk()
            ->assertSee('Data Anda saat ini disimpan lokal di browser')
            ->assertSee('umkm_jual_v2', false);

        $user = User::factory()->create(['name' => 'UMKM Teruji']);

        $this->actingAs($user)
            ->get(route('accounting'))
            ->assertOk()
            ->assertSee('Data tersimpan aman di server Desa Pringanom untuk akun: UMKM Teruji.')
            ->assertSee('transactionUrls', false)
            ->assertSee('pembukuan\/transaksi', false);
    }

    public function test_transaction_endpoints_require_authentication(): void
    {
        $this->getJson(route('transactions.index'))->assertUnauthorized();
        $this->postJson(route('transactions.store'), [])->assertUnauthorized();
    }

    public function test_filament_login_redirects_umkm_user_to_accounting(): void
    {
        $user = User::factory()->create([
            'email' => 'filament-umkm@example.com',
            'password' => 'password',
            'role' => 'umkm',
        ]);

        Livewire::test(FilamentLogin::class)
            ->fillForm([
                'email' => $user->email,
                'password' => 'password',
                'remember' => false,
            ])
            ->call('authenticate')
            ->assertHasNoFormErrors()
            ->assertRedirect(route('accounting'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_manage_only_their_own_transactions(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $createResponse = $this->actingAs($owner)->postJson(route('transactions.store'), [
            'book_type' => 'jual',
            'date' => '2026-07-31',
            'title_or_product' => 'Penjualan beras',
            'transaction_type' => 'masuk',
            'amount' => 150000,
            'status' => 'belum',
        ])->assertCreated();

        $transactionId = $createResponse->json('data.id');

        $this->assertDatabaseHas('umkm_transactions', [
            'id' => $transactionId,
            'user_id' => $owner->id,
            'title_or_product' => 'Penjualan beras',
        ]);

        UmkmTransaction::create([
            'user_id' => $other->id,
            'book_type' => 'kaso',
            'date' => '2026-07-31',
            'title_or_product' => 'Kas pengguna lain',
            'transaction_type' => 'keluar',
            'amount' => 50000,
        ]);

        $this->actingAs($owner)
            ->getJson(route('transactions.index'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $transactionId);

        $this->actingAs($other)
            ->patchJson(route('transactions.toggle-lunas', $transactionId))
            ->assertNotFound();

        $this->actingAs($other)
            ->deleteJson(route('transactions.destroy', $transactionId))
            ->assertNotFound();

        $this->actingAs($owner)
            ->patchJson(route('transactions.toggle-lunas', $transactionId))
            ->assertOk()
            ->assertJsonPath('data.status', 'lunas');

        $this->actingAs($owner)
            ->deleteJson(route('transactions.destroy', $transactionId))
            ->assertNoContent();

        $this->assertDatabaseMissing('umkm_transactions', ['id' => $transactionId]);
    }
}
