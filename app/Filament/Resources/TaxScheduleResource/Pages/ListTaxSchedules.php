<?php

namespace App\Filament\Resources\TaxScheduleResource\Pages;

use App\Filament\Resources\TaxScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxSchedules extends ListRecords
{
    protected static string $resource = TaxScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
