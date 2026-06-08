<?php

namespace App\Filament\Console\Resources\Listings\VerificationPackages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class VerificationPackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('identifier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('duration_in_months')
                    ->label('Duration')
                    ->suffix(' Months')
                    ->sortable(),
                TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('featured_limit')
                    ->label('Featured Limit')
                    ->sortable(),
                TextColumn::make('color')
                    ->badge()
                    ->color(fn(string $state): string => in_array($state, ['primary', 'secondary', 'success', 'warning', 'danger', 'info', 'gray', 'dark']) ? $state : 'primary')
                    ->sortable(),
                TextColumn::make('badge')
                    ->placeholder('--')
                    ->sortable(),
                IconColumn::make('popular')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
