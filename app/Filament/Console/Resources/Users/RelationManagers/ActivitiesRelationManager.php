<?php

namespace App\Filament\Console\Resources\Users\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $title = 'User Activities';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('activity')
            ->columns([
                TextColumn::make('activity')
                    ->label('Activity')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Login' => 'success',
                        'Logout' => 'gray',
                        'Registered' => 'info',
                        'Listing Created' => 'warning',
                        'Listing Updated' => 'info',
                        'Listing Deleted' => 'danger',
                        'Profile Updated' => 'primary',
                        'Wishlist Added' => 'success',
                        'Wishlist Removed' => 'gray',
                        'Listing Reported' => 'danger',
                        'Ad Boosted' => 'success',
                        'Verification Purchased' => 'success',
                        'Listing Paused' => 'warning',
                        'Listing Sold' => 'success',
                        'Listing Activated' => 'success',
                        default => 'primary',
                    }),
                TextColumn::make('description')
                    ->label('Description')
                    ->wrap()
                    ->limit(100)
                    ->tooltip(fn ($record) => $record->description),
                TextColumn::make('ip_address')
                    ->label('IP Address'),
                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(45)
                    ->tooltip(fn ($record) => $record->user_agent)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Logged At')
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
}
