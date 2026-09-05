@extends('layouts.admin')

@section('title', 'Banner Düzenle')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Banner Düzenle</h1>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Geri Dön
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Banner Bilgileri</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="section">Banner Bölümü <span class="text-danger">*</span></label>
                    <select name="section" id="section" class="form-control @error('section') is-invalid @enderror" required style="color: white; background-color: #343a40; border-color: #454d55;">
                        <option value="home_banner" {{ $banner->section == 'home_banner' ? 'selected' : '' }}>Ana Sayfa - ARAÇ PARÇALARI</option>
                        <option value="other_section" {{ $banner->section == 'other_section' ? 'selected' : '' }}>Diğer Bölüm</option>
                    </select>
                    @error('section')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Mevcut Görsel</label>
                    <div class="mb-3">
                        <img src="{{ Storage::url($banner->image_path) }}" alt="{{ $banner->title }}" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Yeni Görsel (Opsiyonel)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                        <label class="custom-file-label" for="image">Görsel Seç</label>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Önerilen boyut: 1200x600px, Maksimum dosya boyutu: 2MB</small>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Başlık</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $banner->title) }}" style="color: white; background-color: #343a40; border-color: #454d55;">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subtitle">Alt Başlık</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" style="color: white; background-color: #343a40; border-color: #454d55;">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="link">Link (Opsiyonel)</label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link', $banner->link) }}" style="color: white; background-color: #343a40; border-color: #454d55;">
                            @error('link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="order">Sıralama</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $banner->order) }}" style="color: white; background-color: #343a40; border-color: #454d55;">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Düşük sayılar önce gösterilir</small>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ $banner->is_active ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Aktif</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Güncelle
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // File input label update
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush
