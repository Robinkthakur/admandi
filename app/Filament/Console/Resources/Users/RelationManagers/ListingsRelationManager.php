<?php

namespace App\Filament\Console\Resources\Users\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Actions;

class ListingsRelationManager extends RelationManager
{
    protected static string $relationship = 'listings';

    protected static ?string $title = 'User Listings';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->collection('listings')
                    ->width(50)
                    ->square()
                    ->circular()
                    ->conversion('thumb')
                    ->stacked(),
                TextColumn::make('ad_id')
                    ->label('Ad ID')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable()
                    ->url(fn ($record) => route('filament.console.resources.listings.listings.view', ['record' => $record->id])),
                TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('views')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        'spam' => 'danger',
                        'sold' => 'gray',
                        default => 'primary',
                    }),
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Posted At')
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
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
