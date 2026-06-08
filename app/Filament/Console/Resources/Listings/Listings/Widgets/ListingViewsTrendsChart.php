<?php

namespace App\Filament\Console\Resources\Listings\Listings\Widgets;

use App\Models\Listings\ListingView;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Model;

class ListingViewsTrendsChart extends ChartWidget
{
    protected ?string $heading = 'Views Over Time (Last 30 Days)';

    protected ?string $maxHeight = '200px';

    public ?Model $ownerRecord = null;

    protected function getData(): array
    {
        $listingId = $this->ownerRecord?->id;
        $data = [];
        $labels = [];

        // Last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $count = $listingId 
                ? ListingView::where('listing_id', $listingId)
                    ->whereDate('created_at', $day->toDateString())
                    ->count()
                : 0;
            $data[] = $count;
            $labels[] = $day->format('d M');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Daily Views',
                    'data' => $data,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.15)',
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
