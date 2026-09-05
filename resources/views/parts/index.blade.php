@extends('layouts.app')

@section('title', 'Tüm Parçalar - Parca Magaza')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <!-- Sol Sidebar -->
        <div class="col-lg-3">
            <div class="card bg-white border shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="text-dark mb-4">Parça Ara</h5>
                    <form action="{{ route('parts.search') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" 
                                   class="form-control bg-light border" 
                                   name="q" 
                                   value="{{ request('q') }}"
                                   placeholder="Parça adı veya kodu...">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kategoriler -->
            <div class="card bg-white border shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="text-dark mb-4">Kategoriler</h5>
                    <div class="list-group">
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" 
                               class="list-group-item border mb-2 rounded d-flex justify-content-between align-items-center {{ request('category') == $category->slug ? 'active' : '' }}">
                                <span>
                                    <i class="fas {{ $category->icon ?? 'fa-folder' }} me-2"></i>
                                    {{ $category->name }}
                                </span>
                                <span class="badge bg-primary rounded-pill">{{ $category->parts_count ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Fiyat Filtresi -->
            <div class="card bg-white border shadow-sm">
                <div class="card-body">
                    <h5 class="text-dark mb-4">Fiyat Aralığı</h5>
                    <form action="{{ route('parts.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label text-secondary">Min Fiyat</label>
                            <input type="number" 
                                   class="form-control bg-light border" 
                                   name="min_price" 
                                   value="{{ request('min_price') }}"
                                   placeholder="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary">Max Fiyat</label>
                            <input type="number" 
                                   class="form-control bg-light border" 
                                   name="max_price" 
                                   value="{{ request('max_price') }}"
                                   placeholder="10000">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Uygula
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ana İçerik -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-dark mb-0">Tüm Parçalar</h1>
                <div class="d-flex align-items-center">
                    <select class="form-select bg-white border me-2" 
                            onchange="window.location.href = this.value">
                        <option value="{{ route('parts.index', ['sort' => 'latest']) }}" 
                                {{ request('sort') == 'latest' ? 'selected' : '' }}>En Yeni</option>
                        <option value="{{ route('parts.index', ['sort' => 'price_asc']) }}" 
                                {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Fiyat (Düşük > Yüksek)</option>
                        <option value="{{ route('parts.index', ['sort' => 'price_desc']) }}" 
                                {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Fiyat (Yüksek > Düşük)</option>
                        <option value="{{ route('parts.index', ['sort' => 'name_asc']) }}" 
                                {{ request('sort') == 'name_asc' ? 'selected' : '' }}>İsim (A-Z)</option>
                        <option value="{{ route('parts.index', ['sort' => 'name_desc']) }}" 
                                {{ request('sort') == 'name_desc' ? 'selected' : '' }}>İsim (Z-A)</option>
                    </select>
                </div>
            </div>

            <div class="row g-4">
                @forelse($parts as $part)
                <div class="col-md-4">
                    <div class="card bg-white h-100 border shadow-sm hover-scale">
                        <div class="position-relative">
                            <img src="{{ $part->image ? Storage::url($part->image) : asset('images/no-image.png') }}" 
                                 class="card-img-top" 
                                 alt="{{ $part->name }}"
                                 style="height: 200px; object-fit: cover;">
                            @if($part->condition == 'new')
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-success">Yeni</span>
                                </div>
                            @endif
                            @if($part->stock_quantity > 0)
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-primary">Stokta</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2">{{ $part->category->name }}</span>
                                <span class="badge bg-secondary">{{ $part->manufacturer }}</span>
                            </div>
                            <h5 class="card-title text-dark mb-2">{{ $part->name }}</h5>
                            <p class="card-text text-secondary small mb-3">{{ Str::limit($part->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-dark">
                                    <span class="fs-5 fw-bold">{{ number_format($part->price, 2) }}</span>
                                    <small class="text-secondary">TL</small>
                                </div>
                                <a href="{{ route('parts.show', $part->slug) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Detaylar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert bg-light border text-dark text-center py-4">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <h4>Henüz parça eklenmemiş</h4>
                        <p class="text-secondary mb-0">Aradığınız kriterlere uygun parça bulunamadı.</p>
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

<style>
.hover-scale {
    transition: transform 0.2s ease;
}

.hover-scale:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(227, 24, 55, 0.2);
}

.list-group-item {
    transition: all 0.2s ease;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    color: var(--text-primary);
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
}

.list-group-item:hover {
    background-color: var(--bg-primary);
}

.list-group-item.active {
    background-color: var(--primary-color) !important;
    border-color: var(--primary-color);
}

.form-control, .form-select {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border-radius: 0.5rem;
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
}

.form-control:focus, .form-select:focus {
    background-color: var(--bg-primary);
    border-color: var(--primary-color);
    color: var(--text-primary);
}

.card {
    border-radius: 1rem;
    overflow: hidden;
    background-color: var(--bg-secondary);
    border: 1px solid var(--border-color);
}

.card-body {
    color: var(--text-primary);
}

.text-dark {
    color: var(--text-primary) !important;
}

.text-secondary {
    color: var(--text-secondary) !important;
}

.bg-white {
    background-color: var(--bg-secondary) !important;
}

.bg-light {
    background-color: var(--bg-primary) !important;
}

.border {
    border-color: var(--border-color) !important;
}

.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
}

.pagination {
    --bs-pagination-bg: var(--bg-primary);
    --bs-pagination-border-color: var(--border-color);
    --bs-pagination-hover-bg: var(--bg-secondary);
    --bs-pagination-hover-border-color: var(--border-color);
    --bs-pagination-active-bg: var(--primary-color);
    --bs-pagination-active-border-color: var(--primary-color);
    --bs-pagination-disabled-bg: var(--bg-primary);
    --bs-pagination-disabled-border-color: var(--border-color);
}
</style>
@endsection 