<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroBannerResource\Pages;
use App\Models\HeroBanner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroBannerResource extends Resource
{
    protected static ?string $model = HeroBanner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Carousel Beranda';

    protected static ?string $navigationGroup = 'Pemerintahan & Profil';

    protected static ?string $modelLabel = 'Banner Beranda';

    protected static ?string $pluralModelLabel = 'Carousel Beranda';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_path')
                    ->label('Gambar Banner')
                    ->disk('public')
                    ->directory('carousel-banners')
                    ->visibility('public')
                    ->image()
                    ->imageEditor()
                    ->maxSize(5120)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->maxLength(255),
                Forms\Components\Textarea::make('subtitle')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('button_text')
                    ->label('Teks Tombol')
                    ->default('Jelajahi Layanan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('button_url')
                    ->label('URL Tombol')
                    ->default('/layanan')
                    ->maxLength(255)
                    ->helperText('Gunakan path internal seperti /layanan atau URL lengkap.'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Banner')
                    ->disk('public')
                    ->height(64),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(60),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroBanners::route('/'),
            'create' => Pages\CreateHeroBanner::route('/create'),
            'edit' => Pages\EditHeroBanner::route('/{record}/edit'),
        ];
    }
}