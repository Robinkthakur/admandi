<?php

namespace App\Filament\Console\Resources\Category\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('in_hn')
                    ->label('Hindi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('in_pb')
                    ->label('Punjabi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('status')
                    ->boolean()
                    ->sortable(),
                ImageColumn::make('image'),
                TextColumn::make('order_no')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bgColor')
                    ->label('BG Color')
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
