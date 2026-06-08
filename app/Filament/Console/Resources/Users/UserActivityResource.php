<?php

namespace App\Filament\Console\Resources\Users;

use App\Filament\Console\Resources\Users\Pages\ListUserActivities;
use App\Filament\Console\Resources\Users\Tables\UserActivitiesTable;
use App\Models\UserActivity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UserActivityResource extends Resource
{
    protected static ?string $model = UserActivity::class;

    protected static ?string $navigationLabel = 'User Activities';

    protected static ?string $modelLabel = 'User Activity';

    protected static \UnitEnum|string|null $navigationGroup = 'User & Access';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return UserActivitiesTable::configure($table);
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
            'index' => ListUserActivities::route('/'),
        ];
    }
}
