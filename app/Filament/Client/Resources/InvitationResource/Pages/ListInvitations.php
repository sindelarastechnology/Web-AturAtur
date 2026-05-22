<?php

namespace App\Filament\Client\Resources\InvitationResource\Pages;

use App\Filament\Client\Resources\InvitationResource;
use App\Models\Invitation;
use Filament\Resources\Pages\ListRecords;

class ListInvitations extends ListRecords
{
    protected static string $resource = InvitationResource::class;

    public function mount(): void
    {
        parent::mount();

        $invitation = Invitation::where('user_id', auth()->id())->first();

        if ($invitation) {
            $this->redirect(InvitationResource::getUrl('edit', ['record' => $invitation]));
        }
    }
}
