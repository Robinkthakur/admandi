<?php

namespace App\Filament\Console\Widgets;

use App\Models\Listings\Listing;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Str;

class MostViewedListingsChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Most Viewed Listings (Top 10)';

    protected static ?int $sort = 2;

    protected function getData(): array
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

        $listings = Listing::query()
            ->select('listings.id', 'listings.title')
            ->selectRaw('COUNT(listing_views.id) as period_views')
            ->join('listing_views', 'listings.id', '=', 'listing_views.listing_id')
            ->when($startDate, fn ($q) => $q->whereBetween('listing_views.created_at', [$startDate, $endDate]))
            ->groupBy('listings.id', 'listings.title')
            ->orderByDesc('period_views')
            ->limit(10)
            ->get();

        if ($listings->isEmpty()) {
            // Fallback to listings with the highest total views of all time if no logs exist for this period
            $listings = Listing::query()
                ->orderByDesc('views')
                ->limit(10)
                ->get();
            $data = $listings->pluck('views')->toArray();
            $labelName = 'Total Views (All Time)';
        } else {
            $data = $listings->pluck('period_views')->toArray();
            $labelName = 'Views in Selected Period';
        }

        $labels = $listings->map(fn (Listing $listing) => Str::limit($listing->title, 25))->toArray();

        return [
            'datasets' => [
                [
                    'label' => $labelName,
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(96, 71, 230, 0.8)',
                        'rgba(26, 21, 50, 0.8)',
                        'rgba(96, 71, 230, 0.6)',
                        'rgba(26, 21, 50, 0.6)',
                        'rgba(96, 71, 230, 0.4)',
                        'rgba(26, 21, 50, 0.4)',
                        'rgba(96, 71, 230, 0.3)',
                        'rgba(26, 21, 50, 0.3)',
                        'rgba(96, 71, 230, 0.2)',
                        'rgba(26, 21, 50, 0.2)',
                    ],
                    'borderColor' => '#6047e6',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
