<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('User Information')->schema([

                    TextInput::make('name')
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('email')
                        ->label('Email address')
                        ->email()
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('password')
                        ->password()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->columnSpanFull(),
                    Components\Toggle::make('is_admin')->label("Admin")
                ])->columnSpanFull(),
                DateTimePicker::make('email_verified_at'),
                Textarea::make('two_factor_secret')
                    ->columnSpanFull(),
                Textarea::make('two_factor_recovery_codes')
                    ->columnSpanFull(),
                DateTimePicker::make('two_factor_confirmed_at'),
            ]);
    }
}
