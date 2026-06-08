<?php

namespace App\Filament\Console\Resources\ContactEnquiries\Pages;

use App\Filament\Console\Resources\ContactEnquiries\ContactEnquiryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactEnquiry extends CreateRecord
{
    protected static string $resource = ContactEnquiryResource::class;
}
