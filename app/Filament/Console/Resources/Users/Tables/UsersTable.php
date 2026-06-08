<?php

namespace App\Filament\Console\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use App\Models\User;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->disk('public')
                    ->circular()
                    ->default(asset('icons/avatar.png'))
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->placeholder('--'),
                IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_suspended')
                    ->label('Suspended')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Registered at')
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
                ViewAction::make(),
                Action::make('suspend')
                    ->label(fn (User $record): string => $record->is_suspended ? 'Unsuspend' : 'Suspend')
                    ->color(fn (User $record): string => $record->is_suspended ? 'success' : 'danger')
                    ->icon(fn (User $record): string => $record->is_suspended ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->action(fn (User $record) => $record->update(['is_suspended' => !$record->is_suspended])),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
