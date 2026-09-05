@extends('layouts.app')

@section('title', $part->name . ' - Parca Magaza')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-secondary hover:text-dark">
                    <i class="fas fa-home me-1"></i>Anasayfa
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('parts.index') }}" class="text-secondary hover:text-dark">
                    Parçalar
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('categories.show', $part->category->slug) }}" class="text-secondary hover:text-dark">
                    {{ $part->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active text-dark" aria-current="page">
                {{ $part->name }}
            </li>
        </ol>
    </nav>

    <div class="row">
        <!-- Parça Detayları -->
        <div class="col-lg-8">
            <div class="card bg-white border shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-relative mb-4">
                                <img src="{{ $part->image ? Storage::url($part->image) : asset('images/no-image.png') }}" 
                                     class="img-fluid rounded-3" 
                                     alt="{{ $part->name }}"
                                     style="width: 100%; height: 300px; object-fit: cover;">
                                @if($part->condition == 'new')
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-success">Yeni</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h1 class="text-dark mb-3">{{ $part->name }}</h1>
                            
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-primary me-2">{{ $part->category->name }}</span>
                                @if($part->manufacturer)
                                    <span class="badge bg-secondary">{{ $part->manufacturer }}</span>
                                @endif
                            </div>

                            <p class="text-secondary mb-4">{{ $part->description }}</p>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-barcode text-primary me-2"></i>
                                    <span class="text-dark">Parça Numarası:</span>
                                    <span class="text-secondary ms-2">{{ $part->part_number }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-box text-primary me-2"></i>
                                    <span class="text-dark">Stok Durumu:</span>
                                    <span class="badge {{ $part->stock_quantity > 0 ? 'bg-success' : 'bg-danger' }} ms-2">
                                        {{ $part->stock_quantity > 0 ? 'Stokta' : 'Stokta Yok' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tag text-primary me-2"></i>
                                    <span class="text-dark">Fiyat:</span>
                                    <span class="text-primary fw-bold fs-4 ms-2">
                                        {{ number_format($part->price, 2) }} TL
                                    </span>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                @if($part->stock_quantity > 0)
                                    @auth
                                        <form action="{{ route('cart.add', $part) }}" method="POST" id="addToCartForm">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-lg w-100" id="addToCartBtn">
                                                <i class="fas fa-shopping-cart me-2"></i>Sepete Ekle
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-shopping-cart me-2"></i>Sepete Ekle
                                        </a>
                                    @endauth
                                @else
                                    <button class="btn btn-secondary btn-lg" disabled>
                                        <i class="fas fa-exclamation-circle me-2"></i>Stokta Yok
                                    </button>
                                @endif
                                
                                @auth
                                    <form action="{{ route('profile.favorites.toggle', $part->id) }}" method="POST" id="favoriteForm">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-secondary w-100" id="favoriteBtn">
                                            @if(auth()->user()->favorites()->where('part_id', $part->id)->exists())
                                                <i class="fas fa-heart me-2 text-danger"></i>Favorilerden Çıkar
                                            @else
                                                <i class="far fa-heart me-2"></i>Favorilere Ekle
                                            @endif
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                        <i class="far fa-heart me-2"></i>Favorilere Ekle
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teknik Özellikler -->
            @if($part->specifications)
            <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                <div class="card-header bg-dark border-0 py-3">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-cogs me-2"></i>Teknik Özellikler
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        @foreach($part->specifications as $key => $value)
                        <div class="col-md-6">
                            <div class="spec-item p-3 rounded-3" style="background-color: rgba(255, 255, 255, 0.05);">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="spec-icon me-3 d-flex align-items-center justify-content-center rounded-circle" 
                                         style="width: 40px; height: 40px; background-color: var(--primary-color);">
                                        <i class="fas fa-circle-info text-white"></i>
                                    </div>
                                    <h6 class="spec-title text-white mb-0">{{ $key }}</h6>
                                </div>
                                <div class="ps-5">
                                    <p class="spec-value text-gray-400 mb-0">{{ $value }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Uyumlu Modeller -->
            @if($part->compatibleModels->count() > 0)
            <div class="card bg-white border shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="text-dark mb-0">
                        <i class="fas fa-car me-2"></i>Uyumlu Araçlar
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($part->compatibleModels as $model)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <i class="fas fa-check-circle text-success me-3"></i>
                                <div>
                                    <h6 class="text-dark mb-1">{{ $model->brand->name }} {{ $model->name }}</h6>
                                    @if($model->year_start || $model->year_end)
                                    <small class="text-secondary">
                                        {{ $model->year_start ?? '?' }} - {{ $model->year_end ?? 'Günümüz' }}
                                    </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sağ Sidebar -->
        <div class="col-lg-4">
            <!-- Benzer Parçalar -->
            @if($relatedParts->count() > 0)
            <div class="card bg-white border shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h4 class="text-dark mb-0">
                        <i class="fas fa-layer-group me-2"></i>Benzer Parçalar
                    </h4>
                </div>
                <div class="card-body">
                    @foreach($relatedParts as $relatedPart)
                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded-3">
                        <img src="{{ $relatedPart->image ? Storage::url($relatedPart->image) : asset('images/no-image.png') }}" 
                             alt="{{ $relatedPart->name }}"
                             class="rounded-3 me-3"
                             style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h6 class="text-dark mb-2">
                                <a href="{{ route('parts.show', $relatedPart->slug) }}" 
                                   class="text-dark text-decoration-none hover:text-primary">
                                    {{ $relatedPart->name }}
                                </a>
                            </h6>
                            <div class="text-primary fw-bold mb-2">
                                {{ number_format($relatedPart->price, 2) }} TL
                            </div>
                            <a href="{{ route('parts.show', $relatedPart->slug) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i>İncele
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Garanti ve İade -->
            <div class="card bg-white border shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-shield-alt fa-2x text-primary me-3"></i>
                        <div>
                            <h5 class="text-dark mb-1">2 Yıl Garanti</h5>
                            <p class="text-secondary mb-0">Tüm parçalarımız 2 yıl garantilidir.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-exchange-alt fa-2x text-primary me-3"></i>
                        <div>
                            <h5 class="text-dark mb-1">14 Gün İade</h5>
                            <p class="text-secondary mb-0">14 gün içinde ücretsiz iade hakkı.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-truck fa-2x text-primary me-3"></i>
                        <div>
                            <h5 class="text-dark mb-1">Hızlı Teslimat</h5>
                            <p class="text-secondary mb-0">24 saat içinde kargoya teslim.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.breadcrumb-item + .breadcrumb-item::before {
    color: var(--text-secondary);
}

.hover\:text-dark:hover {
    color: var(--text-primary) !important;
}

.hover\:text-primary:hover {
    color: var(--primary-color) !important;
}

.bg-light {
    background-color: var(--bg-primary) !important;
}

.card {
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

.border {
    border-color: var(--border-color) !important;
}

.breadcrumb-item a {
    color: var(--text-secondary);
}

.breadcrumb-item a:hover {
    color: var(--primary-color);
}

.breadcrumb-item.active {
    color: var(--text-primary);
}

.table {
    color: var(--text-primary);
}

.table th {
    background-color: var(--bg-primary);
    color: var(--text-primary);
}

.table td {
    color: var(--text-secondary);
}

.table-hover tbody tr:hover {
    background-color: var(--bg-primary);
}

.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
}

.btn-outline-secondary {
    color: var(--secondary-color);
    border-color: var(--secondary-color);
}

.btn-outline-secondary:hover {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
    color: var(--text-light);
}

.text-gray-400 {
    color: #9ca3af;
}
</style>

@push('scripts')
<script>
@auth
// Sepete ekleme formunu AJAX ile işle
document.getElementById('addToCartForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const button = document.getElementById('addToCartBtn');
    const originalText = button.innerHTML;
    
    // Buton durumunu güncelle
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Ekleniyor...';
    
    try {
        const formData = new FormData(this);
        
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();
        
        if (data.success) {
            // Başarılı mesajı göster
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: data.message,
                background: '#1a1a1a',
                color: '#fff'
            });
            
            // Buton durumunu güncelle
            button.innerHTML = '<i class="fas fa-check me-2"></i>Sepete Eklendi';
            
            // 2 saniye sonra butonu eski haline getir
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = originalText;
            }, 2000);
        } else {
            // Hata mesajı göster
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'error',
                title: data.message,
                background: '#1a1a1a',
                color: '#fff'
            });
            
            // Butonu eski haline getir
            button.disabled = false;
            button.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Bir hata oluştu:', error);
        
        // Butonu eski haline getir
        button.disabled = false;
        button.innerHTML = originalText;
    }
});

// Favori işlemi için AJAX
document.getElementById('favoriteForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    try {
        const formData = new FormData(this);
        
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        if (response.ok) {
            const data = await response.json();
            const favoriteBtn = document.getElementById('favoriteBtn');
            
            if (data.message.includes('eklendi')) {
                favoriteBtn.innerHTML = '<i class="fas fa-heart me-2 text-danger"></i>Favorilerden Çıkar';
            } else {
                favoriteBtn.innerHTML = '<i class="far fa-heart me-2"></i>Favorilere Ekle';
            }
            
            // Toast mesajı göster
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: 'success',
                title: data.message,
                background: '#1a1a1a',
                color: '#fff'
            });
        }
    } catch (error) {
        console.error('Bir hata oluştu:', error);
    }
});
@endauth
</script>
@endpush
@endsection 