@extends('layouts.app')

@section('title', 'Favorilerim')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Profil Sidebar -->
        @include('profile.partials.sidebar')

        <!-- Favoriler İçeriği -->
        <div class="col-lg-9">
            <div class="card bg-dark border-0 rounded-lg shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-white mb-0">Favori Parçalarım</h4>
                    </div>

                    @if($favorites->count() > 0)
                        <div class="row g-4">
                            @foreach($favorites as $part)
                                @if($part && $part->exists)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card bg-gray-800 border-0 h-100">
                                        <div class="position-relative">
                                            <img src="{{ $part->image ? Storage::url($part->image) : asset('images/no-image.png') }}" 
                                                class="card-img-top" 
                                                alt="{{ $part->name ?? 'Parça' }}"
                                                style="height: 200px; object-fit: cover;">
                                            <form action="{{ route('profile.favorites.toggle', $part) }}" 
                                                method="POST" 
                                                class="position-absolute top-0 end-0 m-2">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm"
                                                        data-bs-toggle="tooltip"
                                                        title="Favorilerden Kaldır">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                @if(isset($part->category) && $part->category)
                                                    <span class="badge bg-primary me-2">{{ $part->category->name }}</span>
                                                @endif
                                                @if(isset($part->brand) && $part->brand)
                                                    <span class="badge bg-secondary">{{ $part->brand->name }}</span>
                                                @endif
                                            </div>
                                            <h5 class="card-title text-white">{{ $part->name ?? 'İsimsiz Parça' }}</h5>
                                            <p class="card-text text-gray-400">{{ Str::limit($part->description ?? 'Açıklama yok', 100) }}</p>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div class="text-white">
                                                    <span class="fs-5 fw-bold">{{ number_format($part->price ?? 0, 2) }}</span>
                                                    <small class="text-gray-400">TL</small>
                                                </div>
                                                @if(isset($part->slug) && $part->slug)
                                                <a href="{{ route('parts.show', $part->slug) }}" 
                                                class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye me-1"></i>İncele
                                                </a>
                                                @else
                                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                                    <i class="fas fa-eye-slash me-1"></i>Mevcut Değil
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $favorites->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-heart fa-3x text-gray-400 mb-3"></i>
                            <h5 class="text-white">Henüz favori parçanız bulunmuyor</h5>
                            <p class="text-gray-400">Beğendiğiniz parçaları favorilerinize ekleyerek daha sonra kolayca ulaşabilirsiniz.</p>
                            <a href="{{ route('parts.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Parçaları İncele
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Tooltip'leri etkinleştir
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})

// Favori işlemleri için AJAX
document.querySelectorAll('form[action*="favorites/toggle"]').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault()
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new FormData(this)
            })

            if (response.ok) {
                const card = this.closest('.col-md-6.col-lg-4')
                card.style.opacity = '0'
                setTimeout(() => {
                    card.remove()
                    if (document.querySelectorAll('.col-md-6.col-lg-4').length === 0) {
                        location.reload()
                    }
                }, 300)
            }
        } catch (error) {
            console.error('Bir hata oluştu:', error)
        }
    })
})
</script>
@endpush

@endsection