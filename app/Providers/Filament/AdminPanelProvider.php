<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Widgets\QuickMenuWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Support\BrandAssets;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandName('Pemerintahan Desa Pringanom')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()->label('Pemerintahan & Profil'),
                NavigationGroup::make()->label('Kabar & Informasi'),
                NavigationGroup::make()->label('Fasilitas & Kesehatan'),
                NavigationGroup::make()->label('Pemberdayaan & UMKM'),
                NavigationGroup::make()->label('Sistem'),
            ])
            ->widgets([
                StatsOverviewWidget::class,
                QuickMenuWidget::class,
            ])
            ->renderHook(PanelsRenderHook::HEAD_END, fn () => view('filament.pwa.head'))
            ->renderHook(PanelsRenderHook::TOPBAR_END, fn () => view('filament.pwa.status'))
            ->renderHook(PanelsRenderHook::BODY_END, fn () => view('filament.pwa.scripts'))
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

        $sragenLogoPath = BrandAssets::sragenLogo();

        if ($sragenLogoPath) {
            $panel
                ->brandLogo(asset($sragenLogoPath))
                ->favicon(asset($sragenLogoPath));
        }

        return $panel;
    }
}
