<?php

namespace App\Filament\Console\Resources\Location\Locations\Pages;

use App\Filament\Console\Resources\Location\Locations\LocationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLocation extends EditRecord
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index', ['parentId' => $this->record->parent_id]);
    }
}
