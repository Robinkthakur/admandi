<?php

namespace App\Filament\Console\Resources\Listings\Listings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
class ListingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->collection('listings')
                    ->width(200)
                    ->square()
                    ->limit(3)
                    ->circular()
                    ->conversion('thumb')
                    ->defaultImageUrl(asset('images/no-product.webp'))
                    ->stacked(),
                TextColumn::make('ad_id')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Seller')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('location.name')
                    ->label('City')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('views')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('featured_until')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
