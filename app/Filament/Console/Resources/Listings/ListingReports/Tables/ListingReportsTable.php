<?php

namespace App\Filament\Console\Resources\Listings\ListingReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Models\Listings\ListingReport;

class ListingReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('listing.title')
                    ->label('Listing')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Reported By')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->searchable(),
                TextColumn::make('reason')
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
                Action::make('approve_report')
                    ->label('Approve (Spam)')
                    ->color('danger')
                    ->icon('heroicon-o-shield-exclamation')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Report & Mark Listing as Spam')
                    ->modalDescription('This will change the status of the listing to "spam" and remove this report.')
                    ->action(function (ListingReport $record) {
                        if ($record->listing) {
                            $record->listing->update(['status' => 'spam']);
                        }
                        $record->delete();
                    }),
                Action::make('dismiss_report')
                    ->label('Dismiss')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->modalHeading('Dismiss Report')
                    ->modalDescription('This will delete the report record. The listing will remain active.')
                    ->action(function (ListingReport $record) {
                        $record->delete();
                    }),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
