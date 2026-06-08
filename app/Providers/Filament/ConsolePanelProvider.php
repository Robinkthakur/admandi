<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Console\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ConsolePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('console')
            ->path('console')
            ->viteTheme('resources/css/filament/console/theme.css')
            ->brandLogo('/logo.png')
            ->brandLogoHeight('40px')
            ->font('Outfit')
            ->sidebarWidth('15rem')
            ->login()
            ->colors([
                'primary' => '#1a1532',
            ])
            ->discoverResources(in: app_path('Filament/Console/Resources'), for: 'App\Filament\Console\Resources')
            ->discoverPages(in: app_path('Filament/Console/Pages'), for: 'App\Filament\Console\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Console/Widgets'), for: 'App\Filament\Console\Widgets')
            ->widgets([
                // AccountWidget::class,
                \App\Filament\Console\Widgets\StatsOverview::class,
                \App\Filament\Console\Widgets\ListingsChart::class,
                \App\Filament\Console\Widgets\MostViewedListingsChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authGuard('admin')
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
