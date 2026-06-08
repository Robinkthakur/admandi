<?php

namespace App\Filament\Console\Resources\Listings\Listings;

use App\Filament\Console\Resources\Listings\Listings\Pages\CreateListing;
use App\Filament\Console\Resources\Listings\Listings\Pages\EditListing;
use App\Filament\Console\Resources\Listings\Listings\Pages\ListListings;
use App\Filament\Console\Resources\Listings\Listings\Pages\ViewListing;
use App\Filament\Console\Resources\Listings\Listings\Schemas\ListingForm;
use App\Filament\Console\Resources\Listings\Listings\Tables\ListingsTable;
use App\Filament\Console\Resources\Listings\Listings\RelationManagers\ViewsRelationManager;
use App\Models\Listings\Listing;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Marketplace';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function form(Schema $schema): Schema
    {
        return ListingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ListingsTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                \Filament\Schemas\Components\Grid::make([
                    'md' => 3,
                ])
                ->schema([
                    \Filament\Schemas\Components\Group::make([
                        \Filament\Schemas\Components\Section::make('Listing Overview')
                            ->columnSpan(2)
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('ad_id')
                                    ->label('Ad ID')
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                                    ->copyable(),
                                \Filament\Infolists\Components\TextEntry::make('title')
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                                \Filament\Infolists\Components\TextEntry::make('slug')
                                    ->placeholder('--'),
                                \Filament\Infolists\Components\TextEntry::make('price')
                                    ->money('INR'),
                                \Filament\Infolists\Components\TextEntry::make('old_price')
                                    ->label('Old Price')
                                    ->money('INR')
                                    ->placeholder('--'),
                                \Filament\Infolists\Components\TextEntry::make('views')
                                    ->numeric(),
                                \Filament\Infolists\Components\TextEntry::make('status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'active' => 'success',
                                        'pending' => 'warning',
                                        'rejected' => 'danger',
                                        'spam' => 'danger',
                                        'sold' => 'gray',
                                        default => 'primary',
                                    }),
                            ])
                            ->columns(2),

                        \Filament\Schemas\Components\Section::make('Description')
                           ->columnSpan(2)
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('description')
                                    ->html()
                                    ->columnSpanFull(),
                            ]),

                        \Filament\Schemas\Components\Section::make('Media Gallery')
                            ->columnSpan(2)
                            ->schema([
                                \Filament\Infolists\Components\SpatieMediaLibraryImageEntry::make('media')
                                    ->disk('public')    
                                    ->collection('listings')
                                    ->hiddenLabel()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['md' => 2]),

                    \Filament\Schemas\Components\Group::make([
                        \Filament\Schemas\Components\Section::make('Seller Information')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('user.name')
                                    ->label('Seller Name')
                                    ->url(fn ($record) => $record->user ? route('filament.console.resources.users.view', ['record' => $record->user->id]) : null)
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                                \Filament\Infolists\Components\TextEntry::make('user.email')
                                    ->label('Seller Email'),
                                \Filament\Infolists\Components\TextEntry::make('user.phone')
                                    ->label('Seller Phone')
                                    ->placeholder('Not provided'),
                                \Filament\Infolists\Components\IconEntry::make('user.is_verified')
                                    ->label('Verified Seller')
                                    ->boolean(),
                            ]),

                        \Filament\Schemas\Components\Section::make('Categories & Location')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('category.name')
                                    ->label('Category'),
                                \Filament\Infolists\Components\TextEntry::make('subcategory.name')
                                    ->label('Subcategory')
                                    ->placeholder('None'),
                                \Filament\Infolists\Components\TextEntry::make('location.name')
                                    ->label('City'),
                            ]),

                        \Filament\Schemas\Components\Section::make('Premium Featuring')
                            ->schema([
                                \Filament\Infolists\Components\IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->boolean(),
                                \Filament\Infolists\Components\TextEntry::make('featured_until')
                                    ->label('Featured Until')
                                    ->dateTime()
                                    ->placeholder('N/A'),
                            ]),

                        \Filament\Schemas\Components\Section::make('Timestamps')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime(),
                                \Filament\Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime(),
                            ]),
                    ])
                    ->columnSpan(['md' => 1]),
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ViewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListListings::route('/'),
            'create' => CreateListing::route('/create'),
            'view' => ViewListing::route('/{record}'),
            'edit' => EditListing::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
