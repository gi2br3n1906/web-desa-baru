<?php

namespace App\Filament\Resources\TaxGuideResource\Pages;

use App\Filament\Resources\TaxGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaxGuide extends EditRecord
{
    protected static string $resource = TaxGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
