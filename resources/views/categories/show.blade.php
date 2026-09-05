@extends('layouts.app')

@section('title', $category->name . ' - Parca Magaza')

@section('content')
<div style="background-color: var(--primary-black); padding: 2rem 0;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-light">Anasayfa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" class="text-light">Kategoriler</a></li>
                @if($category->parent)
                    <li class="breadcrumb-item">
                        <a href="{{ route('categories.show', $category->parent->slug) }}" class="text-light">
                            {{ $category->parent->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active text-primary" aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card mb-4" style="background-color: rgb(17, 17, 17);">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background-color: rgba(227, 24, 55, 0.1);">
                            <i class="fas {{ $category->icon ?? 'fa-folder' }} fa-2x text-primary"></i>
                        </div>
                        <h5 class="card-title text-light mb-0">{{ $category->name }}</h5>
                    </div>
                    @if($category->description)
                        <p class="card-text text-secondary">{{ $category->description }}</p>
                    @endif
                </div>
            </div>

            @if($category->children->count() > 0)
            <div class="card mb-4" style="background-color: rgb(17, 17, 17);">
                <div class="card-body">
                    <h5 class="card-title text-light mb-3">Alt Kategoriler</h5>
                    <div class="list-group bg-transparent">
                        @foreach($category->children as $child)
                            <a href="{{ route('categories.show', $child->slug) }}" 
                               class="list-group-item bg-transparent border-0 text-light ps-0">
                                <i class="fas fa-angle-right text-primary me-2"></i>
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Filters -->
            <div class="card" style="background-color: rgb(17, 17, 17);">
                <div class="card-body">
                    <h5 class="card-title text-light mb-3">Filtreler</h5>
                    <form action="{{ route('categories.show', $category->slug) }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label text-light">Fiyat Aralığı</label>
                            <div class="input-group">
                                <input type="number" class="form-control bg-dark text-light border-dark" name="min_price" 
                                       placeholder="Min" value="{{ request('min_price') }}">
                                <input type="number" class="form-control bg-dark text-light border-dark" name="max_price" 
                                       placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-light">Durum</label>
                            <select class="form-select bg-dark text-light border-dark" name="condition">
                                <option value="">Tümü</option>
                                <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Yeni</option>
                                <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Kullanılmış</option>
                                <option value="refurbished" {{ request('condition') == 'refurbished' ? 'selected' : '' }}>Yenilenmiş</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filtrele
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-light mb-0">{{ $category->name }} Parçaları</h1>
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-sort me-2"></i>Sırala
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="background-color: rgb(17, 17, 17);">
                        <li><a class="dropdown-item text-light" href="?sort=price_asc">Fiyat (Düşükten Yükseğe)</a></li>
                        <li><a class="dropdown-item text-light" href="?sort=price_desc">Fiyat (Yüksekten Düşüğe)</a></li>
                        <li><a class="dropdown-item text-light" href="?sort=name_asc">İsim (A-Z)</a></li>
                        <li><a class="dropdown-item text-light" href="?sort=name_desc">İsim (Z-A)</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                @forelse($parts as $part)
                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="background-color: rgb(17, 17, 17);">
                        <img src="{{ $part->image ?? asset('images/no-image.png') }}" 
                             class="card-img-top" 
                             alt="{{ $part->name }}"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-light">{{ $part->name }}</h5>
                            <p class="card-text text-secondary">{{ Str::limit($part->description, 100) }}</p>
                            <p class="card-text">
                                <span class="h5 text-primary">{{ number_format($part->price, 2) }} TL</span>
                            </p>
                            @if($part->stock_quantity > 0)
                                <span class="badge bg-success mb-2">Stokta</span>
                            @else
                                <span class="badge bg-danger mb-2">Stokta Yok</span>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('parts.show', $part->slug) }}" 
                                   class="btn btn-primary w-100">
                                   <i class="fas fa-info-circle me-2"></i>Detaylar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert" style="background-color: rgb(17, 17, 17);">
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-secondary mb-3"></i>
                            <h4 class="text-light">Bu kategoride henüz parça bulunmamaktadır.</h4>
                            <p class="text-secondary">Daha sonra tekrar kontrol edin veya diğer kategorilere göz atın.</p>
                            <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-arrow-left me-2"></i>Kategorilere Dön
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $parts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--primary-red);
    }
    
    .page-link {
        background-color: rgb(17, 17, 17);
        border-color: var(--primary-red);
        color: var(--primary-red);
    }
    
    .page-link:hover {
        background-color: var(--primary-red);
        border-color: var(--primary-red);
        color: white;
    }
    
    .page-item.active .page-link {
        background-color: var(--primary-red);
        border-color: var(--primary-red);
    }
    
    .dropdown-item:hover {
        background-color: var(--primary-red);
    }
</style>
@endsection 