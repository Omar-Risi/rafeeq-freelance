<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Client;
use App\Models\Status;
use Filament\Forms\Components;
use Filament\Forms\Components\Select;
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
                            ->label('Client')
                            ->required()
                            ->columnSpanFull()
                            ->relationship('client', 'name'),


                        Components\DatePicker::make('deadline')
                            ->label("Deadline")
                            ->required(),


                        Components\Textarea::make('description')
                            ->label("Project description")
                            ->columnSpanFull(),
                    ]),

                    Schemas\Components\Fieldset::make('Project Pricing')
                        ->schema([
                            Components\TextInput::make('price')
                                ->numeric()
                                ->prefix('OMR')
                                ->minValue(0)
                                ->required()
                                ->reactive()
                                ->default(0)
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $set('final_payment', ($state - $get('advance')) ?? 0);
                                })
                                ->columnSpanFull(),

                            Components\TextInput::make('advance')
                                ->label("Advance Payment")
                                ->numeric()
                                ->prefix('OMR')
                                ->reactive()
                                ->minValue(0)
                                ->default(0)
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $set('final_payment', ($get('price') - $state) ?? 0);
                                }),

                            Components\TextInput::make('final_payment')
                                ->label("Final Payment")
                                ->numeric()
                                ->prefix('OMR')
                                ->default(0)
                                ->readOnly(),
                        ])
                        ->columnSpanFull(),
                    Schemas\Components\Fieldset::make('Project Process')
                        ->schema([

                            Components\Select::make('status')
                                ->label("Project Status")
                                ->options(Status::pluck('status','status'))
                                ->columnSpanFull(),
                        ])
                        ->columnSpanFull(),

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
