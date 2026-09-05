<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'part_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    /**
     * Öğenin ait olduğu sipariş
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
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