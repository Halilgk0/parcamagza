@extends('layouts.app')

@section('title', 'Anasayfa - Parca Magaza')

@section('content')
<!-- Hero Section -->
<div class="hero-section position-relative overflow-hidden">
    <div class="hero-bg position-absolute w-100 h-100" style="
        background: linear-gradient(135deg, var(--dark-color) 0%, var(--gray-800) 100%);
        opacity: 0.97;
        z-index: -1;">
    </div>
    <div class="container py-5">
        <div class="row align-items-center min-vh-75" style="min-height: 75vh;">
            <div class="col-lg-6 text-light pe-lg-5">
                <h1 class="display-4 fw-bold mb-4 text-uppercase" style="letter-spacing: -1px;">
                    OTOMOTİV PARÇALARINDA<br>
                    <span class="text-primary">PROFESYONEL</span> ÇÖZÜM
                </h1>
                <p class="lead mb-4 text-gray-300" style="font-size: 1.1rem;">
                    Türkiye'nin en kapsamlı yedek parça platformunda binlerce orijinal ve yan sanayi ürün tek tıkla kapınızda!
                </p>
                <div class="d-flex gap-3 mb-5">
                    <a href="{{ route('parts.index') }}" class="btn btn-primary btn-lg px-4 py-3 d-inline-flex align-items-center">
                        <i class="fas fa-search me-2"></i>Parçaları Keşfet
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-light btn-lg px-4 py-3 d-inline-flex align-items-center">
                        <i class="fas fa-th-large me-2"></i>Kategoriler
                    </a>
                </div>
                <div class="row g-4 text-center text-sm-start">
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-primary fa-2x me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1">100% Orijinal</h6>
                                <p class="small text-gray-300 mb-0">Garantili Ürünler</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-truck text-primary fa-2x me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Hızlı Teslimat</h6>
                                <p class="small text-gray-300 mb-0">24 Saat İçinde</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-headset text-primary fa-2x me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1">7/24 Destek</h6>
                                <p class="small text-gray-300 mb-0">Uzman Ekip</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block position-relative">
                <div class="position-relative">
                    @if(isset($homeBanners) && count($homeBanners) > 0)
                        <!-- Display the latest banner image -->
                        <div class="banner-container" style="height: 350px; width: 100%; overflow: hidden; border-radius: 10px; background: linear-gradient(135deg, #1e5799 0%, #e53935 100%);">
                            <a href="{{ $homeBanners[0]->link ?? '#' }}" class="d-block h-100">
                                @if($homeBanners[0]->image_path)
                                    <img src="{{ asset('storage/' . $homeBanners[0]->image_path) }}" alt="{{ $homeBanners[0]->title }}" 
                                        class="w-100 h-100" style="object-fit: cover;">
                                @endif
                            </a>
                        </div>
                    @else
                        <!-- Fallback if no banners are available -->
                        <div class="banner-container" style="height: 350px; width: 100%; overflow: hidden; border-radius: 10px; background: linear-gradient(135deg, #1e5799 0%, #e53935 100%); display: flex; align-items: center; justify-content: center;">
                            <div class="text-center text-white">
                                <i class="fas fa-car fa-4x mb-3"></i>
                                <h3 class="text-uppercase fw-bold">ARAÇ PARÇALARI</h3>
                                <p>Kaliteli ve Uygun Fiyatlı</p>
                            </div>
                        </div>
                    @endif
                    <div class="position-absolute top-50 start-50 translate-middle" style="z-index: -1;">
                        <div class="rounded-circle bg-primary" style="width: 450px; height: 450px; opacity: 0.1;"></div>
                    </div>
                </div>
                <!-- Animated Elements -->
                <div class="position-absolute" style="top: 20%; right: 10%;">
                    <div class="badge bg-primary p-3 floating-animation-slow">
                        <i class="fas fa-cogs fa-2x"></i>
                    </div>
                </div>
                <div class="position-absolute" style="bottom: 15%; left: 5%;">
                    <div class="badge bg-danger p-3 floating-animation-reverse">
                        <i class="fas fa-tools fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Search Section -->
<div class="container">
    <div class="card shadow-lg mt-n5 position-relative" style="z-index: 100; border: 2px solid var(--dark-color); background: linear-gradient(to right, var(--gray-100), white); color: black;">
        <div class="card-body p-4">
            <form action="{{ route('parts.search') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0">
                            <i class="fas fa-car text-primary"></i>
                        </span>
                        <select name="brand" class="form-select border-0 py-3">
                            <option value="">Araç Markası Seçin</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0">
                            <i class="fas fa-cog text-primary"></i>
                        </span>
                        <select name="category" class="form-select border-0 py-3" style="color: black;">
                            <option value="">Parça Kategorisi Seçin</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary w-100 py-3">
                        <i class="fas fa-search me-2"></i>Parça Ara
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Öne Çıkan Parçalar -->
<section class="featured-parts py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-star text-warning me-2 fa-2x"></i>
                <h2 class="h3 text-white mb-0">Öne Çıkan Parçalar</h2>
            </div>
            <a href="{{ route('parts.index') }}" class="btn btn-outline-light">
                Tüm Parçaları Gör <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredParts as $part)
            <div class="col-md-3">
                <div class="card h-100 bg-dark border-0 position-relative">
                    @if($part->stock_quantity > 0)
                        <div class="badge bg-success position-absolute top-0 end-0 m-2">Stokta</div>
                    @else
                        <div class="badge bg-danger position-absolute top-0 end-0 m-2">Tükendi</div>
                    @endif
                    
                    <div class="card-img-wrapper" style="height: 200px; background: rgba(255,255,255,0.1);">
                        <img src="{{ $part->image ? Storage::url($part->image) : asset('images/no-image.png') }}" 
                             class="card-img-top h-100 w-100" 
                             alt="{{ $part->name }}"
                             style="object-fit: contain; padding: 1rem;">
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title text-white mb-2" style="font-size: 1.1rem;">{{ $part->name }}</h5>
                        <p class="card-text text-gray-400 small mb-3">{{ Str::limit($part->description, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fs-5 text-white fw-bold">{{ number_format($part->price, 2) }}</span>
                                <small class="text-gray-400">TL</small>
                            </div>
                            <a href="{{ route('parts.show', $part->slug) }}" class="btn btn-primary btn-sm">
                                Detaylar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Additional Banners Section (if more than one banner exists) -->
@if(isset($homeBanners) && count($homeBanners) > 1)
<section class="additional-banners py-4 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3 class="text-white">Diğer Duyurular</h3>
            </div>
            <div class="col-12">
                <div class="row g-4">
                    @foreach($homeBanners as $key => $banner)
                        @if($key > 0) <!-- Skip the first banner as it's already shown in the hero section -->
                        <div class="col-md-4">
                            <div class="card bg-dark border-0 h-100">
                                <a href="{{ $banner->link }}" class="text-decoration-none">
                                    <img src="{{ Storage::url($banner->image_path) }}" class="card-img-top" alt="{{ $banner->title }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-white">{{ $banner->title }}</h5>
                                        <p class="card-text text-gray-400">{{ $banner->subtitle }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Kategoriler -->


<!-- Özellikler -->
<section class="features py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card bg-dark border-0 text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-truck text-primary fa-3x mb-3"></i>
                        <h4 class="text-white h5">Hızlı Teslimat</h4>
                        <p class="text-gray-400 mb-0">Siparişleriniz aynı gün kargoya verilir</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark border-0 text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-shield-alt text-primary fa-3x mb-3"></i>
                        <h4 class="text-white h5">Güvenli Alışveriş</h4>
                        <p class="text-gray-400 mb-0">%100 güvenli ödeme sistemi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark border-0 text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-medal text-primary fa-3x mb-3"></i>
                        <h4 class="text-white h5">Kaliteli Ürünler</h4>
                        <p class="text-gray-400 mb-0">Orijinal ve garantili ürünler</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-dark border-0 text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-headset text-primary fa-3x mb-3"></i>
                        <h4 class="text-white h5">7/24 Destek</h4>
                        <p class="text-gray-400 mb-0">Her zaman yanınızdayız</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popüler Markalar -->
<section class="brands py-5 bg-dark">
    <div class="container">
        <h2 class="text-center text-white mb-5">Popüler Markalar</h2>
        <div class="row g-4">
            @foreach($brands as $brand)
            <div class="col-md-2 col-6">
                <a href="{{ route('brands.show', $brand->slug) }}" class="text-decoration-none">
                    <div class="card bg-black h-100 border-0 text-center transition-all hover:scale-105">
                        <div class="card-body p-3">
                            @if($brand->logo)
                                <img src="{{ Storage::url($brand->logo) }}" 
                                     alt="{{ $brand->name }}" 
                                     class="img-fluid mb-2"
                                     style="max-height: 50px; filter: brightness(0) invert(1);">
                            @else
                                <i class="fas fa-building fa-2x text-gray-500 mb-2"></i>
                            @endif
                            <h6 class="card-title text-white mb-0">{{ $brand->name }}</h6>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }

    .text-gray-400 {
        color: #9ca3af !important;
    }

    .bg-black {
        background-color: #000000 !important;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .hover\:scale-105:hover {
        transform: scale(1.05);
    }
</style>
@endpush
@endsection