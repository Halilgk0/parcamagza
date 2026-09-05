@extends('layouts.app')

@section('title', 'Araç Markaları - Parca Magaza')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 text-white mb-2">Araç Markaları</h1>
        <p class="text-gray-400">Aracınızın markasını seçerek yedek parça aramaya başlayın</p>
    </div>
    
    <div class="row g-4">
        @foreach($brands as $brand)
        <div class="col-md-2 col-6">
            <a href="{{ route('brands.show', $brand->slug) }}" class="text-decoration-none">
                <div class="card bg-dark border-0 h-100 text-center transition-all hover:scale-105 hover:shadow-lg">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="brand-logo-wrapper mb-3 bg-black/50 rounded-xl p-3 w-100 d-flex align-items-center justify-content-center" style="height: 80px;">
                            <img src="{{ $brand->logo ?? asset('images/no-logo.png') }}" 
                                 alt="{{ $brand->name }}" 
                                 class="img-fluid brand-logo"
                                 style="max-height: 60px; filter: brightness(0) invert(1);">
                        </div>
                        <h5 class="card-title text-white mb-2 fw-semibold">{{ $brand->name }}</h5>
                        @if($brand->models_count)
                            <p class="text-red-500 mb-0 small">{{ $brand->models_count }} Model</p>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $brands->links() }}
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
    background: rgba(24, 24, 27, 0.6) !important;
    backdrop-filter: blur(10px);
}

.card:hover {
    transform: translateY(-5px);
    background: rgba(24, 24, 27, 0.8) !important;
}

.card:hover .brand-logo {
    transform: scale(1.1);
}

.brand-logo {
    transition: transform 0.3s ease;
}

.brand-logo-wrapper {
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
</style>
@endsection