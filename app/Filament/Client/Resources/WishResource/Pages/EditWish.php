<?php

namespace App\Filament\Client\Resources\WishResource\Pages;

use App\Filament\Client\Resources\WishResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWish extends EditRecord
{
    protected static string $resource = WishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
