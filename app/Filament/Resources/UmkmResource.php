<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmkmResource\Pages;
use App\Models\Umkm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UmkmResource extends Resource
{
    protected static ?string $model = Umkm::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Direktori UMKM';

    protected static ?string $navigationGroup = 'Pemberdayaan & UMKM';

    protected static ?string $modelLabel = 'UMKM';

    protected static ?string $pluralModelLabel = 'Direktori UMKM';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_umkm')->label('Nama Usaha')->required(),
                Forms\Components\TextInput::make('pemilik')->label('Nama Pemilik')->required(),
                Forms\Components\TextInput::make('kategori')->label('Jenis Usaha')->required()->datalist(['Kuliner', 'Kerajinan', 'Pertanian', 'Jasa', 'Perdagangan']),
                Forms\Components\TextInput::make('dusun')->label('Dukuh')->required(),
                Forms\Components\TextInput::make('rt_rw')->label('RT/RW')->required(),
                Forms\Components\Textarea::make('alamat_lengkap')->label('Alamat Lengkap')->required()->columnSpanFull(),
                Forms\Components\Select::make('bentuk_usaha')->label('Bentuk Usaha')->options([
                    'Perorangan' => 'Perorangan',
                    'UD' => 'UD',
                    'CV' => 'CV',
                    'Koperasi' => 'Koperasi',
                    'PT' => 'PT',
                    'Kelompok' => 'Kelompok',
                ])->required(),
                Forms\Components\TextInput::make('no_hp')->label('No. HP')->tel(),
                Forms\Components\Textarea::make('deskripsi')->required()->columnSpanFull(),
                Forms\Components\TextInput::make('latitude')->numeric(),
                Forms\Components\TextInput::make('longitude')->numeric(),
                Forms\Components\FileUpload::make('foto')->image()->directory('umkm')->imageEditor()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto'),
                Tables\Columns\TextColumn::make('nama_umkm')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('pemilik')->searchable(),
                Tables\Columns\TextColumn::make('kategori')->badge(),
                Tables\Columns\TextColumn::make('dusun')->sortable(),
                Tables\Columns\TextColumn::make('rt_rw'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')->options(fn () => Umkm::query()->distinct()->pluck('kategori', 'kategori')->all()),
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
            'index' => Pages\ListUmkms::route('/'),
            'create' => Pages\CreateUmkm::route('/create'),
            'edit' => Pages\EditUmkm::route('/{record}/edit'),
        ];
    }
}
