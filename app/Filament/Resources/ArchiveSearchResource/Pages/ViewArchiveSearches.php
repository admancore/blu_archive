<?php

namespace App\Filament\Resources\ArchiveSearchResource\Pages;

use App\Filament\Resources\ArchiveSearchResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewArchiveSearches extends ViewRecord
{
    protected static string $resource = ArchiveSearchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
