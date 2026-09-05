@extends('layouts.app')

@section('title', 'Kayıt Ol - Parca Magaza')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark border-0 shadow">
                <div class="card-header bg-dark border-0">
                    <h3 class="text-white mb-0">Kayıt Ol</h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label text-white">Ad Soyad</label>
                            <input id="name" type="text" 
                                   class="form-control bg-gray-800 border-0 text-white @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" 
                                   placeholder="Adınız ve soyadınız"
                                   required autocomplete="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-white">E-posta Adresi</label>
                            <input id="email" type="email" 
                                   class="form-control bg-gray-800 border-0 text-white @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" 
                                   placeholder="ornek@email.com"
                                   required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label text-white">Şifre</label>
                                <input id="password" type="password" 
                                       class="form-control bg-gray-800 border-0 text-white @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="En az 8 karakter"
                                       required autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password-confirm" class="form-label text-white">Şifre Tekrar</label>
                                <input id="password-confirm" type="password" 
                                       class="form-control bg-gray-800 border-0 text-white" 
                                       name="password_confirmation" 
                                       placeholder="Şifrenizi tekrar girin"
                                       required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label text-white">Telefon</label>
                            <input id="phone" type="tel" 
                                   class="form-control bg-gray-800 border-0 text-white @error('phone') is-invalid @enderror" 
                                   name="phone" value="{{ old('phone') }}" 
                                   placeholder="05XX XXX XX XX"
                                   autocomplete="tel">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label text-white">Adres</label>
                            <textarea id="address" 
                                      class="form-control bg-gray-800 border-0 text-white @error('address') is-invalid @enderror" 
                                      name="address" rows="3" 
                                      placeholder="Açık adresiniz">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="city" class="form-label text-white">Şehir</label>
                                <input id="city" type="text" 
                                       class="form-control bg-gray-800 border-0 text-white @error('city') is-invalid @enderror" 
                                       name="city" value="{{ old('city') }}" 
                                       placeholder="Yaşadığınız şehir">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="postal_code" class="form-label text-white">Posta Kodu</label>
                                <input id="postal_code" type="text" 
                                       class="form-control bg-gray-800 border-0 text-white @error('postal_code') is-invalid @enderror" 
                                       name="postal_code" value="{{ old('postal_code') }}" 
                                       placeholder="XXXXX">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Kayıt Ol
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-gray-400">
                                Zaten hesabınız var mı? 
                                <a href="{{ route('login') }}" class="text-primary">Giriş Yap</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border-radius: 0.5rem;
}

.form-control:focus {
    background-color: var(--bs-gray-700);
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
}

.btn-primary {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    border-radius: 0.5rem;
}

.card {
    border-radius: 1rem;
    backdrop-filter: blur(10px);
}

.card-header {
    border-top-left-radius: 1rem !important;
    border-top-right-radius: 1rem !important;
}
</style>
@endsection 