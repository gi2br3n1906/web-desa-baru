<?php

namespace App\Filament\Resources\VillageLegalProductResource\Pages;

use App\Filament\Resources\VillageLegalProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVillageLegalProducts extends ListRecords
{
    protected static string $resource = VillageLegalProductResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}