<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VillagePotentialResource\Pages;
use App\Models\VillagePotential;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VillagePotentialResource extends Resource
{
    protected static ?string $model = VillagePotential::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Potensi Desa';

    protected static ?string $navigationGroup = 'Pemerintahan & Profil';

    protected static ?string $modelLabel = 'Potensi Desa';

    protected static ?string $pluralModelLabel = 'Potensi Desa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('title_id')
                            ->label('Judul (Indonesia)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title_jp')
                            ->label('Judul (Jepang)')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\RichEditor::make('content_id')
                            ->label('Konten (Indonesia)')
                            ->required(),
                        Forms\Components\RichEditor::make('content_jp')
                            ->label('Konten (Jepang)')
                            ->required(),
                    ])
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image_path')
                    ->label('Gambar potensi')
                    ->disk('public')
                    ->directory('uploads')
                    ->image()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_jp')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_path')
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
            'index' => Pages\ListVillagePotentials::route('/'),
            'create' => Pages\CreateVillagePotential::route('/create'),
            'edit' => Pages\EditVillagePotential::route('/{record}/edit'),
        ];
    }
}
