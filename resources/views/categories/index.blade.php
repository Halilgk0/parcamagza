@extends('layouts.app')

@section('title', 'Parça Kategorileri - Parca Magaza')

@section('content')
<div style="background-color: var(--primary-black); padding: 3rem 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-light mb-3">Parça Kategorileri</h1>
                <p class="text-light opacity-75 lead">Aradığınız tüm araç parçalarını kategorilere göre kolayca bulun.</p>
            </div>
            <div class="col-md-6 text-end">
                <img src="{{ asset('images/categories/header-image.svg') }}" alt="Categories" class="img-fluid" style="max-height: 200px;">
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        @foreach($categories as $category)
        <div class="col-md-4 mb-4">
            <div class="card h-100" style="background-color: rgb(17, 17, 17);">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background-color: rgba(227, 24, 55, 0.1);">
                            <i class="fas {{ $category->icon ?? 'fa-folder' }} fa-2x text-primary"></i>
                        </div>
                        <h4 class="card-title text-light mb-0">{{ $category->name }}</h4>
                    </div>
                    
                    @if($category->description)
                        <p class="card-text text-secondary mb-4">{{ Str::limit($category->description, 100) }}</p>
                    @endif

                    @if($category->children->count() > 0)
                        <div class="list-group bg-transparent mb-4">
                            @foreach($category->children->take(5) as $child)
                                <a href="{{ route('categories.show', $child->slug) }}" 
                                   class="list-group-item bg-transparent border-0 text-light ps-0">
                                    <i class="fas fa-angle-right text-primary me-2"></i>
                                    {{ $child->name }}
                                </a>
                            @endforeach
                            
                            @if($category->children->count() > 5)
                                <a href="{{ route('categories.show', $category->slug) }}" 
                                   class="list-group-item bg-transparent border-0 text-primary ps-0">
                                    <i class="fas fa-plus me-2"></i>
                                    {{ $category->children->count() - 5 }} kategori daha...
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="mt-auto">
                        <a href="{{ route('categories.show', $category->slug) }}" 
                           class="btn btn-primary w-100">
                            <i class="fas fa-arrow-right me-2"></i>
                            Tüm Parçaları Gör
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div style="background-color: rgb(17, 17, 17);" class="py-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-8">
                <h2 class="text-light mb-4">Aradığınız Parçayı Bulamadınız mı?</h2>
                <p class="text-secondary mb-4">Müşteri hizmetlerimiz size yardımcı olmak için hazır.</p>
                <a href="#" class="btn btn-primary btn-lg">
                    <i class="fas fa-headset me-2"></i>
                    Bize Ulaşın
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 