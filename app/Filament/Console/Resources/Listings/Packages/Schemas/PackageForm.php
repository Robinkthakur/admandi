<?php

namespace App\Filament\Console\Resources\Listings\Packages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('duration_in_days')
                    ->label('Duration (Days)')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('₹')
                    ->minValue(0),
                Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
