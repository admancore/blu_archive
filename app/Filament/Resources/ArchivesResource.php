<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\seksi;
use App\Models\bidang;
use App\Models\archive;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Session;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ArchivesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ArchivesResource\RelationManagers;
use App\Models\kategoris;

class ArchivesResource extends Resource
{
    protected static ?string $model = archive::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'My Archive';
    protected static ?string $recordTitleAttribute = 'My Archive';
    protected static ?string $pluralModelLabel  = 'My Archive';

    public static function getEloquentQuery(): Builder
    {
        if (auth()->check() && auth()->user()->is_superadmin == 1) {
            return parent::getEloquentQuery();
        }else if(auth()->check() && auth()->user()->seksi_id == null){
            return parent::getEloquentQuery()
            ->where('bidang_id',auth()->user()->bidang_id);
        }
        else{
            return parent::getEloquentQuery()
            ->where('bidang_id',auth()->user()->bidang_id)
            ->where('seksi_id',auth()->user()->seksi_id);
        }
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make([
                // TextInput::make('user_id')
                //     ->default(fn() => Auth::id())
                //     ->hidden()
                //     ->required(),
                Select::make('bidang_id')
                    ->label('Bidang')
                    ->options(function () {
                        if (auth()->check() && auth()->user()->is_superadmin == 1) {
                            return bidang::query()->pluck('bidang_name', 'id');
                        }

                        // Save bidang_id and seksi_id in session
                        $user = auth()->user();
                        Session::put('bidang_id', $user->bidang_id);
                        Session::put('seksi_id', $user->seksi_id);

                        // Return options for non-superadmin users
                        return bidang::where('id', $user->bidang_id)->pluck('bidang_name', 'id');
                    })
                    ->searchable(),
                Select::make('seksi_id')
                    ->label('Seksi')
                    ->options(function (Get $get){
                        $user = auth()->user();
                        Session::put('bidang_id', $user->bidang_id);
                        Session::put('seksi_id', $user->seksi_id);

                        if (auth()->check() && auth()->user()->is_superadmin == 1 || $user->seksi_id=='') {
                            return seksi::where('bidang_id', $get('bidang_id'))->pluck('seksi_name', 'id');
                        }
                        // Return options for non-superadmin users
                        return seksi::where('id', $user->seksi_id)->pluck('seksi_name', 'id');
                    })
                    ->searchable(),
                Select::make('kategori_id')
                    ->label('Kategori')
                    ->options(function () {
                            return kategoris::query()->pluck('kategori_name', 'id');
                    })
                    ->required()
                    ->searchable(),
                DatePicker::make('tanggal_arsip')
                    ->label('Tanggal Arsip')
                    ->required(),
                TextInput::make('nomor_arsip')
                    ->label('Nomor')
                    ->required()->columnSpan(2),        
                TextInput::make('nama_arsip')
                    ->label('Nama Arsip')
                    ->required()->columnSpan(2),
            ])
            ->columns(2),
            Card::make([
                MarkdownEditor::make('keterangan_arsip')->label('Deskripsi'),
            ])
            ->columns(1),
            Card::make([
                FileUpload::make('cover_arsip')->directory('cover_arsip')->label('cover')->imageEditor()->image(),
                FileUpload::make('arsip_file')
                        ->columns(1)
                        ->multiple()
                        ->reorderable()
                        ->downloadable()
                        ->openable()
                        ->directory('arsip_file')
                        ->visibility('public')
                        ->storeFileNamesIn('original_filename')->label('Arsip')
                        ->appendFiles()
                        ->imageEditor()->imageEditor()->panelLayout('grid')->columnSpan(2),
            ])
            ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_arsip')->label('Nomor')->searchable(),
                TextColumn::make('nama_arsip')->label('Nama Arsip')->searchable(),
                TextColumn::make('kategori.kategori_name')->label('Kategori')->searchable(),
                TextColumn::make('bidang.bidang_name')->label('Bidang')->searchable(),
                TextColumn::make('seksi.seksi_name')->label('Seksi')->searchable(),
                TextColumn::make('tanggal_arsip')->label('Tanggal Arsip')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListArchives::route('/'),
            'create' => Pages\CreateArchives::route('/create'),
            'edit' => Pages\EditArchives::route('/{record}/edit'),
        ];
    }
}
