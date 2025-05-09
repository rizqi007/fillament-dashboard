<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Produk'; // Nama di sidebar
    protected static ?string $modelLabel = 'Produk'; // Ubah judul utama
    protected static ?string $pluralModelLabel = 'Produk'; // Ubah di daftar

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('stock')->numeric()->required(),
                TextInput::make('price')->numeric()->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
        ->actions([
            EditAction::make()
                ->color('primary') // Warna biru
                ->outlined(), // Tambahkan border agar lebih terlihat
        ])
            ->columns([
                TextColumn::make('id')->sortable()->label('No'),
                TextColumn::make('name')->sortable()->searchable()->label('Nama'),
                TextColumn::make('stock')->sortable()->label('Stok'),
                TextColumn::make('price')->money('IDR')->sortable()->label('Harga Satuan'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
