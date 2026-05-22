<?php

namespace App\Filament\Client\Resources\InvitationResource\Pages;

use App\Filament\Client\Resources\InvitationResource;
use App\Models\Invitation;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvitation extends EditRecord
{
    protected static string $resource = InvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Lihat Undangan')
                ->icon('heroicon-o-eye')
                ->url(fn(Invitation $record) => "/{$record->slug}")
                ->openUrlInNewTab()
                ->color('success'),
        ];
    }
}
