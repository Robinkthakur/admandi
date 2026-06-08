<?php

namespace App\Filament\Console\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;

class UserActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User/Admin')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Guest')
                    ->url(fn($record) => url('/console/users/'.$record->user?->id))
                    ->description(fn ($record) => $record->user_type ? class_basename($record->user_type) : null),
                TextColumn::make('activity')
                    ->label('Activity')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Login' => 'success',
                        'Logout' => 'gray',
                        'Registered' => 'info',
                        'Listing Created' => 'warning',
                        'Listing Updated' => 'info',
                        'Listing Deleted' => 'danger',
                        'Listing Paused' => 'warning',
                        'Listing Sold' => 'success',
                        'Listing Activated' => 'success',
                        'Profile Updated' => 'primary',
                        'Wishlist Added' => 'success',
                        'Wishlist Removed' => 'gray',
                        'Listing Reported' => 'danger',
                        'Ad Boosted' => 'success',
                        'Verification Purchased' => 'success',
                        default => 'primary',
                    }),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->wrap()
                    ->limit(80)
                    ->tooltip(fn ($record) => $record->description),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->user_agent)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Logged At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('activity')
                    ->options([
                        'Login' => 'Login',
                        'Logout' => 'Logout',
                        'Registered' => 'Registered',
                        'Listing Created' => 'Listing Created',
                        'Listing Updated' => 'Listing Updated',
                        'Listing Deleted' => 'Listing Deleted',
                        'Listing Paused' => 'Listing Paused',
                        'Listing Sold' => 'Listing Sold',
                        'Listing Activated' => 'Listing Activated',
                        'Profile Updated' => 'Profile Updated',
                        'Wishlist Added' => 'Wishlist Added',
                        'Wishlist Removed' => 'Wishlist Removed',
                        'Listing Reported' => 'Listing Reported',
                        'Ad Boosted' => 'Ad Boosted',
                        'Verification Purchased' => 'Verification Purchased',
                    ]),
                SelectFilter::make('user_type')
                    ->label('User Type')
                    ->options([
                        \App\Models\User::class => 'User',
                        \App\Models\Admin::class => 'Admin',
                    ]),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('logged_from')
                            ->label('Logged From'),
                        DatePicker::make('logged_until')
                            ->label('Logged Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['logged_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['logged_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
