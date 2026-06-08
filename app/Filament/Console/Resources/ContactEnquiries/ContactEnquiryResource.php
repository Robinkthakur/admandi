<?php

namespace App\Filament\Console\Resources\ContactEnquiries;

use App\Filament\Console\Resources\ContactEnquiries\Pages\CreateContactEnquiry;
use App\Filament\Console\Resources\ContactEnquiries\Pages\EditContactEnquiry;
use App\Filament\Console\Resources\ContactEnquiries\Pages\ListContactEnquiries;
use App\Filament\Console\Resources\ContactEnquiries\Schemas\ContactEnquiryForm;
use App\Filament\Console\Resources\ContactEnquiries\Tables\ContactEnquiriesTable;
use App\Models\ContactEnquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactEnquiryResource extends Resource
{
    protected static ?string $model = ContactEnquiry::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Communications';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function form(Schema $schema): Schema
    {
        return ContactEnquiryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactEnquiriesTable::configure($table);
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
            'index' => ListContactEnquiries::route('/'),
            'create' => CreateContactEnquiry::route('/create'),
            'edit' => EditContactEnquiry::route('/{record}/edit'),
        ];
    }
}
