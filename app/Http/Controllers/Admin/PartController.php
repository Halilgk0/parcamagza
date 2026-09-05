<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::with(['category', 'brand', 'compatibleModels'])
            ->latest()
            ->paginate(10);
            
        return view('admin.parts.index', compact('parts'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands = CarBrand::where('is_active', true)->get();
        $carModels = CarModel::with('brand')->where('is_active', true)->get();
        
        return view('admin.parts.create', compact('categories', 'brands', 'carModels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:car_brands,id',
            'name' => 'required|string|max:255',
            'part_number' => 'required|string|unique:parts',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'condition' => 'required|in:new,used,refurbished',
            'manufacturer' => 'nullable|string|max:255',
            'specifications' => 'nullable|array',
            'compatible_models' => 'nullable|array',
            'compatible_models.*' => 'exists:car_models,id',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('parts', 'public');
        }

        $validated['slug'] = Str::slug($validated['name'] . '-' . $validated['part_number']);

        $part = Part::create($validated);

        if (isset($validated['compatible_models'])) {
            $part->compatibleModels()->sync($validated['compatible_models']);
        }

        return redirect()->route('admin.parts.index')
            ->with('success', 'Parça başarıyla oluşturuldu.');
    }

    public function edit(Part $part)
    {
        $categories = Category::where('is_active', true)->get();
        $brands = CarBrand::where('is_active', true)->get();
        $carModels = CarModel::with('brand')->where('is_active', true)->get();
        
        return view('admin.parts.edit', compact('part', 'categories', 'brands', 'carModels'));
    }

    public function update(Request $request, Part $part)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:car_brands,id',
            'name' => 'required|string|max:255',
            'part_number' => 'required|string|unique:parts,part_number,' . $part->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'condition' => 'required|in:new,used,refurbished',
            'manufacturer' => 'nullable|string|max:255',
            'specifications' => 'nullable|array',
            'compatible_models' => 'nullable|array',
            'compatible_models.*' => 'exists:car_models,id',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($part->image) {
                Storage::disk('public')->delete($part->image);
            }
            $validated['image'] = $request->file('image')->store('parts', 'public');
        }

        $validated['slug'] = Str::slug($validated['name'] . '-' . $validated['part_number']);

        $part->update($validated);

        if (isset($validated['compatible_models'])) {
            $part->compatibleModels()->sync($validated['compatible_models']);
        } else {
            $part->compatibleModels()->detach();
        }

        return redirect()->route('admin.parts.index')
            ->with('success', 'Parça başarıyla güncellendi.');
    }

    public function destroy(Part $part)
    {
        if ($part->image) {
            Storage::disk('public')->delete($part->image);
        }
        
        $part->compatibleModels()->detach();
        $part->delete();
        
        return redirect()->route('admin.parts.index')
            ->with('success', 'Parça başarıyla silindi.');
    }
    
    /**
     * Show the bulk upload form
     */
    public function showBulkUploadForm()
    {
        $brands = CarBrand::where('is_active', true)->get();
        $categories = Category::where('is_active', true)->get();
        
        // Create template file if it doesn't exist
        $templatePath = public_path('templates/parts_upload_template.csv');
        $instructionsPath = public_path('templates/parts_upload_instructions.txt');
        
        if (!file_exists($templatePath) || !file_exists($instructionsPath)) {
            $this->generateTemplateFile();
        }
        
        return view('admin.parts.bulk_upload', compact('brands', 'categories'));
    }
    
    /**
     * Generate template Excel file
     */
    private function generateTemplateFile()
    {
        // Basit bir CSV dosyası oluştur
        $headers = [
            'name', 'part_number', 'price', 'brand', 'description', 'stock_quantity', 
            'condition', 'manufacturer', 'compatible_models', 'image_url', 'specifications', 'compatibility'
        ];
        
        $exampleData = [
            ['Fren Balata Seti', 'FB-12345', '750.00', 'Bosch', 'Yüksek kaliteli fren balata seti', '15',
                'new', 'Bosch', 'Polo, Golf, Passat', 'https://example.com/image.jpg', 
                '{"material":"Seramik","width":"150mm"}', '{"model_years":"2010-2022"}'],
            ['Yağ Filtresi', 'YF-67890', '120.50', 'Mann', 'Uzun ömürlü yağ filtresi', '30',
                'new', 'Mann-Filter', 'Astra, Corsa, Insignia', '', '', '']
        ];
        
        // CSV dosyasını oluştur
        $output = fopen(public_path('templates/parts_upload_template.csv'), 'w');
        
        // Başlıkları yaz
        fputcsv($output, $headers);
        
        // Örnek verileri yaz
        foreach ($exampleData as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        
        // Talimat dosyası oluştur
        $instructions = "Toplu Parça Yükleme - Talimatlar\n\n";
        $instructions .= "Sütun Açıklamaları:\n";
        $instructions .= "name: Parça adı (zorunlu)\n";
        $instructions .= "part_number: Parça numarası (zorunlu, benzersiz olmalı)\n";
        $instructions .= "price: Fiyat (zorunlu, sayı formatında)\n";
        $instructions .= "brand: Marka adı (zorunlu)\n";
        $instructions .= "description: Açıklama (zorunlu)\n";
        $instructions .= "stock_quantity: Stok miktarı (zorunlu, sayı formatında)\n";
        $instructions .= "condition: Durum (yeni=new, kullanılmış=used, yenilenmiş=refurbished)\n";
        $instructions .= "manufacturer: Üretici firma\n";
        $instructions .= "compatible_models: Uyumlu modeller (virgülle ayrılmış)\n";
        $instructions .= "image_url: Resim URL adresi\n";
        $instructions .= "specifications: Özellikler (JSON formatında)\n";
        $instructions .= "compatibility: Uyumluluk bilgileri (JSON formatında)\n\n";
        
        $instructions .= "Önemli Notlar:\n";
        $instructions .= "1. İlk satır başlık satırıdır, değiştirmeyin.\n";
        $instructions .= "2. name, part_number, price, brand, description ve stock_quantity sütunları zorunludur.\n";
        $instructions .= "3. Marka sistemde yoksa ve \"Olmayan markaları otomatik oluştur\" seçeneği işaretliyse otomatik oluşturulur.\n";
        $instructions .= "4. Parça numarası sistemde varsa ve \"Mevcut parçaları güncelle\" seçeneği işaretliyse parça güncellenir.\n";
        $instructions .= "5. Uyumlu modeller virgülle ayrılmış şekilde yazılmalıdır (örn: \"Polo, Golf, Passat\").\n";
        $instructions .= "6. specifications ve compatibility alanları JSON formatında olmalıdır (örn: {\"anahtar\":\"değer\"}).\n";
        
        file_put_contents(public_path('templates/parts_upload_instructions.txt'), $instructions);
    }
    
    /**
     * Process the bulk upload
     */
    public function processBulkUpload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv,txt',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        try {
            // Store the file temporarily
            $path = $request->file('excel_file')->store('temp');
            $fullPath = storage_path('app/' . $path);
            
            // CSV dosyasını işle
            $csvData = array_map('str_getcsv', file($fullPath));
            
            // Başlık satırını al
            $headers = array_shift($csvData);
            
            // Zorunlu sütunları kontrol et
            $requiredColumns = ['name', 'part_number', 'price', 'brand', 'description', 'stock_quantity'];
            $missingColumns = array_diff($requiredColumns, $headers);
            
            if (!empty($missingColumns)) {
                return back()->with('error', 'CSV dosyasında eksik sütunlar: ' . implode(', ', $missingColumns));
            }
            
            // Başlıkları konumlarıyla eşleştir
            $headerMap = array_flip($headers);
            
            // Parçaları içe aktar
            $imported = 0;
            $updated = 0;
            $failed = 0;
            $errors = [];
            
            // Seçenekler
            $createBrands = $request->has('create_brands');
            $updateExisting = $request->has('update_existing');
            
            foreach ($csvData as $rowIndex => $row) {
                // Boş satırları atla
                if (empty($row[$headerMap['name']]) || empty($row[$headerMap['part_number']])) {
                    continue;
                }
                
                try {
                    // Marka ID'sini al
                    $brandName = $row[$headerMap['brand']];
                    $brand = CarBrand::where('name', $brandName)->first();
                    $brandId = null;
                    
                    if (!$brand) {
                        if ($createBrands) {
                            // Marka yoksa ve oluşturma seçeneği işaretliyse oluştur
                            $brand = CarBrand::create([
                                'name' => $brandName,
                                'slug' => Str::slug($brandName),
                                'is_active' => true
                            ]);
                            $brandId = $brand->id;
                        } else {
                            // Marka yoksa ve otomatik oluşturma kapalıysa bu parçayı atla
                            $failed++;
                            $errors[] = "Satır " . ($rowIndex + 2) . ": Marka bulunamadı: " . $brandName;
                            continue;
                        }
                    } else {
                        $brandId = $brand->id;
                    }
                    
                    // Parça zaten var mı kontrol et
                    $part = Part::where('part_number', $row[$headerMap['part_number']])->first();
                    
                    if ($part && $updateExisting) {
                        // Mevcut parçayı güncelle
                        $partData = [
                            'category_id' => $request->category_id,
                            'brand_id' => $brandId,
                            'name' => $row[$headerMap['name']],
                            'description' => $row[$headerMap['description']] ?? '',
                            'price' => $row[$headerMap['price']] ?? 0,
                            'stock_quantity' => $row[$headerMap['stock_quantity']] ?? 0,
                            'condition' => $row[$headerMap['condition']] ?? 'new',
                            'manufacturer' => $row[$headerMap['manufacturer']] ?? null,
                            'is_active' => true,
                            'slug' => Str::slug($row[$headerMap['name']] . '-' . $row[$headerMap['part_number']])
                        ];
                        
                        // Özellikleri işle (eğer varsa)
                        if (isset($headerMap['specifications']) && !empty($row[$headerMap['specifications']])) {
                            $partData['specifications'] = json_decode($row[$headerMap['specifications']], true) ?? [];
                        }
                        
                        // Uyumluluk bilgilerini işle (eğer varsa)
                        if (isset($headerMap['compatibility']) && !empty($row[$headerMap['compatibility']])) {
                            $partData['compatibility'] = json_decode($row[$headerMap['compatibility']], true) ?? [];
                        }
                        
                        // Parçayı güncelle
                        $part->update($partData);
                        
                        // Uyumlu modelleri işle (eğer varsa)
                        if (isset($headerMap['compatible_models']) && !empty($row[$headerMap['compatible_models']])) {
                            $modelNames = explode(',', $row[$headerMap['compatible_models']]);
                            $modelIds = [];
                            
                            foreach ($modelNames as $modelName) {
                                $modelName = trim($modelName);
                                $model = CarModel::where('name', $modelName)->where('brand_id', $brandId)->first();
                                
                                if ($model) {
                                    $modelIds[] = $model->id;
                                }
                            }
                            
                            // Modelleri senkronize et (listedeki olmayan eski ilişkileri kaldırır)
                            $part->compatibleModels()->sync($modelIds);
                        }
                        
                        $updated++;
                    } elseif (!$part) {
                        // Yeni parça oluştur
                        $partData = [
                            'category_id' => $request->category_id,
                            'brand_id' => $brandId,
                            'name' => $row[$headerMap['name']],
                            'part_number' => $row[$headerMap['part_number']],
                            'description' => $row[$headerMap['description']] ?? '',
                            'price' => $row[$headerMap['price']] ?? 0,
                            'stock_quantity' => $row[$headerMap['stock_quantity']] ?? 0,
                            'condition' => $row[$headerMap['condition']] ?? 'new',
                            'manufacturer' => $row[$headerMap['manufacturer']] ?? null,
                            'is_active' => true,
                            'slug' => Str::slug($row[$headerMap['name']] . '-' . $row[$headerMap['part_number']])
                        ];
                        
                        // Özellikleri işle (eğer varsa)
                        if (isset($headerMap['specifications']) && !empty($row[$headerMap['specifications']])) {
                            $partData['specifications'] = json_decode($row[$headerMap['specifications']], true) ?? [];
                        }
                        
                        // Uyumluluk bilgilerini işle (eğer varsa)
                        if (isset($headerMap['compatibility']) && !empty($row[$headerMap['compatibility']])) {
                            $partData['compatibility'] = json_decode($row[$headerMap['compatibility']], true) ?? [];
                        }
                        
                        // Parçayı oluştur
                        $part = Part::create($partData);
                        
                        // Uyumlu modelleri işle (eğer varsa)
                        if (isset($headerMap['compatible_models']) && !empty($row[$headerMap['compatible_models']])) {
                            $modelNames = explode(',', $row[$headerMap['compatible_models']]);
                            
                            foreach ($modelNames as $modelName) {
                                $modelName = trim($modelName);
                                $model = CarModel::where('name', $modelName)->where('brand_id', $brandId)->first();
                                
                                if ($model) {
                                    $part->compatibleModels()->attach($model->id);
                                }
                            }
                        }
                        
                        // Resmi işle (eğer varsa)
                        if (isset($headerMap['image_url']) && !empty($row[$headerMap['image_url']])) {
                            try {
                                $imageUrl = $row[$headerMap['image_url']];
                                $imageContents = file_get_contents($imageUrl);
                                $filename = 'parts/' . Str::random(20) . '.jpg';
                                Storage::disk('public')->put($filename, $imageContents);
                                $part->update(['image' => $filename]);
                            } catch (\Exception $e) {
                                // Sadece hatayı logla ama içe aktarma işlemine devam et
                                \Log::error('Failed to import image for part ' . $part->id . ': ' . $e->getMessage());
                            }
                        }
                        
                        $imported++;
                    } else {
                        // Parça var ama güncelleme seçeneği etkin değil
                        $failed++;
                        $errors[] = "Satır " . ($rowIndex + 2) . ": Parça numarası zaten mevcut: " . $row[$headerMap['part_number']];
                    }
                } catch (\Exception $e) {
                    $failed++;
                    $errors[] = "Satır " . ($rowIndex + 2) . ": " . $e->getMessage();
                }
            }
            
            // Geçici dosyayı sil
            Storage::delete($path);
            
            if ($imported > 0 || $updated > 0) {
                $message = '';
                if ($imported > 0) {
                    $message .= $imported . ' parça başarıyla içe aktarıldı. ';
                }
                
                if ($updated > 0) {
                    $message .= $updated . ' parça güncellendi. ';
                }
                
                if ($failed > 0) {
                    $message .= $failed . ' parça işlenemedi.';
                }
                
                return redirect()->route('admin.parts.index')->with('success', $message);
            } else {
                return back()
                    ->with('error', 'Hiçbir parça içe aktarılamadı. Hata detayları: ' . implode(', ', $errors));
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Dosya işlenemedi: ' . $e->getMessage());
        }
    }
} 