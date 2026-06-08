<?php

namespace App\Filament\Console\Resources\Admins\Pages;

use App\Filament\Console\Resources\Admins\AdminResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;
}
