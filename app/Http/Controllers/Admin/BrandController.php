<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $brands = CarBrand::withCount('models')
            ->orderBy('name')
            ->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:car_brands',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'parent_id' => 'nullable|exists:car_brands,id'
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('brands', 'public');
            $validated['logo'] = $logoPath;
        }

        $validated['slug'] = Str::slug($validated['name']);
        
        CarBrand::create($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marka başarıyla oluşturuldu.');
    }

    public function edit(CarBrand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, CarBrand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:car_brands,name,' . $brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'parent_id' => 'nullable|exists:car_brands,id'
        ]);
        
        // Prevent circular references (brand can't be its own parent or child)
        if (!empty($validated['parent_id'])) {
            if ($validated['parent_id'] == $brand->id) {
                return redirect()->back()->withErrors(['parent_id' => 'Bir marka kendisinin alt markası olamaz.'])->withInput();
            }
            
            // Check if selected parent is not a child of this brand
            $childIds = $brand->children()->pluck('id')->toArray();
            if (in_array($validated['parent_id'], $childIds)) {
                return redirect()->back()->withErrors(['parent_id' => 'Bir markanın alt markası, o markanın üst markası olamaz.'])->withInput();
            }
        }

        if ($request->hasFile('logo')) {
            // Eski logoyu sil
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            
            $logoPath = $request->file('logo')->store('brands', 'public');
            $validated['logo'] = $logoPath;
        }

        $validated['slug'] = Str::slug($validated['name']);
        
        $brand->update($validated);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marka başarıyla güncellendi.');
    }

    public function destroy(CarBrand $brand)
    {
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }
        
        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marka başarıyla silindi.');
    }
} 