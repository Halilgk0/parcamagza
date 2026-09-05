@extends('layouts.admin')

@section('title', 'Sipariş Detayı #' . $order->id)

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Panel</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Siparişler</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sipariş #{{ $order->id }}</li>
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
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Sipariş #{{ $order->id }} Detayı</h6>
                    <div>
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
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold mb-3 text-white">Sipariş Bilgileri</h6>
                            <div class="bg-dark border border-secondary rounded p-3">
                                <table class="table table-sm text-white border-secondary mb-0">
                                    <tr>
                                        <td class="border-0">Sipariş Tarihi:</td>
                                        <td class="border-0"><strong>{{ $order->created_at->format('d.m.Y H:i') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="border-0">Sipariş Numarası:</td>
                                        <td class="border-0"><strong>{{ $order->id }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="border-0">Ödeme Yöntemi:</td>
                                        <td class="border-0">
                                            <strong>
                                            @if($order->payment_method == 'credit_card')
                                                Kredi Kartı
                                            @elseif($order->payment_method == 'bank_transfer')
                                                Banka Havalesi
                                            @else
                                                {{ $order->payment_method }}
                                            @endif
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0">Ödeme Durumu:</td>
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
                            <h6 class="font-weight-bold mb-3 text-white">Müşteri Bilgileri</h6>
                            <div class="bg-dark border border-secondary rounded p-3">
                                <table class="table table-sm text-white border-secondary mb-0">
                                    <tr>
                                        <td class="border-0">Ad Soyad:</td>
                                        <td class="border-0">
                                            <strong>
                                                <a href="{{ route('admin.users.edit', $order->user->id) }}" class="text-primary">
                                                    {{ $order->user->name }}
                                                </a>
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-0">E-posta:</td>
                                        <td class="border-0"><strong>{{ $order->user->email }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="border-0">Telefon:</td>
                                        <td class="border-0"><strong>{{ $order->user->phone ?? 'Belirtilmemiş' }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="font-weight-bold mb-3 text-white">Teslimat Adresi</h6>
                            @if($order->address)
                                <div class="p-3 bg-dark border border-secondary rounded">
                                    <p class="mb-1 text-white"><strong>{{ $order->address->name }}</strong></p>
                                    <p class="mb-1 text-white">{{ $order->address->phone }}</p>
                                    <p class="mb-1 text-white">{{ $order->address->address }}</p>
                                    <p class="mb-0 text-white">{{ $order->address->district }}, {{ $order->address->city }}, {{ $order->address->postal_code }}</p>
                                </div>
                            @elseif($order->shipping_address)
                                <div class="p-3 bg-dark border border-secondary rounded">
                                    <p class="mb-1 text-white"><strong>{{ $order->shipping_address['name'] ?? '' }}</strong></p>
                                    <p class="mb-1 text-white">{{ $order->shipping_address['phone'] ?? '' }}</p>
                                    <p class="mb-1 text-white">{{ $order->shipping_address['address'] ?? '' }}</p>
                                    <p class="mb-0 text-white">{{ $order->shipping_address['district'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['postal_code'] ?? '' }}</p>
                                </div>
                            @else
                                <p class="text-muted">Adres bilgisi mevcut değil</p>
                            @endif
                        </div>
                    </div>

                    <h6 class="font-weight-bold mb-3 text-white">Sipariş Öğeleri</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered text-white border-secondary">
                            <thead>
                                <tr>
                                    <th class="text-white">Ürün</th>
                                    <th class="text-center text-white">Fiyat</th>
                                    <th class="text-center text-white">Miktar</th>
                                    <th class="text-end text-white">Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="text-white">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->part->image ? Storage::url($item->part->image) : asset('images/no-image.png') }}" 
                                                 alt="{{ $item->part->name }}" 
                                                 class="img-thumbnail me-3 bg-dark border-secondary" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('admin.parts.edit', $item->part->id) }}" class="text-white">
                                                        {{ $item->part->name }}
                                                    </a>
                                                </h6>
                                                <div class="small">
                                                    @if($item->part->category)
                                                        <span class="badge bg-primary me-1">{{ $item->part->category->name }}</span>
                                                    @endif
                                                    @if($item->part->brand)
                                                        <span class="badge bg-secondary">{{ $item->part->brand->name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-white">
                                        {{ number_format($item->price, 2) }} TL
                                    </td>
                                    <td class="text-center text-white">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="text-end text-white">
                                        {{ number_format($item->price * $item->quantity, 2) }} TL
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">Ara Toplam:</td>
                                    <td class="text-end">{{ number_format($order->total_amount - 30, 2) }} TL</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Kargo:</td>
                                    <td class="text-end">30.00 TL</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Toplam:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($order->total_amount, 2) }} TL</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                    <div class="mt-4">
                        <h6 class="font-weight-bold mb-2 text-white">Sipariş Notu</h6>
                        <div class="p-3 bg-dark border border-secondary rounded">
                            <p class="mb-0 text-white">{{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Durum Güncelleme -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sipariş Durumu Güncelle</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="status" class="form-label text-white">Sipariş Durumu</label>
                            <select class="form-select bg-dark text-white border-secondary" id="status" name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Beklemede</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>İşleniyor</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>İptal Edildi</option>
                                <option value="awaiting_payment" {{ $order->status == 'awaiting_payment' ? 'selected' : '' }}>Ödeme Bekleniyor</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="payment_status" class="form-label text-white">Ödeme Durumu</label>
                            <select class="form-select bg-dark text-white border-secondary" id="payment_status" name="payment_status">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Beklemede</option>
                                <option value="completed" {{ $order->payment_status == 'completed' ? 'selected' : '' }}>Ödendi</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Başarısız</option>
                                <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>İade Edildi</option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Durumu Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hızlı İşlemler -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hızlı İşlemler</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $order->user->email }}" class="btn btn-info">
                            <i class="fas fa-envelope me-1"></i> Müşteriye E-posta Gönder
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-1"></i> Siparişlere Dön
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 