<?php

namespace App\Filament\Console\Resources\Listings\Listings\RelationManagers;

use App\Filament\Console\Resources\Listings\Listings\Widgets\ListingViewsTrendsChart;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;

class ViewsRelationManager extends RelationManager
{
    protected static string $relationship = 'viewsLogs';

    protected static ?string $title = 'View Logs';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ip_address')
            ->columns([
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->searchable()
                    ->limit(70)
                    ->tooltip(fn ($record) => $record->user_agent),
                TextColumn::make('created_at')
                    ->label('Viewed At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ListingViewsTrendsChart::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }
}
