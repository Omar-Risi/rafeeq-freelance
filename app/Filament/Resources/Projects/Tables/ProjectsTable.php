<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('Client name'),
                TextColumn::make('name')
                    ->label('Project name'),
                TextColumn::make('status.status')
                    ->label('Project status')
                    ->badge(),
                TextColumn::make('price')
                    ->prefix('OMR ')
                    ->label('Price')
                    ->badge(),
                IconColumn::make('is_fully_paid')
                    ->label('Payment fullfilled?')
                    ->boolean(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(function (Builder $query) {

                if(auth()->user()->isAdmin())
                    return $query;

                return $query->where('user_id',auth()->id());
            });
    }
}
