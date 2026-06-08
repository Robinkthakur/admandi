<?php

namespace App\Filament\Console\Resources\Listings\VerificationPackages\Pages;

use App\Filament\Console\Resources\Listings\VerificationPackages\VerificationPackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVerificationPackages extends ListRecords
{
    protected static string $resource = VerificationPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
