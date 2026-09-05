<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'part_number',
        'description',
        'price',
        'stock_quantity',
        'condition',
        'specifications',
        'compatibility',
        'manufacturer',
        'is_active',
        'image'
    ];

    protected $casts = [
        'specifications' => 'array',
        'compatibility' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }

    public function compatibleModels()
    {
        return $this->belongsToMany(CarModel::class, 'part_car_model');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($part) {
            if (!$part->slug) {
                $part->slug = Str::slug($part->name);
            }
        });
        
        static::updating(function ($part) {
            // If stock is being updated to zero from a non-zero value
            if ($part->isDirty('stock_quantity') && $part->stock_quantity == 0 && $part->getOriginal('stock_quantity') > 0) {
                // Schedule stock depleted notification
                \App\Services\StockNotificationService::sendStockDepletedNotification($part);
            }
            // Or if stock is low (below threshold)
            elseif ($part->isDirty('stock_quantity') && $part->stock_quantity > 0 && $part->stock_quantity <= 5 
                    && $part->getOriginal('stock_quantity') > $part->stock_quantity) {
                // Schedule low stock notification
                \App\Services\StockNotificationService::sendLowStockNotification($part);
            }
        });
    }
}
