<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\BulkAction;
use App\Exports\CompletedOrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\Action;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Order'; // Nama di sidebar
    protected static ?string $modelLabel = 'Order'; // Ubah judul utama
    protected static ?string $pluralModelLabel = 'Order'; // Ubah di daftar
    protected static ?int $navigationSort = 2;



    protected static function updateTotalPrice(callable $set, callable $get)
{
    $total = collect($get('items'))->sum(fn ($item) => $item['price'] ?? 0);
    $set('total_price', $total);
}


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('customer_name')->required(),
                Repeater::make('items')
                ->relationship('items')
                ->schema([
                    Select::make('product_id')
                        ->label('Produk')
                        ->options(
                            fn () => \App\Models\Product::pluck('name', 'id')->toArray()
                        ) // Ambil produk langsung dari database
                        ->required()
                        ->preload()
                        ->searchable()
                        ->afterStateUpdated(fn ($state, callable $set, $get) => 
                            dump('Produk Terpilih:', \App\Models\Product::find($state))
                        ),
            
                    TextInput::make('quantity')
                        ->numeric()
                        ->minValue(1)
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            $product = \App\Models\Product::find($get('product_id'));
                            // dump('Produk:', $product, 'Jumlah:', $state); // Debug ulang
                            $set('price', $product ? $product->price * $state : 0);
                        }),
                        
            
                    TextInput::make('price')
                        ->label('Harga Total')
                        ->numeric()
                        ->readOnly()
                        ->required(),
                        
                ])
                ->columns(3)
                ->createItemButtonLabel('Tambah Produk'),

                Select::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Pending',
                        'sedang dikirim' => 'Sedang Dikirim',
                        'sudah terkirim' => 'Sudah Terkirim',
                        'cancel' => 'Cancel',
                    ])
                    ->default('pending')
                    ->required(),


                TextInput::make('total_price')
                ->label('Total Harga Items')
                ->numeric()
                ->readOnly()
                ->required()
                ->afterStateHydrated(fn ($state, callable $set, $get) => self::updateTotalPrice($set, $get)),

                
                    ]);

    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table


                ->columns([
                    TextColumn::make('id')->sortable()->label('No'),

                    TextColumn::make('customer_name')->sortable()->searchable()->label('Nama Costumer'),

                    // TextColumn::make('quantity')->sortable()->searchable()->label('Quantity'),

                    // TextColumn::make('product_name') // Menampilkan nama produk
                    //     ->sortable()
                    //     ->searchable()
                    //     ->label('Nama Produk')
                    //     ->formatStateUsing(fn ($state) => $state ?: 'Tidak Ada Produk'),

                    TextColumn::make('total_price')
                        ->label('Total Harga')
                        ->sortable()
                        ->money('IDR'),

                    TextColumn::make('status')
                        ->label('Status')
                        ->sortable()
                        ->badge()
                        ->formatStateUsing(fn ($state) => strtoupper($state)) // Debug: Ubah teks jadi huruf besar
                        ->color(fn ($state) => match ($state) {
                            'pending' => 'gray',
                            'sedang dikirim' => 'info',
                            'sudah terkirim' => 'success',
                            'cancel' => 'danger',
                            
                        }),
                    
                    ])
                    ->headerActions([
                        Action::make('export-pdf')
                            ->label('Download PDF')
                            ->color('danger') // Bisa diganti dengan warna custom
                            ->extraAttributes(['class' => 'bg-green-500 hover:bg-green-700 text-white'])
                            ->url(fn () => route('orders.export-pdf'))
                            ->requiresConfirmation()
                            ->openUrlInNewTab(),
                    ]) //export pdf

                    ->actions([
                        EditAction::make()
                            ->color('primary') // Warna biru
                            ->outlined(), // Tambahkan border agar lebih terlihat
                    ]);

                    
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

