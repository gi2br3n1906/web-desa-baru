<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VillageLegalProductResource\Pages;
use App\Models\VillageLegalProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VillageLegalProductResource extends Resource
{
    protected static ?string $model = VillageLegalProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $navigationLabel = 'Produk Hukum & Dokumen';

    protected static ?string $navigationGroup = 'Pemerintahan & Profil';

    protected static ?string $modelLabel = 'Produk Hukum';

    protected static ?string $pluralModelLabel = 'Produk Hukum & Dokumen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul_peraturan')
                    ->label('Judul Peraturan')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_tahun')
                    ->label('Nomor & Tahun')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kategori')
                    ->label('Kategori')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('tentang')
                    ->label('Tentang')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Dokumen PDF')
                    ->disk('public')
                    ->directory('uploads/produk-hukum')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->downloadable()
                    ->openable()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_peraturan')
                    ->label('Judul Peraturan')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('nomor_tahun')
                    ->label('Nomor & Tahun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('Dokumen')
                    ->formatStateUsing(fn (): string => 'Buka PDF')
                    ->url(fn (VillageLegalProduct $record): string => asset('storage/'.$record->file_path))
                    ->openUrlInNewTab(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListVillageLegalProducts::route('/'),
            'create' => Pages\CreateVillageLegalProduct::route('/create'),
            'edit' => Pages\EditVillageLegalProduct::route('/{record}/edit'),
        ];
    }
}