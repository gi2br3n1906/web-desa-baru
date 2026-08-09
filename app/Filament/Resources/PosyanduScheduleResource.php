<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PosyanduScheduleResource\Pages;
use App\Models\PosyanduSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PosyanduScheduleResource extends Resource
{
    protected static ?string $model = PosyanduSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationLabel = 'Kesehatan & Posyandu';

    protected static ?string $navigationGroup = 'Fasilitas & Kesehatan';

    protected static ?string $modelLabel = 'Jadwal Posyandu';

    protected static ?string $pluralModelLabel = 'Kesehatan & Posyandu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_posyandu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_pelaksanaan')
                    ->required(),
                Forms\Components\TimePicker::make('jam_mulai')
                    ->seconds(false)
                    ->required(),
                Forms\Components\TimePicker::make('jam_selesai')
                    ->seconds(false)
                    ->after('jam_mulai')
                    ->required(),
                Forms\Components\RichEditor::make('informasi_phbs')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('kontak_bidan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_posyandu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_pelaksanaan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jam_mulai'),
                Tables\Columns\TextColumn::make('jam_selesai'),
                Tables\Columns\TextColumn::make('kontak_bidan')
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
            'index' => Pages\ListPosyanduSchedules::route('/'),
            'create' => Pages\CreatePosyanduSchedule::route('/create'),
            'edit' => Pages\EditPosyanduSchedule::route('/{record}/edit'),
        ];
    }
}
