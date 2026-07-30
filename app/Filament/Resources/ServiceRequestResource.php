<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceRequestResource\Pages;
use App\Models\ServiceRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceRequestResource extends Resource
{
    protected static ?string $model = ServiceRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationLabel = 'Pengajuan Layanan';

    public static function getNavigationBadge(): ?string
    {
        return (string) ServiceRequest::query()->where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('admin_service_id')->relationship('adminService', 'nama_layanan')->required(),
                Forms\Components\TextInput::make('nama_lengkap')->required()->maxLength(255),
                Forms\Components\TextInput::make('nik')->required()->length(16),
                Forms\Components\Textarea::make('alamat')->required()->columnSpanFull(),
                Forms\Components\TextInput::make('no_whatsapp')->required()->tel(),
                Forms\Components\FileUpload::make('file_lampiran')->directory('service-requests')->downloadable(),
                Forms\Components\Select::make('status')->options(['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai'])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('adminService.nama_layanan')->label('Layanan')->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')->searchable(),
                Tables\Columns\TextColumn::make('nik')->searchable(),
                Tables\Columns\TextColumn::make('no_whatsapp'),
                Tables\Columns\SelectColumn::make('status')->options(['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai']),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai']),
            ])->poll('10s')
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
            'index' => Pages\ListServiceRequests::route('/'),
            'create' => Pages\CreateServiceRequest::route('/create'),
            'edit' => Pages\EditServiceRequest::route('/{record}/edit'),
        ];
    }
}
