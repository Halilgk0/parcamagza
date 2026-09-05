<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_brand_id',
        'name',
        'slug',
        'year_start',
        'year_end',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(CarBrand::class, 'car_brand_id');
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }
}
