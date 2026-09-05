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

                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Sipariş No</th>
                                        <th>Tarih</th>
                                        <th>Tutar</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d.m.Y') }}</td>
                                            <td>{{ number_format($order->total_amount, 2) }} TL</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                                    {{ $order->status === 'completed' ? 'Tamamlandı' : 'Beklemede' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show', $order) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i> Detay
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag fa-3x text-gray-400 mb-3"></i>
                            <h5 class="text-white">Henüz siparişiniz bulunmuyor</h5>
                            <p class="text-gray-400">Mağazamızdan alışveriş yaparak siparişlerinizi buradan takip edebilirsiniz.</p>
                            <a href="{{ route('parts.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart me-2"></i>Alışverişe Başla
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 