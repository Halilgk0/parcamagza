@extends('layouts.app')

@section('title', 'Sepetim - Parca Magaza')

@section('content')
<div class="container py-5">
    <h1 class="text-white mb-4"><i class="fas fa-shopping-cart me-2"></i>Sepetim</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($cart->items->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-0 py-3 ps-4">Ürün</th>
                                        <th class="border-0 py-3 text-center">Fiyat</th>
                                        <th class="border-0 py-3 text-center">Miktar</th>
                                        <th class="border-0 py-3 text-center">Toplam</th>
                                        <th class="border-0 py-3 text-end pe-4">İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                    <tr class="cart-item" data-id="{{ $item->id }}">
                                        <td class="py-3 ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->part->image ? Storage::url($item->part->image) : asset('images/no-image.png') }}" 
                                                     alt="{{ $item->part->name }}" 
                                                     class="rounded me-3" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <h6 class="text-white mb-1">
                                                        <a href="{{ route('parts.show', $item->part->slug) }}" 
                                                           class="text-white text-decoration-none hover-text-primary">
                                                            {{ $item->part->name }}
                                                        </a>
                                                    </h6>
                                                    <div class="d-flex align-items-center small">
                                                        @if($item->part->category)
                                                            <span class="badge bg-primary me-2">{{ $item->part->category->name }}</span>
                                                        @endif
                                                        @if($item->part->brand)
                                                            <span class="badge bg-secondary">{{ $item->part->brand->name }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 text-center text-white">
                                            {{ number_format($item->price, 2) }} TL
                                        </td>
                                        <td class="py-3 text-center">
                                            <div class="quantity-control d-flex align-items-center justify-content-center">
                                                <button class="btn btn-sm btn-outline-secondary quantity-decrease">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" 
                                                       min="1" 
                                                       max="{{ $item->part->stock_quantity }}" 
                                                       value="{{ $item->quantity }}" 
                                                       class="form-control form-control-sm mx-2 bg-dark text-white text-center quantity-input" 
                                                       style="width: 60px;" 
                                                       data-url="{{ route('cart.update', $item) }}">
                                                <button class="btn btn-sm btn-outline-secondary quantity-increase">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="py-3 text-center text-white item-subtotal">
                                            {{ number_format($item->price * $item->quantity, 2) }} TL
                                        </td>
                                        <td class="py-3 text-end pe-4">
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline remove-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash me-1"></i>Kaldır
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('parts.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Alışverişe Devam Et
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash me-2"></i>Sepeti Temizle
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                    <div class="card-header bg-dark border-0 py-3">
                        <h5 class="card-title text-white mb-0">
                            <i class="fas fa-calculator me-2"></i>Sipariş Özeti
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-gray-400">Ara Toplam:</span>
                            <span class="text-white" id="cart-subtotal">{{ number_format($cart->total(), 2) }} TL</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-gray-400">Kargo:</span>
                            <span class="text-white">{{ number_format(30, 2) }} TL</span>
                        </div>
                        <hr class="border-gray-700 my-3">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-white fw-bold">Toplam:</span>
                            <span class="text-primary fs-5 fw-bold" id="cart-total">{{ number_format($cart->total() + 30, 2) }} TL</span>
                        </div>
                        <div class="d-grid">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-check me-2"></i>Siparişi Tamamla
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card bg-dark border-0 rounded-lg shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-truck fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="text-white mb-1">Hızlı Teslimat</h6>
                                <p class="text-gray-400 mb-0 small">24 saat içinde kargoya teslim</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-shield-alt fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="text-white mb-1">Güvenli Ödeme</h6>
                                <p class="text-gray-400 mb-0 small">256-bit SSL güvenlik sertifikası</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exchange-alt fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="text-white mb-1">Kolay İade</h6>
                                <p class="text-gray-400 mb-0 small">14 gün içinde koşulsuz iade</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card bg-dark border-0 rounded-lg shadow-sm">
            <div class="card-body p-5 text-center">
                <div class="empty-cart mb-4">
                    <i class="fas fa-shopping-cart fa-5x text-gray-400 mb-3"></i>
                    <h3 class="text-white">Sepetiniz Boş</h3>
                    <p class="text-gray-400">Sepetinizde henüz ürün bulunmuyor.</p>
                </div>
                <a href="{{ route('parts.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-search me-2"></i>Ürünleri Keşfedin
                </a>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
.text-gray-400 {
    color: #9ca3af;
}
.border-gray-700 {
    border-color: #374151;
}
.hover-text-primary:hover {
    color: var(--primary-color) !important;
    text-decoration: underline !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Miktar artırma ve azaltma butonları
    document.querySelectorAll('.quantity-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.nextElementSibling;
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateCartItem(input);
            }
        });
    });

    document.querySelectorAll('.quantity-increase').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const currentValue = parseInt(input.value);
            const maxValue = parseInt(input.getAttribute('max'));
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
                updateCartItem(input);
            }
        });
    });

    // Miktar inputu değişince
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            updateCartItem(this);
        });
    });

    // Ürün kaldırma formu
    document.querySelectorAll('.remove-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const cartItem = this.closest('.cart-item');
            
            fetch(this.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Ürünü animasyonla kaldır
                    cartItem.style.opacity = '0';
                    setTimeout(() => {
                        cartItem.remove();
                        
                        // Sepet toplamını güncelle
                        document.getElementById('cart-subtotal').textContent = formatPrice(data.cart_total) + ' TL';
                        document.getElementById('cart-total').textContent = formatPrice(data.cart_total + 30) + ' TL';
                        
                        // Sepet boşsa sayfayı yenile
                        if (data.cart_count === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            })
            .catch(error => console.error('Bir hata oluştu:', error));
        });
    });

    // Cart item miktarını güncelle
    function updateCartItem(input) {
        const url = input.getAttribute('data-url');
        const quantity = parseInt(input.value);
        const cartItem = input.closest('.cart-item');
        
        fetch(url, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Alt toplamı güncelle
                cartItem.querySelector('.item-subtotal').textContent = formatPrice(data.subtotal) + ' TL';
                
                // Sepet toplamını güncelle
                document.getElementById('cart-subtotal').textContent = formatPrice(data.cart_total) + ' TL';
                document.getElementById('cart-total').textContent = formatPrice(data.cart_total + 30) + ' TL';
            }
        })
        .catch(error => console.error('Bir hata oluştu:', error));
    }

    // Fiyat formatla
    function formatPrice(price) {
        return new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(price);
    }
});
</script>
@endpush
@endsection 