@extends('layouts.admin')

@section('title', 'Yeni Parça - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-2 text-white">Yeni Parça Ekle</h1>
                            <p class="text-white opacity-75">Yeni bir araç parçası ekleyin</p>
                        </div>
                        <a href="{{ route('admin.parts.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Parçalara Dön
                        </a>
                    </div>

                    <form action="{{ route('admin.parts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card bg-dark border-0 mb-4">
                                    <div class="card-header bg-dark border-0">
                                        <h5 class="text-white mb-0">Temel Bilgiler</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label for="category_id" class="form-label text-white">Kategori</label>
                                                    <select class="form-select bg-white text-dark @error('category_id') is-invalid @enderror" 
                                                            id="category_id" 
                                                            name="category_id" 
                                                            required>
                                                        <option value="">Kategori Seçin</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label for="brand_id" class="form-label text-white">Marka</label>
                                                    <select class="form-select bg-white text-dark @error('brand_id') is-invalid @enderror" 
                                                            id="brand_id" 
                                                            name="brand_id" 
                                                            required>
                                                        <option value="">Marka Seçin</option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                                {{ $brand->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('brand_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="name" class="form-label text-white">Parça Adı</label>
                                            <input type="text" 
                                                   class="form-control bg-white text-dark @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name') }}" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="part_number" class="form-label text-white">Parça Numarası</label>
                                            <input type="text" 
                                                   class="form-control bg-white text-dark @error('part_number') is-invalid @enderror" 
                                                   id="part_number" 
                                                   name="part_number" 
                                                   value="{{ old('part_number') }}" 
                                                   required>
                                            @error('part_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="description" class="form-label text-white">Açıklama</label>
                                            <textarea class="form-control bg-white text-dark @error('description') is-invalid @enderror" 
                                                      id="description" 
                                                      name="description" 
                                                      rows="4">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="manufacturer" class="form-label text-white">Üretici</label>
                                            <input type="text" 
                                                   class="form-control bg-white text-dark @error('manufacturer') is-invalid @enderror" 
                                                   id="manufacturer" 
                                                   name="manufacturer" 
                                                   value="{{ old('manufacturer') }}">
                                            @error('manufacturer')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card bg-dark border-0 mb-4">
                                    <div class="card-header bg-dark border-0 d-flex justify-content-between align-items-center">
                                        <h5 class="text-white mb-0">Uyumlu Modeller</h5>
                                        <button type="button" class="btn btn-sm btn-primary" id="selectAllModelsBtn">Tümünü Seç</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle me-2"></i>Bu parçanın uyumlu olduğu araç modellerini seçin. Marka seçtiğinizde, o markaya ait modeller filtrelenecektir.
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                <input type="text" class="form-control" id="modelSearchInput" placeholder="Model ara...">
                                            </div>
                                        </div>

                                        <div class="row g-3" id="compatibleModelsContainer">
                                            @foreach($carModels as $model)
                                                <div class="col-md-4 model-item" data-brand-id="{{ $model->car_brand_id }}">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               id="model_{{ $model->id }}" name="compatible_models[]" 
                                                               value="{{ $model->id }}"
                                                               {{ in_array($model->id, old('compatible_models', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label text-white" for="model_{{ $model->id }}">
                                                            <span class="text-primary">{{ $model->brand->name }}</span> {{ $model->name }}
                                                            @if($model->year_start || $model->year_end)
                                                                <small class="text-muted d-block">
                                                                    {{ $model->year_start ?? '?' }} - {{ $model->year_end ?? 'Günümüz' }}
                                                                </small>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('compatible_models')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card bg-dark border-0 mb-4">
                                    <div class="card-header bg-dark border-0">
                                        <h5 class="text-white mb-0">Stok ve Fiyat Bilgileri</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label for="price" class="form-label text-white">Fiyat</label>
                                                    <div class="input-group">
                                                        <input type="number" 
                                                               class="form-control bg-white text-dark @error('price') is-invalid @enderror" 
                                                               id="price" 
                                                               name="price" 
                                                               value="{{ old('price') }}" 
                                                               step="0.01" 
                                                               required>
                                                        <span class="input-group-text bg-white text-dark">TL</span>
                                                    </div>
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label for="stock_quantity" class="form-label text-white">Stok Miktarı</label>
                                                    <input type="number" 
                                                           class="form-control bg-white text-dark @error('stock_quantity') is-invalid @enderror" 
                                                           id="stock_quantity" 
                                                           name="stock_quantity" 
                                                           value="{{ old('stock_quantity', 0) }}" 
                                                           min="0" 
                                                           required>
                                                    @error('stock_quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="condition" class="form-label text-white">Durum</label>
                                            <select class="form-select bg-white text-dark @error('condition') is-invalid @enderror" 
                                                    id="condition" 
                                                    name="condition" 
                                                    required>
                                                <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Yeni</option>
                                                <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Kullanılmış</option>
                                                <option value="refurbished" {{ old('condition') == 'refurbished' ? 'selected' : '' }}>Yenilenmiş</option>
                                            </select>
                                            @error('condition')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-dark border-0 mb-4">
                                    <div class="card-header bg-dark border-0">
                                        <h5 class="text-white mb-0">Görsel</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label for="image" class="form-label text-white">Parça Görseli</label>
                                            <input type="file" 
                                                   class="form-control bg-white text-dark @error('image') is-invalid @enderror" 
                                                   id="image" 
                                                   name="image">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card bg-dark border-0">
                                    <div class="card-header bg-dark border-0">
                                        <h5 class="text-white mb-0">Yayın Durumu</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1" 
                                                   {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label text-white" for="is_active">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Marka seçildiğinde modelleri filtreleme
    const brandSelect = document.getElementById('brand_id');
    const modelItems = document.querySelectorAll('.model-item');
    
    function filterModelsByBrand() {
        const selectedBrandId = brandSelect.value;
        
        if (selectedBrandId) {
            modelItems.forEach(item => {
                if (item.dataset.brandId === selectedBrandId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                    // Gizlenen modellerin seçimini kaldır
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    checkbox.checked = false;
                }
            });
        } else {
            // Marka seçilmediğinde tüm modelleri göster
            modelItems.forEach(item => {
                item.style.display = 'block';
            });
        }
    }
    
    brandSelect.addEventListener('change', filterModelsByBrand);
    
    // Sayfa yüklendiğinde de filtrele
    filterModelsByBrand();
    
    // Model arama işlevi
    const searchInput = document.getElementById('modelSearchInput');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        modelItems.forEach(item => {
            // Önce marka filtresini kontrol et
            const selectedBrandId = brandSelect.value;
            if (selectedBrandId && item.dataset.brandId !== selectedBrandId) {
                item.style.display = 'none';
                return;
            }
            
            const label = item.querySelector('label').textContent.toLowerCase();
            if (searchTerm === '' || label.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
    
    // Tümünü seç butonu işlevi
    const selectAllBtn = document.getElementById('selectAllModelsBtn');
    
    selectAllBtn.addEventListener('click', function() {
        modelItems.forEach(item => {
            // Sadece görünen (filtrelenmiş) modelleri seç
            if (item.style.display !== 'none') {
                const checkbox = item.querySelector('input[type="checkbox"]');
                checkbox.checked = true;
            }
        });
    });
});
</script>
@endpush

@endsection 