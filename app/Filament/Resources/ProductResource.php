<?php

// app/Filament/Resources/ProductResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;   
use Filament\Tables\Table; 
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nama Produk')->required(),
                TextInput::make('stock')->label('Stok')->numeric()->required(),
                TextInput::make('price')->label('Harga Satuan')->numeric()->required(),

                FileUpload::make('image')
                    ->label('Gambar Produk')
                    ->image()
                    ->directory('products') // disimpan di storage/app/public/products
                    ->visibility('public')
                    ->imagePreviewHeight('200'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               ImageColumn::make('image')
                ->label('Gambar')
                ->getStateUsing(fn ($record) => asset('storage/' . $record->image))
                ->square()
                ->size(60)
                ->extraAttributes(['class' => 'pl-6']),
                TextColumn::make('name')->label('Nama'),
                TextColumn::make('stock')->label('Stok'),
                TextColumn::make('price')->label('Harga')->money('IDR', locale: 'id_ID'),

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
