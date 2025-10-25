<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Client;
use Filament\Forms\Components;
use Filament\Schemas;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Fieldset::make('Project information')
                    ->columnSpanFull()
                    ->schema([
                        Components\TextInput::make('name')
                            ->label('Project Name')
                            ->required()
                            ->columnSpanFull(),

                        Components\Select::make('client_id')
                            ->required()
                            ->columnSpanFull()
                            ->options(Client::pluck('name','id')->toArray()),

                        Components\DatePicker::make('deadline')
                            ->label("Deadline")
                            ->required(),

                        Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('OMR')
                            ->minValue(0)
                            ->required()
                            ->default(0),

                        Components\Textarea::make('description')
                            ->label("Project description")
                            ->columnSpanFull(),
                    ]),
                    Schemas\Components\Fieldset::make('Attachments')
                        ->columnSpanFull()
                        ->schema([
                            Components\FileUpload::make('agreement')
                                ->label('Agreement file (scope of work)')
                                ->placeholder('scope_of_work.pdf')
                                ->downloadable(),

                            Components\FileUpload::make('signed_agreement')
                                ->label('Signed version of agreement')
                                ->placeholder('signed_scope_of_work.pdf')
                                ->downloadable()
                        ])
            ]);
    }
}
