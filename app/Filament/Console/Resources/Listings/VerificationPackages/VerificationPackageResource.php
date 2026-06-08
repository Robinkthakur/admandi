<?php

namespace App\Filament\Console\Resources\Listings\VerificationPackages;

use App\Filament\Console\Resources\Listings\VerificationPackages\Pages\CreateVerificationPackage;
use App\Filament\Console\Resources\Listings\VerificationPackages\Pages\EditVerificationPackage;
use App\Filament\Console\Resources\Listings\VerificationPackages\Pages\ListVerificationPackages;
use App\Filament\Console\Resources\Listings\VerificationPackages\Schemas\VerificationPackageForm;
use App\Filament\Console\Resources\Listings\VerificationPackages\Tables\VerificationPackagesTable;
use App\Models\Listings\VerificationPackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class VerificationPackageResource extends Resource
{
    protected static ?string $model = VerificationPackage::class;

    protected static ?string $modelLabel = 'Verification Package';

    protected static ?string $pluralModelLabel = 'Verification Packages';

    protected static \UnitEnum|string|null $navigationGroup = 'Marketplace';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Schema $schema): Schema
    {
        return VerificationPackageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VerificationPackagesTable::configure($table);
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
            'index' => ListVerificationPackages::route('/'),
            'create' => CreateVerificationPackage::route('/create'),
            'edit' => EditVerificationPackage::route('/{record}/edit'),
        ];
    }
}
