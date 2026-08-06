<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected ?string $maxContentWidth = MaxWidth::Full->value;
}