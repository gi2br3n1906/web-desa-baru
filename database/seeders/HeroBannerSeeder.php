<?php

namespace Database\Seeders;

use App\Models\HeroBanner;
use App\Support\BrandAssets;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class HeroBannerSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['hero-banner-1', 'Selamat Datang di Portal Informasi dan Layanan Desa Pringanom'],
            ['hero-banner-2', 'Tumbuh Bersama dari Potensi Pertanian Desa'],
            ['hero-banner-3', 'Pelayanan Lebih Dekat, Informasi Lebih Terbuka'],
        ];

        $fallbackImage = BrandAssets::image('hero-banner-1');

        foreach ($defaults as $sortOrder => [$assetName, $title]) {
            $sourcePath = BrandAssets::image($assetName) ?? $fallbackImage;

            if (! $sourcePath) {
                continue;
            }

            $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
            $imagePath = "carousel-banners/{$assetName}.{$extension}";
            $destination = storage_path("app/public/{$imagePath}");

            File::ensureDirectoryExists(dirname($destination));

            if (! File::exists($destination)) {
                File::copy(public_path($sourcePath), $destination);
            }

            HeroBanner::firstOrCreate(
                ['image_path' => $imagePath],
                [
                    'title' => $title,
                    'subtitle' => 'Portal resmi untuk layanan administrasi, informasi desa, kesehatan, pertanian, fasilitas publik, dan pemberdayaan masyarakat.',
                    'button_text' => 'Jelajahi Layanan',
                    'button_url' => '/layanan',
                    'sort_order' => $sortOrder,
                    'is_active' => true,
                ],
            );
        }
    }
}