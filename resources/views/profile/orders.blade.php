@extends('layouts.app')

@section('title', 'Siparişlerim')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Profil Sidebar -->
        @include('profile.partials.sidebar')

        <!-- Siparişler İçeriği -->
        <div class="col-lg-9">
            <div class="card bg-dark border-0 rounded-lg shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-white mb-0">Siparişlerim</h4>
                    </div>

                    @forelse($orders as $order)
                        <div class="card bg-gray-800 border-0 mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <p class="text-gray-400 mb-1">Sipariş No</p>
                                        <h6 class="text-white">#{{ $order->id }}</h6>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="text-gray-400 mb-1">Tarih</p>
                                        <h6 class="text-white">{{ $order->created_at->format('d.m.Y') }}</h6>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="text-gray-400 mb-1">Durum</p>
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
                                    <div class="col-md-3 text-end">
                                        <a href="{{ route('profile.orders.show', $order->id) }}" class="btn btn-outline-light btn-sm">
                                            <i class="fas fa-eye me-1"></i>Detaylar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag fa-3x text-gray-400 mb-3"></i>
                            <h5 class="text-white">Henüz siparişiniz bulunmuyor</h5>
                            <p class="text-gray-400">Yedek parça kataloğumuza göz atarak alışverişe başlayabilirsiniz.</p>
                            <a href="{{ route('parts.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Parçaları İncele
                            </a>
                        </div>
                    @endforelse

                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-gray-800 {
    background-color: #1f2937;
}
.text-gray-400 {
    color: #9ca3af;
}
.btn-outline-light {
    color: #fff;
    border-color: #4b5563;
}
.btn-outline-light:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
}
/* Fix for pagination to ensure no white background */
.pagination {
    --bs-pagination-bg: #1f2937;
    --bs-pagination-color: #fff;
    --bs-pagination-border-color: #374151;
    --bs-pagination-hover-bg: #374151;
    --bs-pagination-hover-color: #fff;
    --bs-pagination-focus-bg: #374151;
    --bs-pagination-focus-color: #fff;
    --bs-pagination-active-bg: #e31837;
    --bs-pagination-active-border-color: #e31837;
    --bs-pagination-disabled-bg: #1f2937;
    --bs-pagination-disabled-color: #6c757d;
}
.page-item .page-link {
    background-color: #1f2937;
    border-color: #374151;
    color: #fff;
}
.page-item.active .page-link {
    background-color: #e31837;
    border-color: #e31837;
}
/* Fix for any form elements */
input, select, textarea {
    background-color: #1f2937 !important;
    border-color: #374151 !important;
    color: #fff !important;
}
/* Ensure all inputs in tables have dark backgrounds */
td input, td select, td textarea, 
th input, th select, th textarea {
    background-color: #1f2937 !important;
    border-color: #374151 !important;
    color: #fff !important;
}
</style>
@endpush

@endsection
