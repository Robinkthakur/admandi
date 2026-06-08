<?php

namespace App\Filament\Console\Resources\Listings\Packages\Pages;

use App\Filament\Console\Resources\Listings\Packages\PackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
