<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UmkmSyncController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/sw.js', function () {
    return response()->make(file_get_contents(public_path('sw.js')), 200, [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
});

Route::get('/manifest.json', function () {
    return response()->make(file_get_contents(public_path('manifest.json')), 200, [
        'Content-Type' => 'application/json',
        'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/api/umkm/sync-offline', UmkmSyncController::class)
    ->middleware(['auth', 'throttle:30,1'])
    ->name('api.umkm.sync-offline');

Route::controller(FrontendController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
    Route::get('/berita', 'news')->name('news.index');
    Route::get('/berita/{slug}', 'showNews')->name('news.show');
    Route::get('/profil', 'profile')->name('profile');
    Route::get('/layanan', 'services')->name('services');
    Route::post('/layanan/pengajuan', 'storeServiceRequest')->name('services.request.store');
    Route::get('/fasilitas', 'facilities')->name('facilities');
    Route::get('/pertanian', 'agriculture')->name('agriculture');
    Route::get('/pembukuan', 'accounting')->name('accounting');
    Route::get('/umkm', 'umkm')->name('umkm');
    Route::get('/pajak', 'taxes')->name('taxes');
    Route::get('/potensi', 'potentials')->name('potentials');
    Route::get('/posyandu', 'posyandu')->name('posyandu');

    Route::middleware('auth')->prefix('pembukuan/transaksi')->name('transactions.')->group(function (): void {
        Route::get('/', 'getTransactions')->name('index');
        Route::post('/', 'storeTransaction')->name('store');
        Route::delete('/{transaction}', 'deleteTransaction')->name('destroy');
        Route::patch('/{transaction}/toggle-lunas', 'toggleLunas')->name('toggle-lunas');
    });
});
