<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = CarBrand::where('is_active', true)
            ->orderBy('name')
            ->paginate(24);
            
        return view('brands.index', compact('brands'));
    }
    
    public function show($slug)
    {
        $brand = CarBrand::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        $models = $brand->models()
            ->where('is_active', true)
            ->orderBy('name')
            ->paginate(12);
            
        return view('brands.show', compact('brand', 'models'));
    }
}
