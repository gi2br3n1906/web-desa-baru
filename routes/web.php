<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::controller(FrontendController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
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
