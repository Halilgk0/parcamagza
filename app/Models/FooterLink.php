<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'position',
        'column',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
