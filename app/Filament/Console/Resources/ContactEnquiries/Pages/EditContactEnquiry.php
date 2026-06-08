<?php

namespace App\Filament\Console\Resources\ContactEnquiries\Pages;

use App\Filament\Console\Resources\ContactEnquiries\ContactEnquiryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactEnquiry extends EditRecord
{
    protected static string $resource = ContactEnquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
