<?php

namespace App\Filament\Console\Resources\NewsletterSubscribers\Pages;

use App\Filament\Console\Resources\NewsletterSubscribers\NewsletterSubscriberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletterSubscriber extends CreateRecord
{
    protected static string $resource = NewsletterSubscriberResource::class;
}
