<?php

namespace App\Filament\Console\Resources\NewsletterSubscribers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class NewsletterSubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),
            ]);
    }
}
