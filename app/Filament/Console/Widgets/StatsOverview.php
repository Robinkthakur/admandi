<?php

namespace App\Filament\Console\Widgets;

use App\Models\User;
use App\Models\Listings\Listing;
use App\Models\Listings\ListingReport;
use App\Models\NewsletterSubscriber;
use App\Models\ContactEnquiry;
use App\Models\Listings\ListingView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $dateRange = $this->pageFilters['dateRange'] ?? 'week';
        
        $startDate = null;
        $endDate = null;

        switch ($dateRange) {
            case 'today':
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'all':
            default:
                break;
        }

        $usersCount = User::query()
            ->when($startDate, fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
            ->count();

        $activeUsers15m = \App\Models\UserActivity::query()
            ->where('user_type', \App\Models\User::class)
            ->where('created_at', '>=', now()->subMinutes(15))
            ->distinct('user_id')
            ->count('user_id');

        $activeUsers24h = \App\Models\UserActivity::query()
            ->where('user_type', \App\Models\User::class)
            ->where('created_at', '>=', now()->subHours(24))
            ->distinct('user_id')
            ->count('user_id');

        $listingsCount = Listing::query()
            ->when($startDate, fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
            ->count();

        $activeListingsCount = Listing::where('status', 'active')
            ->when($startDate, fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
            ->count();

        $viewsCount = ListingView::query()
            ->when($startDate, fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
            ->count();

        $reportsCount = ListingReport::query()
            ->when($startDate, fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
            ->count();

        $pendingEnquiriesCount = ContactEnquiry::where('status', 'pending')
            ->when($startDate, fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate]))
            ->count();

        return [
            Stat::make('Total Users', $usersCount)
                ->description('Registered accounts')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->url(route('filament.console.resources.users.index')),
            Stat::make('Live Online Users', $activeUsers15m)
                ->description($activeUsers24h . ' active in last 24 hours')
                ->descriptionIcon('heroicon-m-users')
                ->color($activeUsers15m > 0 ? 'success' : 'gray')
                ->url(route('filament.console.resources.users.user-activities.index')),
            Stat::make('Total Listings', $listingsCount)
                ->description($activeListingsCount . ' active listings')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success')
                ->url(route('filament.console.resources.listings.listings.index')),
            Stat::make('Listing Views', $viewsCount)
                ->description('Total page views')
                ->descriptionIcon('heroicon-m-eye')
                ->color('warning')
                ->url(route('filament.console.resources.listings.listing-views.index')),
            Stat::make('Spam Reports', $reportsCount)
                ->description('Pending review')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($reportsCount > 0 ? 'danger' : 'success')
                ->url(route('filament.console.resources.listings.listing-reports.index')),
            Stat::make('Contact Enquiries', $pendingEnquiriesCount)
                ->description('Unresolved messages')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color($pendingEnquiriesCount > 0 ? 'warning' : 'success')
                ->url(route('filament.console.resources.contact-enquiries.index')),
        ];
    }
}
