<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $models = CarModel::with('brand')
            ->orderBy('id', 'desc')
            ->paginate(10);
            
        return view('admin.models.index', compact('models'));
    }

    public function create()
    {
        $brands = CarBrand::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('admin.models.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_brand_id' => 'required|exists:car_brands,id',
            'name' => 'required|string|max:255',
            'year_start' => 'nullable|string|max:4',
            'year_end' => 'nullable|string|max:4',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        CarModel::create($validated);

        return redirect()->route('admin.models.index')
            ->with('success', 'Model başarıyla oluşturuldu.');
    }

    public function edit(CarModel $model)
    {
        $brands = CarBrand::where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('admin.models.edit', compact('model', 'brands'));
    }

    public function update(Request $request, CarModel $model)
    {
        $validated = $request->validate([
            'car_brand_id' => 'required|exists:car_brands,id',
            'name' => 'required|string|max:255',
            'year_start' => 'nullable|string|max:4',
            'year_end' => 'nullable|string|max:4',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $model->update($validated);

        return redirect()->route('admin.models.index')
            ->with('success', 'Model başarıyla güncellendi.');
    }

    public function destroy(CarModel $model)
    {
        $model->delete();

        return redirect()->route('admin.models.index')
            ->with('success', 'Model başarıyla silindi.');
    }
} 