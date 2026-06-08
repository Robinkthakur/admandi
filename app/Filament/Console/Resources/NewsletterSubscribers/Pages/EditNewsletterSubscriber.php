<?php

namespace App\Filament\Console\Resources\NewsletterSubscribers\Pages;

use App\Filament\Console\Resources\NewsletterSubscribers\NewsletterSubscriberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterSubscriber extends EditRecord
{
    protected static string $resource = NewsletterSubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
