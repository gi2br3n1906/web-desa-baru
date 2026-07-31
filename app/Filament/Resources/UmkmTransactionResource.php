<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmkmTransactionResource\Pages;
use App\Models\UmkmTransaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UmkmTransactionResource extends Resource
{
    protected static ?string $model = UmkmTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Buku Transaksi UMKM';

    protected static ?string $navigationGroup = 'Pemberdayaan UMKM';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Pemilik akun')
                    ->options(fn () => User::query()->where('role', 'umkm')->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('book_type')
                    ->label('Buku')
                    ->options(['jual' => 'Penjualan', 'kaso' => 'Kas', 'hp' => 'Utang/Piutang'])
                    ->required(),
                Forms\Components\DatePicker::make('date')->label('Tanggal')->required(),
                Forms\Components\TextInput::make('title_or_product')->label('Keterangan / produk')->required()->maxLength(255),
                Forms\Components\TextInput::make('category')->label('Kategori')->maxLength(255),
                Forms\Components\Select::make('transaction_type')
                    ->label('Jenis transaksi')
                    ->options(['masuk' => 'Masuk', 'keluar' => 'Keluar', 'piutang' => 'Piutang', 'hutang' => 'Hutang']),
                Forms\Components\TextInput::make('qty')->label('Jumlah')->numeric()->minValue(0),
                Forms\Components\TextInput::make('price_per_unit')->label('Harga satuan')->numeric()->minValue(0),
                Forms\Components\TextInput::make('amount')->label('Nominal')->numeric()->minValue(0)->required(),
                Forms\Components\Select::make('status')->options(['lunas' => 'Lunas', 'belum' => 'Belum']),
                Forms\Components\Textarea::make('notes')->label('Catatan')->columnSpanFull(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Pemilik')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('book_type')->label('Buku')->badge()->formatStateUsing(fn (string $state): string => match ($state) {
                    'jual' => 'Penjualan',
                    'kaso' => 'Kas',
                    'hp' => 'Utang/Piutang',
                    default => $state,
                }),
                Tables\Columns\TextColumn::make('date')->label('Tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('title_or_product')->label('Keterangan')->searchable(),
                Tables\Columns\TextColumn::make('transaction_type')->label('Jenis')->badge(),
                Tables\Columns\TextColumn::make('amount')->label('Nominal')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('book_type')->label('Buku')->options(['jual' => 'Penjualan', 'kaso' => 'Kas', 'hp' => 'Utang/Piutang']),
                Tables\Filters\SelectFilter::make('status')->options(['lunas' => 'Lunas', 'belum' => 'Belum']),
            ])
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUmkmTransactions::route('/'),
            'edit' => Pages\EditUmkmTransaction::route('/{record}/edit'),
        ];
    }
}
