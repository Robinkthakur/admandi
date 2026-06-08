<?php

namespace App\Filament\Console\Resources\Listings\Listings\Pages;

use App\Filament\Console\Resources\Listings\Listings\ListingResource;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Pages\ViewRecord;

class ViewListing extends ViewRecord
{
    protected static string $resource = ListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->label('Approve')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record) => $record->status !== 'active')
                ->requiresConfirmation()
                ->action(fn ($record) => $record->update(['status' => 'active'])),

            Actions\Action::make('reject')
                ->label('Reject')
                ->icon('heroicon-o-x-circle')
                ->color('warning')
                ->visible(fn ($record) => $record->status !== 'rejected')
                ->requiresConfirmation()
                ->action(fn ($record) => $record->update(['status' => 'rejected'])),

            Actions\Action::make('markSpam')
                ->label('Mark as Spam')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger')
                ->visible(fn ($record) => $record->status !== 'spam')
                ->requiresConfirmation()
                ->action(fn ($record) => $record->update(['status' => 'spam'])),

            Actions\Action::make('feature')
                ->label('Feature Listing')
                ->icon('heroicon-o-star')
                ->color('primary')
                ->form([
                    DateTimePicker::make('featured_until')
                        ->label('Feature Until')
                        ->required()
                        ->default(now()->addWeek()),
                ])
                ->action(function ($record, array $data) {
                    $record->update([
                        'is_featured' => true,
                        'featured_until' => $data['featured_until'],
                    ]);
                }),

            Actions\Action::make('unfeature')
                ->label('Remove Feature')
                ->icon('heroicon-o-minus-circle')
                ->color('gray')
                ->visible(fn ($record) => $record->is_featured)
                ->requiresConfirmation()
                ->action(fn ($record) => $record->update([
                    'is_featured' => false,
                    'featured_until' => null,
                ])),

            Actions\EditAction::make(),
        ];
    }
}
