@extends('layouts.admin')

@section('title', 'Yeni Model - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-2 text-white">Yeni Model Oluştur</h1>
                            <p class="text-white opacity-75">Yeni bir araç modeli oluşturun</p>
                        </div>
                        <a href="{{ route('admin.models.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Geri Dön
                        </a>
                    </div>

                    <form action="{{ route('admin.models.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="car_brand_id" class="form-label text-white">Marka</label>
                                    <select class="form-select bg-white text-dark @error('car_brand_id') is-invalid @enderror" 
                                            id="car_brand_id" 
                                            name="car_brand_id" 
                                            required>
                                        <option value="">Marka Seçin</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('car_brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('car_brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="name" class="form-label text-white">Model Adı</label>
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

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="year_start" class="form-label text-white">Başlangıç Yılı</label>
                                            <input type="text" 
                                                   class="form-control bg-white text-dark @error('year_start') is-invalid @enderror" 
                                                   id="year_start" 
                                                   name="year_start" 
                                                   value="{{ old('year_start') }}" 
                                                   placeholder="örn: 2010">
                                            @error('year_start')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="year_end" class="form-label text-white">Bitiş Yılı</label>
                                            <input type="text" 
                                                   class="form-control bg-white text-dark @error('year_end') is-invalid @enderror" 
                                                   id="year_end" 
                                                   name="year_end" 
                                                   value="{{ old('year_end') }}" 
                                                   placeholder="örn: 2015">
                                            @error('year_end')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
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
@endsection 