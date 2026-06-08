<?php

namespace App\Filament\Console\Resources\Location\Locations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('type')
                    ->options(['country' => 'Country', 'state' => 'State', 'city' => 'City', 'area' => 'Area'])
                    ->required(),
                Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                TextInput::make('latitude')
                    ->numeric()
                    ->default(null),
                TextInput::make('longitude')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
