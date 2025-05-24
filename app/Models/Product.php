<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'stock', 'price', 'image'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
