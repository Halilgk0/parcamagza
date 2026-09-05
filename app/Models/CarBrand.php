<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CarBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'is_active',
        'parent_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(CarBrand::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(CarBrand::class, 'parent_id');
    }

    public function parts()
    {
        return $this->hasMany(Part::class, 'brand_id');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });
    }
}
