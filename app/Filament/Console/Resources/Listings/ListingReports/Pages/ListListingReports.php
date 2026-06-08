<?php

namespace App\Filament\Console\Resources\Listings\ListingReports\Pages;

use App\Filament\Console\Resources\Listings\ListingReports\ListingReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListListingReports extends ListRecords
{
    protected static string $resource = ListingReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
