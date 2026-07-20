<?php

namespace App\Filament\Resources\AccountingTemplateResource\Pages;

use App\Filament\Resources\AccountingTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountingTemplates extends ListRecords
{
    protected static string $resource = AccountingTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
