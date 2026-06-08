<?php

namespace App\Filament\Console\Widgets;

use App\Models\Listings\Listing;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;

class ListingsChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 3;

    protected ?string $heading = 'Listing Creation Trends';

    protected function getData(): array
    {
        $activeFilter = $this->pageFilters['dateRange'] ?? 'week';
        $data = [];
        $labels = [];

        switch ($activeFilter) {
            case 'today':
                for ($i = 0; $i < 24; $i++) {
                    $hour = now()->startOfDay()->addHours($i);
                    $count = Listing::whereBetween('created_at', [$hour, $hour->copy()->endOfHour()])->count();
                    $data[] = $count;
                    $labels[] = $hour->format('H:00');
                }
                break;
            case 'month':
                for ($i = 29; $i >= 0; $i--) {
                    $day = now()->subDays($i);
                    $count = Listing::whereDate('created_at', $day->toDateString())->count();
                    $data[] = $count;
                    $labels[] = $day->format('d M');
                }
                break;
            case 'all':
                // For all time, we show the trend of the last 12 months.
                for ($i = 11; $i >= 0; $i--) {
                    $month = now()->subMonths($i);
                    $count = Listing::whereMonth('created_at', $month->month)
                        ->whereYear('created_at', $month->year)
                        ->count();
                    $data[] = $count;
                    $labels[] = $month->format('M Y');
                }
                break;
            case 'week':
            default:
                for ($i = 6; $i >= 0; $i--) {
                    $day = now()->subDays($i);
                    $count = Listing::whereDate('created_at', $day->toDateString())->count();
                    $data[] = $count;
                    $labels[] = $day->format('D');
                }
                break;
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Classified Listings Created',
                    'data' => $data,
                    'borderColor' => '#6047e6',
                    'backgroundColor' => 'rgba(96, 71, 230, 0.15)',
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
