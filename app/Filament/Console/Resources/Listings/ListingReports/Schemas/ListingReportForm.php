<?php

namespace App\Filament\Console\Resources\Listings\ListingReports\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ListingReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('listing_id')
                    ->relationship('listing', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),
                TextInput::make('ip_address')
                    ->default(null),
                TextInput::make('reason')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
