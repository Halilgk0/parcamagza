@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- İstatistik Kartları -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card bg-dark border-0">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-white opacity-75">TOPLAM PARÇA</p>
                                <h5 class="font-weight-bolder text-white mb-0">
                                    {{ $stats['total_parts'] }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-cogs text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card bg-dark border-0">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-white opacity-75">TOPLAM KATEGORİ</p>
                                <h5 class="font-weight-bolder text-white mb-0">
                                    {{ $stats['total_categories'] }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-folder text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card bg-dark border-0">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-white opacity-75">TOPLAM MARKA</p>
                                <h5 class="font-weight-bolder text-white mb-0">
                                    {{ $stats['total_brands'] }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-building text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card bg-dark border-0">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-white opacity-75">TOPLAM KULLANICI</p>
                                <h5 class="font-weight-bolder text-white mb-0">
                                    {{ $stats['total_users'] }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-users text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hızlı İşlemler -->
    <div class="card bg-dark border-0 mb-4">
        <div class="card-body">
            <h5 class="text-white mb-4">Hızlı İşlemler</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.parts.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Yeni Parça Ekle
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-folder-plus me-2"></i>Yeni Kategori Ekle
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary w-100">
                        <i class="fas fa-plus-circle me-2"></i>Yeni Marka Ekle
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Haber Ekle Bölümü -->
    <div class="card bg-dark border-0 mb-4">
        <div class="card-body">
            <h5 class="text-white mb-4">Haber Ekle</h5>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Bu özellik şu anda bakım modunda. Lütfen daha sonra tekrar deneyin.
            </div>
        </div>
    </div>

    <!-- Site Ayarları -->
    <div class="card bg-dark border-0 mb-4">
        <div class="card-body">
            <h5 class="text-white mb-4">Site Ayarları</h5>
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="site_name" class="form-label text-white">Site Adı</label>
                        <input type="text" class="form-control bg-gray-700 border-0 text-white" id="site_name" name="site_name" value="{{ $settings['site_name'] }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="contact_email" class="form-label text-white">E-posta Adresi</label>
                        <input type="email" class="form-control bg-gray-700 border-0 text-white" id="contact_email" name="contact_email" value="{{ $settings['contact_email'] }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="notification_email" class="form-label text-white">Stok Bildirimi E-posta Adresi</label>
                        <input type="email" class="form-control bg-gray-700 border-0 text-white" id="notification_email" name="notification_email" value="{{ $settings['notification_email'] ?? '' }}" placeholder="Stok bildirimleri için e-posta adresi">
                        <small class="text-muted">Stok azaldığında bildirimlerin gönderileceği e-posta</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="site_description" class="form-label text-white">Site Açıklaması</label>
                        <textarea class="form-control bg-gray-700 border-0 text-white" id="site_description" name="site_description" rows="3">{{ $settings['site_description'] }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="site_logo" class="form-label text-white">Site Logosu</label>
                        <input type="file" class="form-control bg-gray-700 border-0 text-white" id="site_logo" name="site_logo">
                        @if(file_exists(public_path('images/logo.png')))
                            <div class="mt-2">
                                <img src="{{ asset('images/logo.png') }}" alt="Current Logo" class="img-thumbnail bg-dark" style="max-height: 60px;">
                            </div>
                        @elseif(file_exists(public_path('images/logo.jpg')))
                            <div class="mt-2">
                                <img src="{{ asset('images/logo.jpg') }}" alt="Current Logo" class="img-thumbnail bg-dark" style="max-height: 60px;">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Ayarları Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Son İşlemler -->
    <div class="card bg-dark border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-white mb-0">Son İşlemler</h5>
                <a href="#" class="btn btn-primary btn-sm">
                    <i class="fas fa-list me-2"></i>Tümünü Gör
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="text-white">İşlem</th>
                            <th class="text-white">Tarih</th>
                            <th class="text-white">Durum</th>
                            <th class="text-white">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Örnek işlemler -->
                        <tr>
                            <td>Yeni parça eklendi</td>
                            <td>10.03.2024 14:30</td>
                            <td><span class="badge bg-success">Başarılı</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Görüntüle
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Kategori güncellendi</td>
                            <td>10.03.2024 14:25</td>
                            <td><span class="badge bg-success">Başarılı</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Görüntüle
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
