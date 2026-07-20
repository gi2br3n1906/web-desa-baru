<?php

namespace App\Filament\Resources\VillagePotentialResource\Pages;

use App\Filament\Resources\VillagePotentialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVillagePotentials extends ListRecords
{
    protected static string $resource = VillagePotentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
