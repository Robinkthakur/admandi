<?php

namespace App\Filament\Console\Resources\Users;

use App\Filament\Console\Resources\Users\Pages\CreateUser;
use App\Filament\Console\Resources\Users\Pages\EditUser;
use App\Filament\Console\Resources\Users\Pages\ListUsers;
use App\Filament\Console\Resources\Users\Pages\ViewUser;
use App\Filament\Console\Resources\Users\Schemas\UserForm;
use App\Filament\Console\Resources\Users\Tables\UsersTable;
use App\Filament\Console\Resources\Users\RelationManagers\ListingsRelationManager;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static \UnitEnum|string|null $navigationGroup = 'User & Access';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Grid::make([
                    'md' => 3,
                ])
                ->schema([
                    \Filament\Schemas\Components\Group::make([
                        \Filament\Schemas\Components\Section::make('Profile Information')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('name')
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                                \Filament\Infolists\Components\TextEntry::make('email')
                                    ->label('Email Address')
                                    ->copyable(),
                                \Filament\Infolists\Components\TextEntry::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('Not provided'),
                                \Filament\Infolists\Components\TextEntry::make('location.name')
                                    ->label('Location')
                                    ->placeholder('Global'),
                                
                                \Filament\Infolists\Components\IconEntry::make('is_verified')
                                    ->label('Verified Seller')
                                    ->boolean(),
                                \Filament\Infolists\Components\TextEntry::make('verified_until')
                                    ->label('Verified Until')
                                    ->dateTime()
                                    ->placeholder('N/A'),

                                \Filament\Infolists\Components\IconEntry::make('is_suspended')
                                    ->label('Suspended')
                                    ->boolean()
                                    ->color('danger'),
                            ])
                            ->columns(2),
                            
                        \Filament\Schemas\Components\Section::make('Timestamps & Verifications')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->dateTime()
                                    ->placeholder('Not Verified'),
                                \Filament\Infolists\Components\TextEntry::make('phone_verified_at')
                                    ->label('Phone Verified At')
                                    ->dateTime()
                                    ->placeholder('Not Verified'),
                                \Filament\Infolists\Components\TextEntry::make('created_at')
                                    ->label('Registered On')
                                    ->dateTime(),
                                \Filament\Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['md' => 2]),

                    \Filament\Schemas\Components\Group::make([
                        \Filament\Schemas\Components\Section::make('Avatar')
                            ->schema([
                                \Filament\Infolists\Components\ImageEntry::make('avatar')
                                    ->hiddenLabel()
                                    ->circular()
                                    ->disk('public'),
                            ]),

                        \Filament\Schemas\Components\Section::make('OTP Details')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('otp_code')
                                    ->label('OTP Code')
                                    ->placeholder('None'),
                                \Filament\Infolists\Components\TextEntry::make('otp_expires_at')
                                    ->label('OTP Expires At')
                                    ->dateTime()
                                    ->placeholder('N/A'),
                            ]),
                    ])
                    ->columnSpan(['md' => 1]),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ListingsRelationManager::class,
            RelationManagers\ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
