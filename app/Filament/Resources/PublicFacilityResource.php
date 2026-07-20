<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicFacilityResource\Pages;
use App\Models\PublicFacility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PublicFacilityResource extends Resource
{
    protected static ?string $model = PublicFacility::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_fasilitas')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('kategori')
                    ->options([
                        'kantor' => 'Kantor',
                        'sekolah' => 'Sekolah',
                        'ibadah' => 'Tempat ibadah',
                        'kesehatan' => 'Kesehatan',
                        'infrastruktur' => 'Infrastruktur',
                    ])
                    ->required()
                    ->native(false),
                Forms\Components\Textarea::make('google_maps_embed')
                    ->label('Google Maps embed')
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('keterangan')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_fasilitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
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
            'index' => Pages\ListPublicFacilities::route('/'),
            'create' => Pages\CreatePublicFacility::route('/create'),
            'edit' => Pages\EditPublicFacility::route('/{record}/edit'),
        ];
    }
}
