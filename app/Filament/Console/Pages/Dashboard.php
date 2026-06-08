<?php

namespace App\Filament\Console\Pages;

use Filament\Forms\Components\ToggleButtons;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
               ToggleButtons::make('dateRange')
                    ->hiddenLabel()
                    ->inline()
                    ->grouped()
                    ->label('Filter by Date')
                    ->options([
                        'today' => 'Today',
                        'week' => 'This Week',
                        'month' => 'This Month',
                        'all' => 'All Time',
                    ])
                    ->default('week')
                    ->live(),
            ]);
    }
}
