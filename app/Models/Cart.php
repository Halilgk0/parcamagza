<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    /**
     * Sepetin kullanıcıya bağlantısı
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sepetteki öğeler
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Sepetteki toplam tutarı hesaplar
     */
    public function total()
    {
        return $this->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Sepetteki toplam ürün sayısı
     */
    public function itemCount()
    {
        return $this->items->sum('quantity');
    }
} 