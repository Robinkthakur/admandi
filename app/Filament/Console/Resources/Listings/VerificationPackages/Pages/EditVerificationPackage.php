<?php

namespace App\Filament\Console\Resources\Listings\VerificationPackages\Pages;

use App\Filament\Console\Resources\Listings\VerificationPackages\VerificationPackageResource;
use Filament\Resources\Pages\EditRecord;

class EditVerificationPackage extends EditRecord
{
    protected static string $resource = VerificationPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
