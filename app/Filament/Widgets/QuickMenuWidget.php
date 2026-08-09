<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\ServiceRequestResource;
use App\Filament\Resources\UmkmResource;
use App\Filament\Resources\VillageLegalProductResource;
use App\Filament\Resources\VillageProfileResource;
use Filament\Widgets\Widget;

class QuickMenuWidget extends Widget
{
    protected static string $view = 'filament.widgets.quick-menu-widget';

    protected static bool $isLazy = false;

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'menus' => [
                ['label' => 'Kelola UMKM', 'description' => 'Tambah dan perbarui direktori usaha warga.', 'icon' => 'heroicon-o-shopping-bag', 'url' => UmkmResource::getUrl('index'), 'color' => 'amber'],
                ['label' => 'Pengajuan Layanan Masuk', 'description' => 'Periksa pengajuan administrasi terbaru.', 'icon' => 'heroicon-o-inbox-arrow-down', 'url' => ServiceRequestResource::getUrl('index'), 'color' => 'blue'],
                ['label' => 'Tulis Berita Desa', 'description' => 'Terbitkan kabar dan pengumuman desa.', 'icon' => 'heroicon-o-pencil-square', 'url' => ArticleResource::getUrl('create'), 'color' => 'emerald'],
                ['label' => 'Edit Profil Desa', 'description' => 'Kelola visi, misi, struktur, dan kontak.', 'icon' => 'heroicon-o-building-library', 'url' => VillageProfileResource::getUrl('index'), 'color' => 'violet'],
                ['label' => 'Produk Hukum & Dokumen', 'description' => 'Kelola Perdes dan dokumen resmi desa.', 'icon' => 'heroicon-o-scale', 'url' => VillageLegalProductResource::getUrl('index'), 'color' => 'rose'],
            ],
        ];
    }
}