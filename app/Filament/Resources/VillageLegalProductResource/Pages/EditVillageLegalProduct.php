<?php

namespace App\Filament\Resources\VillageLegalProductResource\Pages;

use App\Filament\Resources\VillageLegalProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVillageLegalProduct extends EditRecord
{
    protected static string $resource = VillageLegalProductResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}