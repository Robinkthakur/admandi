<?php

namespace App\Filament\Console\Resources\Listings\ListingReports\Pages;

use App\Filament\Console\Resources\Listings\ListingReports\ListingReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditListingReport extends EditRecord
{
    protected static string $resource = ListingReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
