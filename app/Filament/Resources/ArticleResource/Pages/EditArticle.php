<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\MaxWidth;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected ?string $maxContentWidth = MaxWidth::Full->value;
}