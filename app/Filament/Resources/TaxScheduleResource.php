<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxScheduleResource\Pages;
use App\Models\TaxSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaxScheduleResource extends Resource
{
    protected static ?string $model = TaxSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Jadwal Pajak';

    protected static ?string $navigationGroup = 'Pemberdayaan & UMKM';

    protected static ?string $modelLabel = 'Jadwal Pajak';

    protected static ?string $pluralModelLabel = 'Jadwal Pajak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul_kegiatan')->required(),
                Forms\Components\DatePicker::make('tanggal')->required(),
                Forms\Components\Textarea::make('keterangan')->columnSpanFull(),
                Forms\Components\Toggle::make('is_routine_monthly')->label('Rutinitas bulanan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_kegiatan')->searchable(),
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable(),
                Tables\Columns\IconColumn::make('is_routine_monthly')->boolean()->label('Bulanan'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_routine_monthly')->label('Rutinitas bulanan'),
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
            'index' => Pages\ListTaxSchedules::route('/'),
            'create' => Pages\CreateTaxSchedule::route('/create'),
            'edit' => Pages\EditTaxSchedule::route('/{record}/edit'),
        ];
    }
}
