<?php

namespace App\Filament\Console\Resources\Listings\ListingViews\Pages;

use App\Filament\Console\Resources\Listings\ListingViews\ListingViewResource;
use Filament\Resources\Pages\ListRecords;

class ListListingViews extends ListRecords
{
    protected static string $resource = ListingViewResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
