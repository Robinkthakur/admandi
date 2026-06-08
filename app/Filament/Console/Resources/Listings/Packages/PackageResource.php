<?php

namespace App\Filament\Console\Resources\Listings\Packages;

use App\Filament\Console\Resources\Listings\Packages\Pages\CreatePackage;
use App\Filament\Console\Resources\Listings\Packages\Pages\EditPackage;
use App\Filament\Console\Resources\Listings\Packages\Pages\ListPackages;
use App\Filament\Console\Resources\Listings\Packages\Schemas\PackageForm;
use App\Filament\Console\Resources\Listings\Packages\Tables\PackagesTable;
use App\Models\Listings\Package;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $modelLabel = 'Boost Package';

    protected static ?string $pluralModelLabel = 'Boost Packages';

    protected static \UnitEnum|string|null $navigationGroup = 'Marketplace';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bolt';

    public static function form(Schema $schema): Schema
    {
        return PackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PackagesTable::configure($table);
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
            'index' => ListPackages::route('/'),
            'create' => CreatePackage::route('/create'),
            'edit' => EditPackage::route('/{record}/edit'),
        ];
    }
}
