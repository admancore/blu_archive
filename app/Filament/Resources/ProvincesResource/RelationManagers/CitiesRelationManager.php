<?php

namespace App\Filament\Resources\ProvincesResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'Cities';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            Card::make([
                TextInput::make('city_name')
                    ->label('Nama Kota')
                    ->required(),
            ])
            ->columns(1),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('prov_id')
            ->columns([
                Tables\Columns\TextColumn::make('city_name')->label('Kota'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
