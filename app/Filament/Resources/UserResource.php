<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\cities;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\provinces;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\bidang;
use App\Models\seksi;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function canViewAny(): bool
    {
        return auth()->user()->is_superadmin;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Details')->schema([
                    Grid::make(3)->schema([
                        TextInput::make('name')
                            ->required()->columnSpan(2),
                        TextInput::make('email')
                            ->required()
                            ->unique(ignoreRecord: true)->columnSpan(2),
                        TextInput::make('password')
                            ->required()
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->visible(fn ($livewire) => $livewire instanceof CreateUser)
                            ->rule(Password::default()),

                    ])->columnSpan(2),
                    Fieldset::make('Config')
                        ->schema([
                            Toggle::make('is_superadmin')
                                ->label('superadmin')->columnSpan(2),
                            Toggle::make('is_admin')
                                ->label('admin'),
                            Toggle::make('is_active')
                                ->label('active'),
                            Select::make('bidang_id')
                                ->options(bidang::query()->pluck('bidang_name', 'id'))
                                ->live()->searchable()->columnSpan(2),
                            Select::make('seksi_id')
                                ->options(fn (Get $get): Collection => seksi::query()
                                    ->where('bidang_id', $get('bidang_id'))
                                    ->pluck('seksi_name', 'id'))->searchable()->columnSpan(2),
                        ])->columnSpan(1),

                ])->columns(3),

                Section::make('User New Password')->schema([
                    TextInput::make('new_password')
                        ->nullable()
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->visible(fn ($livewire) => $livewire instanceof EditUser)
                        ->rule(Password::default()),
                    TextInput::make('new_password_confirmation')
                        ->label('Confirm Password')
                        ->password()
                        ->same('new_password')
                        ->requiredWith('new_password'),
                ])
                    ->columns(2)
                    ->visible(fn ($livewire) => $livewire instanceof EditUser),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable(),
                TextColumn::make('bidang.bidang_name')->sortable(),
                TextColumn::make('seksi.seksi_name')->sortable(),
                TextColumn::make('created_at')->sortable(),
                ToggleColumn::make('is_admin')
                    ->label('admin'),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
