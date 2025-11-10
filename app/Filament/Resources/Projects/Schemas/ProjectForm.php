<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Client;
use App\Models\Status;
use Filament\Forms\Components;
use Filament\Forms\Components\Select;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

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
                            ->relationship('client', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('user_id', auth()->id()))
                            ->searchable()
                            ->preload(),


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
                                ->default(fn (callable $get) => $get('price') - $get('advance'))
                                ->afterStateHydrated(fn ($set, callable $get) => $set('final_payment', ($get('price') - $get('advance')) ?? 0))
                                ->readOnly(),



                            Components\Toggle::make('is_advance_paid')
                                ->label("Advance Paid?"),
                            Components\Toggle::make('is_fully_paid')
                                ->label("Advance Paid?"),

                            Components\FileUpload::make('advance_invoice')
                                ->label('Invoice of advance')
                                ->placeholder('upload invoice')
                                ->downloadable(),

                            Components\FileUpload::make('final_invoice')
                                ->label('Invoice of final payment')
                                ->placeholder('upload invoice')
                                ->downloadable(),
                        ])
                        ->columnSpanFull(),
                    Schemas\Components\Fieldset::make('Project Process')
                        ->schema([
                        Components\Select::make('status_id')
                            ->label('Status')
                            ->required()
                            ->columnSpanFull()
                            ->relationship('status', 'status',modifyQueryUsing: fn (Builder $query) => $query->whereNull('user_id')->orWhere('user_id', auth()->id()))
                        ])->columnSpanFull(),

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
