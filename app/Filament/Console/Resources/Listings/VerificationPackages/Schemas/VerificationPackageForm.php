<?php

namespace App\Filament\Console\Resources\Listings\VerificationPackages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VerificationPackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('identifier')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., starter_pro, professional, elite'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('duration_in_months')
                    ->label('Duration (Months)')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('₹')
                    ->minValue(0),
                TextInput::make('featured_limit')
                    ->label('Featured Ads Limit')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('color')
                    ->placeholder('e.g., primary, success, warning, danger, info, dark'),
                TextInput::make('badge')
                    ->placeholder('e.g., Standard, Popular, Best Value'),
                Toggle::make('popular')
                    ->label('Mark as Popular')
                    ->default(false),
            ]);
    }
}
