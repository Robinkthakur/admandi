<?php

namespace App\Filament\Console\Resources\Category\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
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
                    ->disk('public')
                    ->default(null),
                TextInput::make('order_no')
                    ->numeric()
                    ->default(0),
                TextInput::make('bgColor')
                    ->default(null),
                Repeater::make('custom_fields')
                    ->label('Extra Specifications Fields')
                    ->schema([
                        TextInput::make('name')
                            ->label('Field Key (lowercase, e.g. brand, km_driven)')
                            ->required()
                            ->regex('/^[a-z0-9_]+$/')
                            ->validationMessages([
                                'regex' => 'The field key must only contain lowercase alphanumeric characters and underscores.',
                            ]),
                        TextInput::make('label')
                            ->label('Field Label (e.g. Brand, KM Driven)')
                            ->required(),
                        Select::make('type')
                            ->options([
                                'text' => 'Text Input',
                                'number' => 'Number Input',
                                'select' => 'Dropdown / Select',
                                'toggle' => 'Toggle Buttons',
                            ])
                            ->required()
                            ->live(),
                        TagsInput::make('options')
                            ->label('Options')
                            ->separator(',')
                            ->splitKeys(['Tab', ', '])
                            ->placeholder('Add an option and press enter')
                            ->visible(fn (callable $get) => in_array($get('type'), ['select', 'toggle']))
                            ->required(fn (callable $get) => in_array($get('type'), ['select', 'toggle'])),
                        Toggle::make('required')
                            ->label('Is Required?')
                            ->default(false),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
