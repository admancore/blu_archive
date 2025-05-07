<?php

namespace App\Filament\Resources\BidangsResource\Pages;

use App\Filament\Resources\BidangsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBidangs extends EditRecord
{
    protected static string $resource = BidangsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
