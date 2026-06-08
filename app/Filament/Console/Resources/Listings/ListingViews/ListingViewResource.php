<?php

namespace App\Filament\Console\Resources\Listings\ListingViews;

use App\Filament\Console\Resources\Listings\ListingViews\Pages\ListListingViews;
use App\Filament\Console\Resources\Listings\ListingViews\Tables\ListingViewsTable;
use App\Models\Listings\ListingView;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ListingViewResource extends Resource
{
    protected static ?string $model = ListingView::class;

    protected static ?string $navigationLabel = 'Listing Views';

    protected static ?string $modelLabel = 'Listing View';

    protected static \UnitEnum|string|null $navigationGroup = 'Marketplace';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-eye';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return ListingViewsTable::configure($table);
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
            'index' => ListListingViews::route('/'),
        ];
    }
}
