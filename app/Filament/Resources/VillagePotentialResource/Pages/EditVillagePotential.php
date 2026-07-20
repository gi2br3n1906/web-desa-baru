<?php

namespace App\Filament\Resources\VillagePotentialResource\Pages;

use App\Filament\Resources\VillagePotentialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVillagePotential extends EditRecord
{
    protected static string $resource = VillagePotentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
