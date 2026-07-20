<?php

namespace App\Filament\Resources\VillageProfileResource\Pages;

use App\Filament\Resources\VillageProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVillageProfile extends EditRecord
{
    protected static string $resource = VillageProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
