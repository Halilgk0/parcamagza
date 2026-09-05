<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->where('is_active', true);
            }])
            ->get();
            
        return view('categories.index', compact('categories'));
    }
    
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        $parts = $category->parts()
            ->where('is_active', true)
            ->with(['category', 'compatibleModels'])
            ->paginate(12);
            
        return view('categories.show', compact('category', 'parts'));
    }
}
