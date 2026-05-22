<?php

namespace App\Filament\Client\Resources\GuestResource\Pages;

use App\Filament\Client\Resources\GuestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuest extends EditRecord
{
    protected static string $resource = GuestResource::class;

    protected function afterSave(): void
    {
        $record = $this->record;
        $data = $this->form->getState();

        $giftData = $data['gift'] ?? [];
        if (!empty($giftData['type'])) {
            $record->gift()->updateOrCreate(
                ['guest_id' => $record->id],
                [
                    'invitation_id' => $record->invitation_id,
                    'type' => $giftData['type'],
                    'amount' => $giftData['amount'] ?? null,
                    'description' => $giftData['description'] ?? null,
                ]
            );
        } else {
            $record->gift()->delete();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
