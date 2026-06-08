<?php

namespace App\Filament\Console\Resources\Listings\Listings\Pages;

use App\Filament\Console\Resources\Listings\Listings\ListingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditListing extends EditRecord
{
    protected static string $resource = ListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
