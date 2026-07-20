<?php

namespace App\Filament\Resources\AgricultureGuideResource\Pages;

use App\Filament\Resources\AgricultureGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAgricultureGuides extends ListRecords
{
    protected static string $resource = AgricultureGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
