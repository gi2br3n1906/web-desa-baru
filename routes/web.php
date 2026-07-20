<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::controller(FrontendController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
    Route::get('/profil', 'profile')->name('profile');
    Route::get('/layanan', 'services')->name('services');
    Route::get('/fasilitas', 'facilities')->name('facilities');
    Route::get('/pertanian', 'agriculture')->name('agriculture');
    Route::get('/pembukuan', 'accounting')->name('accounting');
    Route::get('/pajak', 'taxes')->name('taxes');
    Route::get('/potensi', 'potentials')->name('potentials');
    Route::get('/posyandu', 'posyandu')->name('posyandu');
});
