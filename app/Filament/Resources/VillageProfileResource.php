<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VillageProfileResource\Pages;
use App\Models\VillageProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VillageProfileResource extends Resource
{
    protected static ?string $model = VillageProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('visi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('misi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('struktur_organisasi_path')
                    ->label('Struktur organisasi')
                    ->disk('public')
                    ->directory('uploads')
                    ->image()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\KeyValue::make('kontak_desa')
                    ->label('Kontak desa')
                    ->keyLabel('Jenis kontak')
                    ->valueLabel('Informasi')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('struktur_organisasi_path')
                    ->label('Struktur organisasi')
                    ->disk('public'),
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
            'index' => Pages\ListVillageProfiles::route('/'),
            'create' => Pages\CreateVillageProfile::route('/create'),
            'edit' => Pages\EditVillageProfile::route('/{record}/edit'),
        ];
    }
}
