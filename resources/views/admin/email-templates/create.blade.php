@extends('layouts.admin')

@section('title', 'Yeni E-posta Teması Ekle')

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.email-templates.index') }}">E-posta Temaları</a></li>
            <li class="breadcrumb-item active" aria-current="page">Yeni Tema</li>
        </ol>
    </nav>

    <div class="card bg-dark border-0">
        <div class="card-header bg-dark border-0">
            <h3 class="text-white mb-0">Yeni E-posta Teması Ekle</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.email-templates.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label text-white">Tema Adı</label>
                            <input type="text" class="form-control bg-gray-700 border-0 text-white @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="subject" class="form-label text-white">E-posta Konusu</label>
                            <input type="text" class="form-control bg-gray-700 border-0 text-white @error('subject') is-invalid @enderror" 
                                id="subject" name="subject" value="{{ old('subject') }}" required>
                            <small class="text-muted">Değişkenler için <code>{ad}</code>, <code>{site_adi}</code> gibi kullanabilirsiniz.</small>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label text-white">Açıklama</label>
                    <textarea class="form-control bg-gray-700 border-0 text-white @error('description') is-invalid @enderror" 
                        id="description" name="description" rows="2">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label text-white">E-posta İçeriği</label>
                    <textarea class="form-control bg-gray-700 border-0 text-white @error('body') is-invalid @enderror" 
                        id="body" name="body" rows="12" required>{{ old('body') }}</textarea>
                    <small class="text-muted">
                        Kullanabileceğiniz değişkenler: <code>{ad}</code>, <code>{email}</code>, <code>{site_adi}</code>
                    </small>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label text-white" for="is_active">Aktif</label>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.email-templates.index') }}" class="btn btn-outline-secondary">
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

@push('styles')
<style>
.bg-gray-700 {
    background-color: #374151;
}
.form-control.bg-gray-700::placeholder {
    color: #9ca3af;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // İçerik editörü eklenebilir
});
</script>
@endpush
@endsection 