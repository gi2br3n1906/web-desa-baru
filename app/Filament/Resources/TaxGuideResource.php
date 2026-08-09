<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxGuideResource\Pages;
use App\Models\TaxGuide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaxGuideResource extends Resource
{
    protected static ?string $model = TaxGuide::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Panduan Pajak';

    protected static ?string $navigationGroup = 'Pemberdayaan & UMKM';

    protected static ?string $modelLabel = 'Panduan Pajak';

    protected static ?string $pluralModelLabel = 'Panduan Pajak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kategori_umkm')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('alur_pajak')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('tarif_informasi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategori_umkm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tarif_informasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxGuides::route('/'),
            'create' => Pages\CreateTaxGuide::route('/create'),
            'edit' => Pages\EditTaxGuide::route('/{record}/edit'),
        ];
    }
}
