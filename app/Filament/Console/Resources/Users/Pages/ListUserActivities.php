<?php

namespace App\Filament\Console\Resources\Users\Pages;

use App\Filament\Console\Resources\Users\UserActivityResource;
use Filament\Resources\Pages\ListRecords;

class ListUserActivities extends ListRecords
{
    protected static string $resource = UserActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
