<?php

namespace App\Filament\Resources\AgricultureGuideResource\Pages;

use App\Filament\Resources\AgricultureGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAgricultureGuide extends EditRecord
{
    protected static string $resource = AgricultureGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
