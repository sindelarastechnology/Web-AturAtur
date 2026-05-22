<?php

namespace App\Filament\Client\Resources\GuestResource\Pages;

use App\Filament\Client\Resources\GuestResource;
use App\Models\Gift;
use Filament\Resources\Pages\CreateRecord;

class CreateGuest extends CreateRecord
{
    protected static string $resource = GuestResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;
        $data = $this->form->getState();

        $giftData = $data['gift'] ?? [];
        if (!empty($giftData['type'])) {
            $record->gift()->create([
                'invitation_id' => $record->invitation_id,
                'type' => $giftData['type'],
                'amount' => $giftData['amount'] ?? null,
                'description' => $giftData['description'] ?? null,
            ]);
        }
    }
}
