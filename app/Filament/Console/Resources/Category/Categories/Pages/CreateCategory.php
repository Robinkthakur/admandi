<?php

namespace App\Filament\Console\Resources\Category\Categories\Pages;

use App\Filament\Console\Resources\Category\Categories\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
