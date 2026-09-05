@extends('layouts.admin')

@section('title', 'Siparişler')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-white">Siparişler</h1>
    </div>

    @if(session('success'))
        <div class="alert bg-dark border-success text-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gray-800">
            <h6 class="m-0 font-weight-bold text-primary">Tüm Siparişler</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if($orders->count() > 0)
                <table class="table table-bordered text-white border-secondary" width="100%" cellspacing="0">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="text-white">Sipariş #</th>
                            <th class="text-white">Müşteri</th>
                            <th class="text-white">Toplam Tutar</th>
                            <th class="text-white">Durumu</th>
                            <th class="text-white">Ödeme Durumu</th>
                            <th class="text-white">Tarih</th>
                            <th class="text-white">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="text-white">{{ $order->id }}</td>
                            <td class="text-white">{{ $order->user->name ?? 'Bilinmiyor' }}</td>
                            <td class="text-white">{{ number_format($order->total_amount, 2) }} TL</td>
                            <td>
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
                            </td>
                            <td>
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
                            <td class="text-white">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Görüntüle
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-gray-400 mb-3"></i>
                    <p class="text-gray-400 mb-0">Henüz sipariş bulunmuyor.</p>
                </div>
                @endif
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
</style>
@endpush
@endsection 