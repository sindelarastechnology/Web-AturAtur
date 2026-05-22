<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use App\Models\Invitation;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;

        if ($record->role !== 'client' || !$record->theme_id) {
            return;
        }

        $baseSlug = Str::slug($record->name);
        $slug = $baseSlug;
        $counter = 1;
        while (Invitation::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        Invitation::create([
            'user_id' => $record->id,
            'theme_id' => $record->theme_id,
            'slug' => $slug,
            'title' => 'Undangan Pernikahan ' . $record->name,
            'is_active' => false,
        ]);
    }
}
