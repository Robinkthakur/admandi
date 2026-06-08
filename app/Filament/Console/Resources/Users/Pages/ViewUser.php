<?php

namespace App\Filament\Console\Resources\Users\Pages;

use App\Filament\Console\Resources\Users\UserResource;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\DB;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('suspend')
                ->label('Suspend User')
                ->icon('heroicon-o-lock-closed')
                ->color('danger')
                ->visible(fn ($record) => !$record->is_suspended)
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['is_suspended' => true]);
                    // Force log out active user session immediately
                    DB::table('sessions')->where('user_id', $record->id)->delete();
                }),

            Actions\Action::make('unsuspend')
                ->label('Unsuspend User')
                ->icon('heroicon-o-lock-open')
                ->color('success')
                ->visible(fn ($record) => $record->is_suspended)
                ->requiresConfirmation()
                ->action(fn ($record) => $record->update(['is_suspended' => false])),

            Actions\Action::make('verify')
                ->label('Verify Seller')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn ($record) => !$record->is_verified)
                ->form([
                    DateTimePicker::make('verified_until')
                        ->label('Verified Until')
                        ->required()
                        ->default(now()->addYear()),
                ])
                ->action(function ($record, array $data) {
                    $record->update([
                        'is_verified' => true,
                        'verified_until' => $data['verified_until'],
                    ]);
                }),

            Actions\Action::make('unverify')
                ->label('Unverify Seller')
                ->icon('heroicon-o-x-circle')
                ->color('warning')
                ->visible(fn ($record) => $record->is_verified)
                ->requiresConfirmation()
                ->action(fn ($record) => $record->update([
                    'is_verified' => false,
                    'verified_until' => null,
                ])),

            Actions\EditAction::make(),
        ];
    }
}
