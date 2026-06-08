<?php

namespace App\Filament\Console\Resources\Listings\Listings\Pages;

use App\Filament\Console\Resources\Listings\Listings\ListingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateListing extends CreateRecord
{
    protected static string $resource = ListingResource::class;
}
