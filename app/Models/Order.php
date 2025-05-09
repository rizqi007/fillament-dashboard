<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'total_price', 'status'];

    protected static function boot()
{
    parent::boot();
    
    static::saving(function ($order) {
        $order->total_price = $order->items->sum('price');
    });
}


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->items->sum(fn ($item) => $item->quantity * $item->price);
    }
}

