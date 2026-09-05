@extends('layouts.admin')

@section('title', 'Yeni Marka - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-dark border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-2 text-white">Yeni Marka Ekle</h1>
                            <p class="text-gray-400">Yeni bir araç markası oluşturun</p>
                        </div>
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Geri Dön
                        </a>
                    </div>

                    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="name" class="form-label text-white">Marka Adı</label>
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
                                    <label for="description" class="form-label text-white">Açıklama</label>
                                    <textarea class="form-control bg-white text-dark @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="logo" class="form-label text-white">Marka Logosu</label>
                                    <div class="logo-preview mb-3 text-center">
                                        <div class="bg-gray-700 rounded-xl p-4 d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="fas fa-image fa-3x text-gray-400"></i>
                                        </div>
                                    </div>
                                    <input type="file" 
                                           class="form-control bg-white text-dark @error('logo') is-invalid @enderror" 
                                           id="logo" 
                                           name="logo"
                                           accept="image/*">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-gray-400 mt-2 d-block">
                                        Önerilen boyut: 200x200px, maksimum boyut: 2MB
                                    </small>
                                </div>

                                <div class="mb-4">
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
                                
                                <div class="mb-4">
                                    <label for="parent_id" class="form-label text-white">Alt Marka Olarak Ekle</label>
                                    <select class="form-select bg-white text-dark" id="parent_id" name="parent_id">
                                        <option value="">Ana Marka (Bağımsız)</option>
                                        @foreach(\App\Models\CarBrand::whereNull('parent_id')->get() as $parentBrand)
                                            <option value="{{ $parentBrand->id }}" {{ old('parent_id') == $parentBrand->id ? 'selected' : '' }}>{{ $parentBrand->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-gray-400 mt-2 d-block">
                                        Bu markayı başka bir markanın alt markası olarak ekleyin
                                    </small>
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
document.getElementById('logo').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.logo-preview');
            preview.innerHTML = `
                <div class="bg-gray-700 rounded-xl p-4 d-flex align-items-center justify-content-center" style="height: 150px;">
                    <img src="${e.target.result}" class="img-fluid" style="max-height: 100%; filter: brightness(0) invert(1);">
                </div>
            `;
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endpush

@endsection