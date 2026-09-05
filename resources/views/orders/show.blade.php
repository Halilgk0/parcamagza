@extends('layouts.app')

@section('title', 'Sipariş Detayı #' . $order->id)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4 bg-dark border-0">
        <ol class="breadcrumb bg-dark border-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-secondary">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profile.orders') }}" class="text-secondary">Siparişlerim</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Sipariş #{{ $order->id }}</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert bg-dark border-success text-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Sipariş Detayları -->
            <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                <div class="card-header bg-dark border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-shopping-bag me-2"></i>Sipariş #{{ $order->id }}
                    </h5>
                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'cancelled' ? 'danger' : 'secondary'))) }}">
                        @if($order->status == 'completed')
                            Tamamlandı
                        @elseif($order->status == 'pending')
                            Beklemede
                        @elseif($order->status == 'processing')
                            İşleniyor
                        @elseif($order->status == 'cancelled')
                            İptal Edildi
                        @elseif($order->status == 'awaiting_payment')
                            Ödeme Bekleniyor
                        @else
                            {{ $order->status }}
                        @endif
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-white mb-3">Sipariş Bilgileri</h6>
                            <div class="card bg-gray-800 border border-secondary p-3">
                                <table class="table table-borderless table-sm text-gray-400 mb-0 bg-transparent">
                                    <tr>
                                        <td class="ps-0 py-1 border-0">Sipariş Tarihi:</td>
                                        <td class="text-white border-0">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0 py-1 border-0">Sipariş Numarası:</td>
                                        <td class="text-white border-0">{{ $order->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0 py-1 border-0">Ödeme Yöntemi:</td>
                                        <td class="text-white border-0">
                                            @if($order->payment_method == 'credit_card')
                                                Kredi Kartı
                                            @elseif($order->payment_method == 'bank_transfer')
                                                Banka Havalesi
                                            @else
                                                {{ $order->payment_method }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0 py-1 border-0">Ödeme Durumu:</td>
                                        <td class="border-0">
                                            <span class="badge bg-{{ $order->payment_status == 'completed' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : ($order->payment_status == 'failed' ? 'danger' : 'secondary')) }}">
                                                @if($order->payment_status == 'completed')
                                                    Ödendi
                                                @elseif($order->payment_status == 'pending')
                                                    Beklemede
                                                @elseif($order->payment_status == 'failed')
                                                    Başarısız
                                                @elseif($order->payment_status == 'refunded')
                                                    İade Edildi
                                                @else
                                                    {{ $order->payment_status }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-white mb-3">Teslimat Adresi</h6>
                            <div class="card bg-gray-800 border border-secondary p-3">
                                @if($order->address)
                                    <div class="mb-1 text-white">{{ $order->address->name }}</div>
                                    <div class="mb-1 text-white">{{ $order->address->phone }}</div>
                                    <div class="mb-1 text-white">{{ $order->address->address }}</div>
                                    <div class="text-white">{{ $order->address->district }}, {{ $order->address->city }}, {{ $order->address->postal_code }}</div>
                                @elseif($order->shipping_address)
                                    <div class="mb-1 text-white">{{ $order->shipping_address['name'] ?? '' }}</div>
                                    <div class="mb-1 text-white">{{ $order->shipping_address['phone'] ?? '' }}</div>
                                    <div class="mb-1 text-white">{{ $order->shipping_address['address'] ?? '' }}</div>
                                    <div class="text-white">{{ $order->shipping_address['district'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['postal_code'] ?? '' }}</div>
                                @else
                                    <div class="text-gray-400">Adres bilgisi mevcut değil</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h6 class="text-white mb-3">Sipariş Öğeleri</h6>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead class="bg-gray-800">
                                <tr>
                                    <th class="border-0 py-2 text-white">Ürün</th>
                                    <th class="border-0 py-2 text-center text-white">Fiyat</th>
                                    <th class="border-0 py-2 text-center text-white">Miktar</th>
                                    <th class="border-0 py-2 text-end text-white">Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="py-3 text-white">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->part->image ? Storage::url($item->part->image) : asset('images/no-image.png') }}" 
                                                 alt="{{ $item->part->name }}" 
                                                 class="rounded me-3 bg-dark border-secondary" 
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
                                    <td class="py-3 text-center text-white">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="py-3 text-end text-white">
                                        {{ number_format($item->price * $item->quantity, 2) }} TL
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-800">
                                <tr>
                                    <td colspan="3" class="text-end border-0">Ara Toplam:</td>
                                    <td class="text-end border-0">{{ number_format($order->total_amount - 30, 2) }} TL</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end border-0">Kargo:</td>
                                    <td class="text-end border-0">{{ number_format(30, 2) }} TL</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end border-0"><strong>Toplam:</strong></td>
                                    <td class="text-end border-0"><strong>{{ number_format($order->total_amount, 2) }} TL</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sipariş Notu -->
            @if($order->notes)
            <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                <div class="card-header bg-dark border-0 py-3">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-sticky-note me-2"></i>Sipariş Notu
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-gray-400 mb-0">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Sipariş Özeti -->
            <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-dark border-0 py-3">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Sipariş Özeti
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-gray-400">Ara Toplam:</span>
                        <span class="text-white">{{ number_format($order->total_amount - 30, 2) }} TL</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-gray-400">Kargo:</span>
                        <span class="text-white">{{ number_format(30, 2) }} TL</span>
                    </div>
                    <hr class="border-secondary my-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-white fw-bold">Toplam:</span>
                        <span class="text-primary fs-5 fw-bold">{{ number_format($order->total_amount, 2) }} TL</span>
                    </div>

                    @if($order->payment_method == 'bank_transfer' && $order->payment_status == 'pending')
                    <div class="alert bg-dark border-info text-info mb-4">
                        <h6 class="text-info mb-2"><i class="fas fa-info-circle me-2"></i>Havale Bilgileri</h6>
                        <p class="text-info mb-2">Lütfen aşağıdaki hesap bilgilerini kullanarak ödemenizi gerçekleştirin:</p>
                        <div class="mb-2">
                            <strong class="text-info">Parca Magaza A.Ş. - Ziraat Bankası</strong><br>
                            <span class="text-info">IBAN: TR12 3456 7890 1234 5678 9012 34</span>
                        </div>
                        <div>
                            <strong class="text-info">Parca Magaza A.Ş. - İş Bankası</strong><br>
                            <span class="text-info">IBAN: TR98 7654 3210 9876 5432 1098 76</span>
                        </div>
                        <p class="text-info mt-2 mb-0">Açıklama kısmına sipariş numaranızı ({{ $order->id }}) yazmayı unutmayın.</p>
                    </div>
                    @endif
                    
                    <div class="d-grid mt-4">
                        <a href="{{ route('profile.orders') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Siparişlerime Dön
                        </a>
                    </div>
                </div>
            </div>

            <!-- Yardım Kartı -->
            <div class="card bg-dark border-0 rounded-lg shadow-sm">
                <div class="card-body p-4">
                    <h5 class="text-white mb-3">Yardıma mı ihtiyacınız var?</h5>
                    <p class="text-gray-400 mb-4">Siparişinizle ilgili herhangi bir sorunuz varsa, müşteri hizmetleriyle iletişime geçebilirsiniz.</p>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-phone-alt fa-lg text-primary me-3"></i>
                        <span class="text-white">0850 123 45 67</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope fa-lg text-primary me-3"></i>
                        <span class="text-white">destek@parcamagaza.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.text-gray-400 {
    color: #9ca3af;
}
.border-secondary {
    border-color: #374151 !important;
}
.bg-gray-800 {
    background-color: #1f2937;
}
.hover-text-primary:hover {
    color: var(--primary-color) !important;
    text-decoration: underline !important;
}
.table-dark {
    --bs-table-bg: transparent;
    border-color: #374151;
}
.table-dark td {
    border-color: #374151;
}
/* Fix for breadcrumbs */
.breadcrumb {
    background-color: #2d2d2d !important;
}
.breadcrumb-item a {
    color: #9ca3af !important;
}
.breadcrumb-item.active {
    color: #fff !important;
}
/* Fix for Bootstrap elements */
.bg-white, .bg-body {
    background-color: #2d2d2d !important;
}
/* Fix for inputs and form elements */
input, select, textarea, .form-control, .form-select {
    background-color: #1f2937 !important;
    border-color: #374151 !important;
    color: #fff !important;
}
/* Fix for tables */
table, tr, td, th {
    background-color: transparent !important;
}
.table thead, .table tfoot {
    background-color: #1f2937 !important;
}
</style>
@endpush
@endsection 