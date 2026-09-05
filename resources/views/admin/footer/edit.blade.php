@extends('layouts.admin')

@section('title', 'Footer Bağlantısını Düzenle')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.footer.index') }}">Footer Yönetimi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bağlantı Düzenle</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-gray-800">
            <h5 class="mb-0 text-white">Footer Bağlantısını Düzenle</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.footer.update', $footerLink) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label text-white">Başlık</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title', $footerLink->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="url" class="form-label text-white">URL</label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror" 
                                id="url" name="url" value="{{ old('url', $footerLink->url) }}" required>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="column" class="form-label text-white">Kolon</label>
                            <select class="form-select @error('column') is-invalid @enderror" 
                                id="column" name="column" required>
                                <option value="main" {{ old('column', $footerLink->column) == 'main' ? 'selected' : '' }}>Ana (Main)</option>
                                <option value="support" {{ old('column', $footerLink->column) == 'support' ? 'selected' : '' }}>Destek (Support)</option>
                                <option value="legal" {{ old('column', $footerLink->column) == 'legal' ? 'selected' : '' }}>Yasal (Legal)</option>
                                <option value="social" {{ old('column', $footerLink->column) == 'social' ? 'selected' : '' }}>Sosyal (Social)</option>
                            </select>
                            @error('column')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="position" class="form-label text-white">Sıra</label>
                            <input type="number" class="form-control @error('position') is-invalid @enderror" 
                                id="position" name="position" value="{{ old('position', $footerLink->position) }}" min="0" required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label d-block text-white">Durum</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="is_active" name="is_active" value="1" 
                                    {{ old('is_active', $footerLink->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label text-white" for="is_active">Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.footer.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Geri
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 