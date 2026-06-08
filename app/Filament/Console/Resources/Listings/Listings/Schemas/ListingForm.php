<?php

namespace App\Filament\Console\Resources\Listings\Listings\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ListingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ad_id')
                    ->required()
                    ->maxLength(20)
                    ->default(null),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('subcategory_id')
                    ->relationship('subcategory', 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),
                Select::make('city_id')
                    ->label('City')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->prefix('$'),
                TextInput::make('old_price')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('views')
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'rejected' => 'Rejected',
                        'spam' => 'Spam',
                        'sold' => 'Sold',
                        'expired' => 'Expired',
                    ])
                    ->default('pending')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                DateTimePicker::make('featured_until'),
            ]);
    }
}
