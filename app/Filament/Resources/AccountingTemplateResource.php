<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountingTemplateResource\Pages;
use App\Models\AccountingTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AccountingTemplateResource extends Resource
{
    protected static ?string $model = AccountingTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationLabel = 'Template Pembukuan';

    protected static ?string $navigationGroup = 'Pemberdayaan & UMKM';

    protected static ?string $modelLabel = 'Template Pembukuan';

    protected static ?string $pluralModelLabel = 'Template Pembukuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_template')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('deskripsi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('file_path')
                    ->label('File template')
                    ->disk('public')
                    ->directory('uploads')
                    ->acceptedFileTypes([
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                    ->required()
                    ->downloadable()
                    ->openable()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_template')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('File template')
                    ->formatStateUsing(fn (): string => 'Unduh file')
                    ->url(fn (AccountingTemplate $record): string => asset('storage/'.$record->file_path))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListAccountingTemplates::route('/'),
            'create' => Pages\CreateAccountingTemplate::route('/create'),
            'edit' => Pages\EditAccountingTemplate::route('/{record}/edit'),
        ];
    }
}
