<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Berita Desa';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita Desa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Set $set, ?string $state, ?string $old): void {
                        if (blank($old)) {
                            $set('slug', Str::slug($state ?? ''));
                        }
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'KKN' => 'KKN',
                        'Karang Taruna' => 'Karang Taruna',
                        'Pemerintah Desa' => 'Pemerintah Desa',
                    ])
                    ->searchable()
                    ->required(),
                Forms\Components\FileUpload::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->directory('uploads/news')
                    ->visibility('public')
                    ->image()
                    ->imageEditor()
                    ->nullable(),
                Forms\Components\Textarea::make('excerpt')
                    ->label('Ringkasan')
                    ->helperText('Ditampilkan pada kartu berita. Kosongkan jika ingin dibuat dari konten.')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label('Konten')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('uploads/news/attachments')
                    ->required()
                    ->extraInputAttributes(['style' => 'min-height: 500px'])
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_published')
                    ->label('Terbitkan Langsung')
                    ->default(true),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Waktu Terbit')
                    ->default(now())
                    ->required(),
                Forms\Components\TextInput::make('author_name')
                    ->label('Nama Penulis')
                    ->default('Admin Desa')
                    ->required()
                    ->maxLength(255),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(55),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Terbit')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Waktu Terbit')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Penulis')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'KKN' => 'KKN',
                        'Karang Taruna' => 'Karang Taruna',
                        'Pemerintah Desa' => 'Pemerintah Desa',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')->label('Status publikasi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}