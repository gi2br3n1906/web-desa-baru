<?php

namespace App\Filament\Resources\PublicFacilityResource\Pages;

use App\Filament\Resources\PublicFacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublicFacility extends EditRecord
{
    protected static string $resource = PublicFacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
