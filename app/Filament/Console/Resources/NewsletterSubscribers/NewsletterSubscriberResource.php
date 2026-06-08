<?php

namespace App\Filament\Console\Resources\NewsletterSubscribers;

use App\Filament\Console\Resources\NewsletterSubscribers\Pages\CreateNewsletterSubscriber;
use App\Filament\Console\Resources\NewsletterSubscribers\Pages\EditNewsletterSubscriber;
use App\Filament\Console\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers;
use App\Filament\Console\Resources\NewsletterSubscribers\Schemas\NewsletterSubscriberForm;
use App\Filament\Console\Resources\NewsletterSubscribers\Tables\NewsletterSubscribersTable;
use App\Models\NewsletterSubscriber;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NewsletterSubscriberResource extends Resource
{
    protected static ?string $model = NewsletterSubscriber::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Communications';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    public static function form(Schema $schema): Schema
    {
        return NewsletterSubscriberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsletterSubscribersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNewsletterSubscribers::route('/'),
            'create' => CreateNewsletterSubscriber::route('/create'),
            'edit' => EditNewsletterSubscriber::route('/{record}/edit'),
        ];
    }
}
