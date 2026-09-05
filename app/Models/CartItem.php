<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'part_id',
        'quantity',
        'price',
    ];

    /**
     * Öğenin ait olduğu sepet
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Öğenin temsil ettiği parça
     */
    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    /**
     * Öğenin toplam fiyatı
     */
    public function subtotal()
    {
        return $this->price * $this->quantity;
    }
} 