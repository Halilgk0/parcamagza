@extends('layouts.app')

@section('title', 'E-posta Doğrulama')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card bg-dark border-0 rounded-lg shadow-lg">
                <div class="card-body p-4">
                    <!-- İkon ve Başlık -->
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-envelope fa-2x text-primary"></i>
                        </div>
                        <h4 class="text-white mb-2">E-posta Adresinizi Doğrulayın</h4>
                        <p class="text-white mb-2">
                            Hesabınızı aktifleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını kontrol edin.
                        </p>
                    </div>

                    <!-- Doğrulama Durumu -->
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success bg-success bg-opacity-10 border-0 text-success mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <div>Yeni bir doğrulama bağlantısı e-posta adresinize gönderildi.</div>
                            </div>
                        </div>
                    @endif

                    <!-- Bilgi Kartı -->
                    <div class="bg-gray-800 rounded-lg p-4 mb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-info me-3 mt-1"></i>
                            </div>
                            <div class="text-gray-300 small">
                                E-posta adresinize gönderilen doğrulama bağlantısına tıklayarak hesabınızı aktifleştirebilirsiniz. 
                                Eğer e-posta almadıysanız, spam klasörünü kontrol edin veya yeni bir doğrulama bağlantısı talep edin.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
                        <!-- Yeni Doğrulama Bağlantısı -->
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-2"></i>Yeni Doğrulama Bağlantısı Gönder
                            </button>
                        </form>

                        <!-- Çıkış Yap -->
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Yardım Kartı -->
            <div class="card bg-dark border-0 rounded-lg shadow-sm mt-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-question-circle text-primary me-2"></i>
                        <h6 class="text-white mb-0">Yardıma mı ihtiyacınız var?</h6>
                    </div>
                    <p class="text-gray-400 small mb-0">
                        Sorun yaşıyorsanız veya desteğe ihtiyacınız varsa, 
                        <a href="mailto:info@parcamagza.com" class="text-primary text-decoration-none">
                            info@parcamagza.com
                        </a> 
                        adresinden bizimle iletişime geçebilirsiniz.
                    </p>
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
.text-gray-300 {
    color: #d1d5db;
}
.text-gray-400 {
    color: #9ca3af;
}
</style>
@endpush
@endsection
