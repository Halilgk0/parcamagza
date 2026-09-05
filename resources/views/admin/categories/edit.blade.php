@extends('layouts.admin')

@section('title', 'Kategori Düzenle - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-dark border-0">
                <div class="card-body p-4">
                    <h1 class="h3 mb-4 text-white">Kategori Düzenle: {{ $category->name }}</h1>

                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="name" class="form-label text-white">Kategori Adı</label>
                                    <input type="text" 
                                           class="form-control bg-gray-700 border-0 text-white @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $category->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label text-white">Açıklama</label>
                                    <textarea class="form-control bg-gray-700 border-0 text-white @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="parent_id" class="form-label text-white">Üst Kategori</label>
                                    <select class="form-select bg-gray-700 border-0 text-white @error('parent_id') is-invalid @enderror" 
                                            id="parent_id" 
                                            name="parent_id">
                                        <option value="">Ana Kategori</option>
                                        @foreach($categories as $parent)
                                            <option value="{{ $parent->id }}" 
                                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }}
                                            </option>
                                            @foreach($parent->children as $child)
                                                <option value="{{ $child->id }}" 
                                                    {{ old('parent_id', $category->parent_id) == $child->id ? 'selected' : '' }}>
                                                    -- {{ $child->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="icon" class="form-label text-white">Font Awesome İkon</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-gray-700 border-0 text-white">
                                            <i class="fas fa-icons"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control bg-gray-700 border-0 text-white @error('icon') is-invalid @enderror" 
                                               id="icon" 
                                               name="icon" 
                                               value="{{ old('icon', $category->icon) }}" 
                                               placeholder="fa-folder">
                                    </div>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-gray-400">Font Awesome 6 Free ikonlarını kullanabilirsiniz</small>
                                </div>

                                <div class="mb-4">
                                    <label for="image" class="form-label text-white">Kategori Görseli</label>
                                    @if($category->image)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($category->image) }}" 
                                                 alt="{{ $category->name }}" 
                                                 class="img-thumbnail bg-dark border-0"
                                                 style="max-height: 100px;">
                                        </div>
                                    @endif
                                    <input type="file" 
                                           class="form-control bg-gray-700 border-0 text-white @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label text-white" for="is_active">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light me-2">İptal</a>
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
