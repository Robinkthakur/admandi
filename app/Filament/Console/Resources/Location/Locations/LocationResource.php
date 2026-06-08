<?php

namespace App\Filament\Console\Resources\Location\Locations;

use App\Filament\Console\Resources\Location\Locations\Pages\CreateLocation;
use App\Filament\Console\Resources\Location\Locations\Pages\EditLocation;
use App\Filament\Console\Resources\Location\Locations\Pages\ListLocations;
use App\Filament\Console\Resources\Location\Locations\Schemas\LocationForm;
use App\Filament\Console\Resources\Location\Locations\Tables\LocationsTable;
use App\Models\Location\Location;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Marketplace';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Schema $schema): Schema
    {
        return LocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LocationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLocations::route('/'),
            'create' => CreateLocation::route('/create'),
            'edit' => EditLocation::route('/{record}/edit'),
        ];
    }
}
