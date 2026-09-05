@extends('layouts.app')

@section('title', $brand->name . ' Modelleri - Parca Magaza')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-red-500 hover:text-red-400">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('brands.index') }}" class="text-red-500 hover:text-red-400">Markalar</a></li>
            <li class="breadcrumb-item active text-gray-400" aria-current="page">{{ $brand->name }}</li>
        </ol>
    </nav>

    <div class="bg-dark/60 backdrop-blur-lg rounded-xl p-5 mb-5">
        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="brand-logo-wrapper bg-black/50 rounded-xl p-4 d-flex align-items-center justify-content-center" style="height: 120px;">
                    <img src="{{ $brand->logo ?? asset('images/no-logo.png') }}" 
                         alt="{{ $brand->name }}" 
                         class="img-fluid"
                         style="max-height: 100px; filter: brightness(0) invert(1);">
                </div>
            </div>
            <div class="col-md-10">
                <h1 class="display-4 text-white mb-3">{{ $brand->name }} Modelleri</h1>
                @if($brand->description)
                    <p class="lead text-gray-400 mb-0">{{ $brand->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($models as $model)
        <div class="col-md-4">
            <div class="card bg-dark/60 backdrop-blur-lg border-0 h-100 transition-all hover:translate-y-[-5px]">
                <div class="card-body p-4">
                    <h5 class="card-title text-white mb-3">{{ $model->name }}</h5>
                    @if($model->year_start || $model->year_end)
                        <p class="text-red-500 mb-3">
                            {{ $model->year_start ?? '?' }} - {{ $model->year_end ?? 'Günümüz' }}
                        </p>
                    @endif
                    @if($model->description)
                        <p class="card-text text-gray-400 mb-4">{{ Str::limit($model->description, 100) }}</p>
                    @endif
                    <a href="{{ route('parts.index', ['model' => $model->slug]) }}" 
                       class="btn btn-outline-danger w-100 hover:bg-red-500 hover:text-white transition-colors">
                        Parçaları Gör
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert bg-dark/60 backdrop-blur-lg border-red-500 text-white">
                <i class="fas fa-info-circle text-red-500 me-2"></i>
                Henüz bu markaya ait model bulunmamaktadır.
            </div>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $models->links() }}
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
}

.brand-logo-wrapper {
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.3);
}
</style>
@endsection