<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'image_path',
        'title',
        'subtitle',
        'link',
        'order',
        'is_active',
        'section'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
    
    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }
    
    public static function getActiveBannersBySection($section = 'home_banner')
    {
        return self::where('is_active', true)
            ->where('section', $section)
            ->orderBy('order')
            ->get();
    }
}
