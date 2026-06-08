<?php

namespace App\Filament\Console\Resources\Location\Locations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Location\Location;

class LocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->description(fn (Location $record) => $record->type ? ucfirst($record->type) : null)
                    ->action(function ($livewire, Location $record) {
                        $livewire->parentId = $record->id;
                    }),
                TextColumn::make('children_count')
                    ->counts('children')
                    ->label('Sub-locations')
                    ->badge()
                    ->color('primary')
                    ->action(function ($livewire, Location $record) {
                        $livewire->parentId = $record->id;
                    }),
                TextColumn::make('parent.name')
                    ->label('Parent Location')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->searchable(),
                TextColumn::make('longitude')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                Action::make('viewChildren')
                    ->label('Children')
                    ->icon('heroicon-m-folder-open')
                    ->color('info')
                    ->action(function ($livewire, Location $record) {
                        $livewire->parentId = $record->id;
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
