<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\CarModel;
use App\Models\Category;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index(Request $request)
    {
        $query = Part::where('is_active', true)
            ->with(['category', 'compatibleModels']);

        // Filter by model if specified
        if ($request->has('model')) {
            $model = CarModel::where('slug', $request->model)->firstOrFail();
            $query->whereHas('compatibleModels', function($q) use ($model) {
                $q->where('car_models.id', $model->id);
            });
        }

        // Apply sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
        }

        $parts = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('parts.index', compact('parts', 'categories'));
    }

    public function show($slug)
    {
        $part = Part::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'compatibleModels.brand'])
            ->firstOrFail();

        $relatedParts = Part::where('category_id', $part->category_id)
            ->where('id', '!=', $part->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('parts.show', compact('part', 'relatedParts'));
    }

    public function search(Request $request)
    {
        $query = Part::where('is_active', true)
            ->with(['category', 'compatibleModels']);

        if ($request->has('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('part_number', 'like', "%{$searchTerm}%");
            });
        }

        $parts = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('parts.index', [
            'parts' => $parts,
            'categories' => $categories,
            'searchTerm' => $request->q
        ]);
    }
}
