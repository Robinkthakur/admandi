<?php

namespace App\Filament\Console\Resources\Listings\Listings\Pages;

use App\Filament\Console\Resources\Listings\Listings\ListingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListListings extends ListRecords
{
    protected static string $resource = ListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
