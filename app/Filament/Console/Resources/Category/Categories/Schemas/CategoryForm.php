<?php

namespace App\Filament\Console\Resources\Category\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('in_hn')
                    ->label('Hindi Translation')
                    ->maxLength(255)
                    ->default(null),
                TextInput::make('in_pb')
                    ->label('Punjabi Translation')
                    ->maxLength(255)
                    ->default(null),
                Toggle::make('status')
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->directory('categories')
                    ->default(null),
                TextInput::make('order_no')
                    ->numeric()
                    ->default(0),
                TextInput::make('bgColor')
                    ->default(null),
            ]);
    }
}
