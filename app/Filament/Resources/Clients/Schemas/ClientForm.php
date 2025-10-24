<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\Fieldset::make('Contact information')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->columnSpanFull()
                            ->label("Client name")
                            ->required(),
                        Forms\Components\Radio::make('type')
                            ->label("Type of client")
                            ->columnSpanFull()
                            ->options(["company", "individual"])
                            ->inline(),
                        Forms\Components\TextInput::make('email')
                            ->label("Email"),
                        Forms\Components\TextInput::make('phone_number')
                            ->label("Phone Numebr")
                    ]),

                    Forms\Components\Repeater::make('notes')
                        ->schema([
                            Forms\Components\Textarea::make('content')
                                ->label("Note: ")
                                ->required()
                        ])
                        ->columnSpanFull()
                        ->relationship()



            ]);
    }
}
