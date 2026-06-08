<?php

namespace App\Filament\Console\Resources\Listings\Packages\Pages;

use App\Filament\Console\Resources\Listings\Packages\PackageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;
}
