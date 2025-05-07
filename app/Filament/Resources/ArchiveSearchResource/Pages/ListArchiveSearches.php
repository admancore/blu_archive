<?php

namespace App\Filament\Resources\ArchiveSearchResource\Pages;

use App\Filament\Resources\ArchiveSearchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArchiveSearches extends ListRecords
{
    protected static string $resource = ArchiveSearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
