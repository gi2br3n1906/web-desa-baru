<?php

namespace App\Filament\Resources\VillageProfileResource\Pages;

use App\Filament\Resources\VillageProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVillageProfiles extends ListRecords
{
    protected static string $resource = VillageProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
