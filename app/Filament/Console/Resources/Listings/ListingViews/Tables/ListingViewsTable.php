<?php

namespace App\Filament\Console\Resources\Listings\ListingViews\Tables;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ListingViewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('listing.title')
                    ->label('Listing')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => $record->listing ? route('filament.console.resources.listings.listings.edit', ['record' => $record->listing->id]) : null),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->user_agent),
                TextColumn::make('created_at')
                    ->label('Viewed At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->groups([
                Group::make('created_at')
                    ->label('View Date')
                    ->date(),
                Group::make('listing.title')
                    ->label('Listing'),
            ])
            ->defaultGroup('created_at')
            ->filters([
                Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('viewed_from')
                            ->label('Viewed From'),
                        \Filament\Forms\Components\DatePicker::make('viewed_until')
                            ->label('Viewed Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['viewed_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['viewed_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
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
}
