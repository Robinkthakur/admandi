<?php

namespace App\Filament\Console\Resources\Users\Pages;

use App\Filament\Console\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
