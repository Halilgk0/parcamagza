@extends('layouts.app')

@section('title', 'E-posta Doğrulama - Parca Magaza')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">E-posta Adresinizi Doğrulayın</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Yeni bir doğrulama bağlantısı e-posta adresinize gönderildi.
                        </div>
                    @endif

                    E-posta adresinize gönderilen doğrulama bağlantısını kontrol edin.
                    
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                            Doğrulama bağlantısını tekrar gönder
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 