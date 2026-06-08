<?php

namespace App\Filament\Console\Resources\Listings\Packages\Pages;

use App\Filament\Console\Resources\Listings\Packages\PackageResource;
use Filament\Resources\Pages\EditRecord;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
