<?php

namespace App\Filament\Console\Resources\ContactEnquiries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ContactEnquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->disabled()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->disabled()
                    ->required(),
                TextInput::make('subject')
                    ->disabled()
                    ->required(),
                Textarea::make('message')
                    ->disabled()
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'responded' => 'Responded',
                        'closed' => 'Closed',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
