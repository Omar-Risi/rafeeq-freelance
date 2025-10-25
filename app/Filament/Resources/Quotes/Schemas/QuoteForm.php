<?php

namespace App\Filament\Resources\Quotes\Schemas;

use Filament\Forms\Components;
use Filament\Schemas\Schema;
use Filament\Schemas;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Fieldset::make('Project Data')
                    ->schema([
                        Components\Select::make('project_id')
                            ->label('Project')
                            ->relationship('project', 'name')
                            ->columnSpanFull()
                            ->required(),
                    ])->columnSpanFull(),



                    Components\Repeater::make('items')
                        ->columnSpanFull()
                        ->relationship()
                        ->schema([
                            Components\TextInput::make('name')
                                ->columnSpanFull()
                                ->label('Unit Name')
                                ->placeholder('Service name...')
                                ->required(),
                            Components\Textarea::make('description')
                                ->label('Item Description')
                                ->placeholder('front end design only...'),
                            Components\TextInput::make('price')
                                ->label('Unit price')
                                ->prefix('OMR ')
                                ->default(0)

                        ])
            ]);
    }
}
