<?php

namespace App\Filament\Console\Resources\Location\Locations\Pages;

use App\Filament\Console\Resources\Location\Locations\LocationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (request()->has('parentId')) {
            $data['parent_id'] = request()->query('parentId');
        }
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index', ['parentId' => $this->record->parent_id]);
    }
}
