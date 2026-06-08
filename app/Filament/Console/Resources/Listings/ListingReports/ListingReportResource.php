<?php

namespace App\Filament\Console\Resources\Listings\ListingReports;

use App\Filament\Console\Resources\Listings\ListingReports\Pages\CreateListingReport;
use App\Filament\Console\Resources\Listings\ListingReports\Pages\EditListingReport;
use App\Filament\Console\Resources\Listings\ListingReports\Pages\ListListingReports;
use App\Filament\Console\Resources\Listings\ListingReports\Schemas\ListingReportForm;
use App\Filament\Console\Resources\Listings\ListingReports\Tables\ListingReportsTable;
use App\Models\Listings\ListingReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ListingReportResource extends Resource
{
    protected static ?string $model = ListingReport::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Marketplace';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-exclamation-triangle';

    public static function form(Schema $schema): Schema
    {
        return ListingReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ListingReportsTable::configure($table);
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
            'index' => ListListingReports::route('/'),
            'create' => CreateListingReport::route('/create'),
            'edit' => EditListingReport::route('/{record}/edit'),
        ];
    }
}
