<?php

namespace App\Filament\Client\Resources\EventResource\Pages;

use App\Filament\Client\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;
}
