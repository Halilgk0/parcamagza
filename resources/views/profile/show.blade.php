@extends('layouts.app')

@section('title', 'Profilim - Parca Magaza')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Profil Sidebar -->
        @include('profile.partials.sidebar')

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card bg-dark border-0 rounded-lg shadow-sm">
                <div class="card-header bg-dark border-0 py-3">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-user-circle me-2"></i>Profil Bilgileri
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong class="text-white">Ad Soyad</strong>
                        </div>
                        <div class="col-md-9 text-white">
                            {{ $user->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong class="text-white">E-posta</strong>
                        </div>
                        <div class="col-md-9 text-white">
                            {{ $user->email }}
                            @if($user->email_verified_at)
                                <span class="badge bg-success ms-2">Doğrulanmış</span>
                            @else
                                <span class="badge bg-warning ms-2">Doğrulanmamış</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong class="text-white">Telefon</strong>
                        </div>
                        <div class="col-md-9 text-white">
                            {{ $user->phone ?? 'Belirtilmemiş' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong class="text-white">Adres</strong>
                        </div>
                        <div class="col-md-9 text-white">
                            {{ $user->address ?? 'Belirtilmemiş' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong class="text-white">Şehir</strong>
                        </div>
                        <div class="col-md-9 text-white">
                            {{ $user->city ?? 'Belirtilmemiş' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <strong class="text-white">Posta Kodu</strong>
                        </div>
                        <div class="col-md-9 text-white">
                            {{ $user->postal_code ?? 'Belirtilmemiş' }}
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Profili Düzenle
                        </a>
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
.border-gray-700 {
    border-color: #374151;
}
.text-gray-400 {
    color: #9ca3af;
}
</style>
@endpush
@endsection 