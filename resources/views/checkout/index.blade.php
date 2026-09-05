@extends('layouts.app')

@section('title', 'Ödeme')

@section('meta')
<meta name="robots" content="noindex, nofollow">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="address=no">
<meta name="format-detection" content="email=no">
<meta name="autocomplete" content="off">
@endsection

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-secondary">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-secondary">Sepetim</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Ödeme</li>
        </ol>
    </nav>

    <!-- Ödeme Formu -->
    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Adres Seçimi -->
                <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                    <div class="card-header bg-dark border-0 py-3">
                        <h5 class="card-title text-white mb-0">
                            <i class="fas fa-map-marker-alt me-2"></i>Teslimat Adresi
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($addresses->count() > 0)
                            <div class="row g-3">
                                @foreach($addresses as $address)
                                <div class="col-md-6">
                                    <div class="card bg-gray-800 border border-secondary p-3 h-100">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="address_id" id="address_{{ $address->id }}" value="{{ $address->id }}" {{ $loop->first ? 'checked' : '' }}>
                                            <label class="form-check-label text-white fw-bold" for="address_{{ $address->id }}">
                                                {{ $address->title }}
                                            </label>
                                        </div>
                                        <div class="ms-4 text-gray-400">
                                            <p class="mb-1">{{ $address->name }}</p>
                                            <p class="mb-1">{{ $address->phone }}</p>
                                            <p class="mb-1">{{ $address->address }}</p>
                                            <p class="mb-0">{{ $address->district }}, {{ $address->city }}, {{ $address->postal_code }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-3 text-end">
                                <a href="{{ route('profile.addresses') }}" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-plus me-1"></i>Yeni Adres Ekle
                                </a>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-map-marker-alt fa-3x text-gray-400 mb-3"></i>
                                <h5 class="text-white">Kayıtlı adresiniz bulunmuyor</h5>
                                <p class="text-gray-400 mb-4">Sipariş verebilmek için lütfen bir teslimat adresi ekleyin.</p>
                                <a href="{{ route('profile.addresses') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Adres Ekle
                                </a>
                            </div>
                        @endif

                        @error('address_id')
                            <div class="alert bg-dark border-danger text-danger mt-3">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Ödeme Yöntemi -->
                <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                    <div class="card-header bg-dark border-0 py-3">
                        <h5 class="card-title text-white mb-0">
                            <i class="fas fa-credit-card me-2"></i>Ödeme Yöntemi
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Payment Method Selector Buttons -->
                        <div class="payment-method-tabs d-flex mb-4">
                            <div class="payment-method-button me-3">
                                <input type="radio" class="btn-check" name="payment_method" id="credit_card" value="credit_card" checked>
                                <label class="btn btn-outline-light px-4 py-3" for="credit_card">
                                    <i class="far fa-credit-card me-2"></i>Kredi Kartı
                                </label>
                            </div>
                            <div class="payment-method-button">
                                <input type="radio" class="btn-check" name="payment_method" id="bank_transfer" value="bank_transfer">
                                <label class="btn btn-outline-light px-4 py-3" for="bank_transfer">
                                    <i class="fas fa-university me-2"></i>Banka Havalesi
                                </label>
                            </div>
                        </div>
                        
                        <!-- Credit Card Animation Container -->
                        <div id="credit-card-container" class="payment-method-content">
                            <div class="card-wrapper mb-4"></div>
                            
                            <div class="card bg-gray-800 border border-secondary p-3">
                                <div class="text-gray-400 mb-3">
                                    <i class="fas fa-lock me-1 text-success"></i> Kredi kartı ile güvenli ödeme
                                </div>
                                
                                <div id="credit-card-form">
                                    <div class="mb-3">
                                        <label for="card_number" class="form-label text-gray-400 small">Kart Numarası</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-gray-700 border-secondary">
                                                <i class="far fa-credit-card text-gray-400"></i>
                                            </span>
                                            <input type="text" class="form-control bg-gray-700 border-secondary text-white" id="card_number" name="card_number" placeholder="•••• •••• •••• ••••">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="card_holder" class="form-label text-gray-400 small">Kart Sahibi</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-gray-700 border-secondary">
                                                    <i class="far fa-user text-gray-400"></i>
                                                </span>
                                                <input type="text" class="form-control bg-gray-700 border-secondary text-white" id="card_holder" name="card_holder" placeholder="AD SOYAD">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-3">
                                            <label for="card_expiry" class="form-label text-gray-400 small">Son Kullanma</label>
                                            <input type="text" class="form-control bg-gray-700 border-secondary text-white" id="card_expiry" name="card_expiry" placeholder="AA/YY">
                                        </div>
                                        <div class="col-6 col-md-3 mb-3">
                                            <label for="card_cvv" class="form-label text-gray-400 small">CVV</label>
                                            <input type="text" class="form-control bg-gray-700 border-secondary text-white" id="card_cvv" name="card_cvv" placeholder="•••">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bank Transfer Container -->
                        <div id="bank-transfer-container" class="payment-method-content" style="display:none;">
                            <div class="card bg-gray-800 border border-secondary p-3">
                                <div class="text-gray-400 mb-3">
                                    <i class="fas fa-info-circle me-1 text-info"></i> Hesabımıza havale yaparak ödeme
                                </div>
                                <div class="bank-details p-3 bg-gray-700 border border-secondary rounded mb-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://cdn.jsdelivr.net/npm/bank-logos@1.0.0/banks/tr/ziraat.svg" alt="Ziraat" class="bank-logo me-2" style="height: 24px;">
                                        <strong class="text-white">Parca Magaza A.Ş. - Ziraat Bankası</strong>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-dark text-gray-400 me-2">IBAN</span>
                                        <span class="text-white font-monospace small">TR12 3456 7890 1234 5678 9012 34</span>
                                        <button type="button" class="btn btn-sm btn-link ms-auto p-0 text-gray-400 copy-iban" title="IBAN'ı Kopyala">
                                            <i class="far fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="alert alert-dark bg-dark border-warning text-warning p-2 small mb-0">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Havale açıklamasına sipariş numarası yazılmalıdır.
                                </div>
                            </div>
                        </div>

                        @error('payment_method')
                            <div class="alert bg-dark border-danger text-danger mt-3">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Sipariş Notu -->
                <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                    <div class="card-header bg-dark border-0 py-3">
                        <h5 class="card-title text-white mb-0">
                            <i class="fas fa-sticky-note me-2"></i>Sipariş Notu
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <textarea class="form-control bg-gray-700 border-secondary text-white" name="notes" rows="3" placeholder="Siparişiniz için eklemek istediğiniz notlar..."></textarea>
                    </div>
                </div>

                <!-- Sözleşme Onayı -->
                <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms">
                            <label class="form-check-label text-gray-400" for="terms">
                                <a href="#" class="text-primary">Mesafeli satış sözleşmesini</a> ve <a href="#" class="text-primary">gizlilik politikasını</a> okudum ve kabul ediyorum.
                            </label>
                        </div>
                        @error('terms')
                            <div class="alert bg-dark border-danger text-danger mt-3">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sipariş Özeti -->
            <div class="col-lg-4">
                <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header bg-dark border-0 py-3">
                        <h5 class="card-title text-white mb-0">
                            <i class="fas fa-shopping-cart me-2"></i>Sipariş Özeti
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            @foreach($cart->items as $item)
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ $item->part->image ? Storage::url($item->part->image) : asset('images/no-image.png') }}" 
                                         alt="{{ $item->part->name }}" 
                                         class="rounded me-3" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="text-white mb-0">{{ $item->part->name }}</h6>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-gray-400">{{ $item->quantity }} adet</span>
                                            <span class="text-white">{{ number_format($item->price * $item->quantity, 2) }} TL</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-gray-400">Ara Toplam:</span>
                            <span class="text-white">{{ number_format($cart->total(), 2) }} TL</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-400">Kargo:</span>
                            <span class="text-white">30.00 TL</span>
                        </div>

                        <hr class="border-secondary my-3">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="text-white fw-bold">Toplam:</span>
                            <span class="text-primary fs-5 fw-bold">{{ number_format($cart->total() + 30, 2) }} TL</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-lock me-2"></i>Siparişi Onayla
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-light">
                                <i class="fas fa-arrow-left me-2"></i>Sepete Dön
                            </a>
                        </div>

                        <div class="alert bg-dark border-info text-info mt-4 mb-0">
                            <i class="fas fa-info-circle me-2"></i>Bu form geliştirme ortamında çalışmaktadır. Gerçek ödeme işlemi gerçekleştirilmeyecektir.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/card@2.5.4/dist/card.min.css">
<style>
.bg-gray-700 {
    background-color: #374151;
}
.bg-gray-800 {
    background-color: #1f2937;
}
.text-gray-400 {
    color: #9ca3af;
}
.border-secondary {
    border-color: #374151 !important;
}
.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
.form-control::placeholder {
    color: #6c757d;
    opacity: 0.5;
}

/* Credit Card styles */
.card-wrapper {
    margin-bottom: 2rem;
    width: 100%;
    max-width: 350px;
    margin-left: auto;
    margin-right: auto;
}

.jp-card-container {
    perspective: 1000px;
    transform-style: preserve-3d;
}

.jp-card {
    box-shadow: 0 10px 20px rgba(0,0,0,0.5) !important;
    transition: all 0.5s ease;
}

.jp-card .jp-card-front,
.jp-card .jp-card-back {
    background: linear-gradient(135deg, #434343, #000000) !important;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.3);
}

.jp-card .jp-card-front .jp-card-lower .jp-card-number {
    color: #fff !important;
    text-shadow: 0 2px 3px rgba(0,0,0,0.4);
    font-weight: bold;
}

.jp-card .jp-card-front .jp-card-lower .jp-card-name {
    color: #eee !important;
    font-weight: bold;
}

.jp-card .jp-card-front .jp-card-lower .jp-card-expiry {
    color: #ddd !important;
}

/* Custom Card Logo */
.jp-card .jp-card-front .jp-card-logo {
    top: 20px;
}

/* Change focus color for fields */
.jp-card.jp-card-focused {
    box-shadow: 0 15px 30px rgba(227, 24, 55, 0.3) !important;
}

/* Card brand logo styling */
.jp-card .jp-card-front .jp-card-logo.jp-card-visa,
.jp-card .jp-card-front .jp-card-logo.jp-card-mastercard,
.jp-card .jp-card-front .jp-card-logo.jp-card-amex {
    opacity: 0.9;
    filter: drop-shadow(0 2px 2px rgba(0,0,0,0.3));
}

/* Payment Method Styling */
.payment-method-tabs {
    border-bottom: 1px solid #374151;
    padding-bottom: 1rem;
}

.btn-check:checked + .btn-outline-light {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.payment-method-button .btn {
    border-radius: 0.5rem;
    font-weight: 500;
    border-width: 2px;
    transition: all 0.3s ease;
}

.payment-method-button .btn:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.payment-method-content {
    margin-top: 1.5rem;
    transition: all 0.3s ease;
}

.payment-icon {
    height: 24px;
    width: auto;
    margin-left: 5px;
    filter: drop-shadow(0 2px 3px rgba(0,0,0,0.2));
}

.copy-iban:hover {
    color: var(--primary-color) !important;
}

.input-group-text {
    color: #9ca3af;
}

/* Make the form elements have consistent height */
.input-group .form-control {
    height: 40px;
}

.btn-outline-light {
    color: #fff;
    border-color: #4b5563;
}

.bank-logo {
    filter: brightness(0) invert(1);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/card@2.5.4/dist/card.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Credit Card animation
    const card = new Card({
        form: document.getElementById('checkout-form'),
        container: '.card-wrapper',
        formSelectors: {
            numberInput: 'input#card_number',
            nameInput: 'input#card_holder',
            expiryInput: 'input#card_expiry',
            cvcInput: 'input#card_cvv'
        },
        width: 350, // Larger width for better visibility
        // Custom placeholders
        placeholders: {
            number: '•••• •••• •••• ••••',
            name: 'AD SOYAD',
            expiry: 'AA/YY',
            cvc: '•••'
        },
        // Custom classes for animations
        classes: {
            valid: 'is-valid',
            invalid: 'is-invalid'
        },
        // Custom card icons
        messages: {
            validDate: 'GEÇERLİ\nTARİH',
            monthYear: 'AA/YY'
        }
    });
    
    // Payment method toggle
    const paymentMethod = document.querySelectorAll('input[name="payment_method"]');
    const creditCardContainer = document.getElementById('credit-card-container');
    const bankTransferContainer = document.getElementById('bank-transfer-container');
    
    // Initial check for payment method
    function updatePaymentMethod() {
        if (document.getElementById('credit_card').checked) {
            creditCardContainer.style.display = 'block';
            bankTransferContainer.style.display = 'none';
            
            // Trigger animation effect when switching to credit card
            setTimeout(() => {
                card.animateTo({
                    name: 'AD SOYAD'
                });
            }, 100);
        } else {
            creditCardContainer.style.display = 'none';
            bankTransferContainer.style.display = 'block';
        }
    }
    
    // Initial state
    updatePaymentMethod();
    
    // Add event listeners to payment method radios
    paymentMethod.forEach(radio => {
        radio.addEventListener('change', updatePaymentMethod);
    });
    
    // Format card number with spaces
    const cardNumberInput = document.getElementById('card_number');
    cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 16) value = value.slice(0, 16);
        
        // Format with spaces
        let formattedValue = '';
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) formattedValue += ' ';
            formattedValue += value[i];
        }
        
        e.target.value = formattedValue;
    });
    
    // Format expiry date with slash
    const expiryInput = document.getElementById('card_expiry');
    expiryInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);
        
        if (value.length > 2) {
            e.target.value = value.slice(0, 2) + '/' + value.slice(2);
        } else {
            e.target.value = value;
        }
    });
    
    // Limit CVV to 3 or 4 digits
    const cvvInput = document.getElementById('card_cvv');
    cvvInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4);
        e.target.value = value;
    });
    
    // Copy IBAN to clipboard
    document.querySelector('.copy-iban')?.addEventListener('click', function() {
        const iban = 'TR12 3456 7890 1234 5678 9012 34';
        navigator.clipboard.writeText(iban).then(() => {
            this.innerHTML = '<i class="fas fa-check text-success"></i>';
            setTimeout(() => {
                this.innerHTML = '<i class="far fa-copy"></i>';
            }, 2000);
        });
    });
});
</script>
@endpush
@endsection 