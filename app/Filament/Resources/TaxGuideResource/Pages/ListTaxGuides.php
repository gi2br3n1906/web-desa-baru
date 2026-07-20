<?php

namespace App\Filament\Resources\TaxGuideResource\Pages;

use App\Filament\Resources\TaxGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxGuides extends ListRecords
{
    protected static string $resource = TaxGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
