<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\ServiceRequestResource;
use App\Filament\Resources\UmkmResource;
use App\Models\Article;
use App\Models\ServiceRequest;
use App\Models\Umkm;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $pendingRequests = ServiceRequest::query()->where('status', 'pending')->count();

        return [
            Stat::make('Total UMKM Terdaftar', Umkm::query()->count())
                ->description('Data usaha yang tercatat di portal desa')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary')
                ->url(UmkmResource::getUrl('index')),
            Stat::make('Pengajuan Layanan Baru', $pendingRequests)
                ->description($pendingRequests > 0 ? 'Perlu segera ditindaklanjuti' : 'Tidak ada pengajuan tertunda')
                ->descriptionIcon($pendingRequests > 0 ? 'heroicon-m-exclamation-circle' : 'heroicon-m-check-circle')
                ->color($pendingRequests > 0 ? 'danger' : 'success')
                ->url(ServiceRequestResource::getUrl('index')),
            Stat::make('Berita Terbit', Article::published()->count())
                ->description('Artikel yang tampil di Kabar Desa')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info')
                ->url(ArticleResource::getUrl('index')),
        ];
    }
}