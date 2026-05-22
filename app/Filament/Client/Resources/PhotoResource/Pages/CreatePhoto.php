<?php

namespace App\Filament\Client\Resources\PhotoResource\Pages;

use App\Filament\Client\Resources\PhotoResource;
use App\Models\Invitation;
use App\Models\Photo;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePhoto extends CreateRecord
{
    protected static string $resource = PhotoResource::class;

    protected function beforeCreate(): void
    {
        $invitation = Invitation::find($this->data['invitation_id'] ?? null);
        if (!$invitation || !$invitation->user) {
            return;
        }

        $maxPhotos = $invitation->user->package?->max_photos ?? -1;
        if ($maxPhotos !== -1) {
            $currentCount = Photo::where('invitation_id', $invitation->id)->count();
            if ($currentCount >= $maxPhotos) {
                Notification::make()
                    ->title('Batas maksimal foto tercapai (' . $maxPhotos . ' foto)')
                    ->danger()
                    ->send();
                $this->halt();
            }
        }
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Foto berhasil ditambahkan';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Upload Foto'),
            $this->getCancelFormAction(),
        ];
    }
}
