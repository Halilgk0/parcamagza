<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\Category;
use App\Models\Part;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function __construct()
    {
        // Tüm markaları ve kategorileri header için paylaş
        $brands = CarBrand::where('is_active', true)
            ->with(['models' => function($query) {
                $query->where('is_active', true);
            }])
            ->get();
            
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->get();
            
        View::share('brands', $brands);
        View::share('categories', $categories);
    }

    public function index()
    {
        $featuredParts = Part::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();
            
        $brands = CarBrand::where('is_active', true)
            ->take(12)
            ->get();
            
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->where('is_active', true);
            }])
            ->get();
            
        // Get banners for the home page
        $homeBanners = Banner::where('is_active', true)
            ->where('section', 'home_banner')
            ->orderBy('order')
            ->get();
            
        return view('home', compact('featuredParts', 'brands', 'categories', 'homeBanners'));
    }
}
