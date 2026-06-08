<?php

namespace App\Filament\Console\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->default(null)
                    ->regex('/^[0-9]{10}$/')
                    ->validationMessages([
                        'regex' => 'The phone number must be exactly 10 digits.',
                    ]),
                FileUpload::make('avatar')
                    ->avatar()
                    ->directory('avatars')
                    ->default(null),
                DateTimePicker::make('phone_verified_at'),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),
                TextInput::make('otp_code')
                    ->default(null),
                DateTimePicker::make('otp_expires_at'),
                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),
                Toggle::make('is_verified')
                    ->required(),
                DateTimePicker::make('verified_until'),
                Toggle::make('is_suspended')
                    ->required(),
            ]);
    }
}
