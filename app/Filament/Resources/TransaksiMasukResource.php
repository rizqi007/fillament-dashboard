<?php

namespace App\Filament\Resources;

use App\Models\TransaksiMasuk;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;   
use Filament\Tables\Table; 
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use App\Filament\Resources\TransaksiMasukResource\Pages;


class TransaksiMasukResource extends Resource
{
    protected static ?string $model = TransaksiMasuk::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $navigationLabel = 'Transaksi Masuk';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $slug = 'transaksi-masuk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_barang')->required(),
            TextInput::make('jumlah')->numeric()->required(),
            DatePicker::make('tanggal')->required(),
            TextInput::make('Atas_Nama')->nullable()
            ->label('Atas Nama'),
            FileUpload::make('bukti_pembayaran')
                ->label('Bukti Pembayaran')
                ->directory('bukti-pembayaran')
                ->image() // hanya menerima gambar
                ->maxSize(2048) // 2MB
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('bukti_pembayaran')->label('Bukti')->size(60)->circular(),
            TextColumn::make('nama_barang')->sortable()->searchable(),
            TextColumn::make('jumlah'),
            TextColumn::make('tanggal')->date(),
            TextColumn::make('Atas_Nama'),
            
        ])
          ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ])
        ->bulkActions([
            DeleteBulkAction::make(), // <-- ini yang benar untuk bulk delete
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksiMasuks::route('/'),
            'create' => Pages\CreateTransaksiMasuk::route('/create'),
            'edit' => Pages\EditTransaksiMasuk::route('/{record}/edit'),
        ];
    }
}
