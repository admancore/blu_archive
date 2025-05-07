<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\seksi;
use App\Models\bidang;
use App\Models\archive;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\kategoris;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Session;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ArchiveSearchResource\Pages;
use App\Filament\Resources\ArchiveSearchResource\RelationManagers;

class ArchiveSearchResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';
    protected static ?string $navigationLabel = 'Archive Search';
    protected static ?string $recordTitleAttribute = 'Archive Search';
    protected static ?string $pluralModelLabel  = 'Archive Search';

    protected static ?string $model = archive::class;


    public static function getEloquentQuery(): Builder
    {
            return parent::getEloquentQuery();
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
                FileUpload::make('cover_arsip')->directory('cover_arsip')->label('cover')->imageEditor(),
            ])
            ->columns(1),
                FileUpload::make('arsip_file')
                ->columns(1)
                ->multiple()
                ->openable()
                ->previewable(false)
                ->directory('arsip_file')
                ->visibility('public')
                ->storeFileNamesIn('original_filename')
                ->label('Arsip')
                ->downloadable(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_arsip')->label('Nama Arsip')->searchable(),
                TextColumn::make('kategori.kategori_name')->label('Kategori')->searchable(),
                TextColumn::make('bidang.bidang_name')->label('Bidang')->searchable(),
                TextColumn::make('seksi.seksi_name')->label('Seksi')->searchable(),
                TextColumn::make('tanggal_arsip')->label('Tanggal Arsip')->searchable(),
            ])
            ->filters([
                SelectFilter::make('bidang')
                    ->relationship('bidang', 'bidang_name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('seksi')
                    ->relationship('seksi', 'seksi_name')
                    // ->relationship('seksi', 'seksi_name', fn (Builder $query) => $query->withTrashed())
                    ->searchable()
                    ->preload(),
                SelectFilter::make('kategori')
                    ->relationship('kategori', 'kategori_name')
                    ->multiple()
                    ->searchable()
                    ->preload(),  
            ], layout: FiltersLayout::Modal)
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListArchiveSearches::route('/'),
            // 'view' => Pages\ViewArchiveSearches::route('/{record}'),
            // 'create' => Pages\CreateArchiveSearch::route('/create'),
            // 'edit' => Pages\EditArchiveSearch::route('/{record}/edit'),
        ];
    }
}
