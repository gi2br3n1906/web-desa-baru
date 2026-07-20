<?php

namespace App\Filament\Resources\AdminServiceResource\Pages;

use App\Filament\Resources\AdminServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminService extends EditRecord
{
    protected static string $resource = AdminServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
