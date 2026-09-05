@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-white">Dashboard</h1>
            <p class="text-gray-400">Sistem genel durumunu görüntüleyin</p>
        </div>
        <div>
            <a href="{{ route('admin.parts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Yeni Parça Ekle
            </a>
        </div>
    </div>

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
        <div class="card-header bg-dark py-3 border-0">
            <h6 class="m-0 font-weight-bold text-white">Hızlı İşlemler</h6>
        </div>
        <div class="card-body">
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

    <!-- Mevcut Haberler/Bannerlar -->
    <div class="card bg-dark border-0 mb-4">
        <div class="card-header bg-dark py-3 border-0">
            <h6 class="m-0 font-weight-bold text-white">Mevcut Haberler</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="ps-4">Görsel</th>
                            <th scope="col">Başlık</th>
                            <th scope="col">Alt Başlık</th>
                            <th scope="col">Durum</th>
                            <th scope="col" class="text-end pe-4">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($banners) && count($banners) > 0)
                            @foreach($banners as $banner)
                                <tr>
                                    <td class="ps-4">
                                        <img src="{{ Storage::url($banner->image_path) }}" alt="{{ $banner->title }}" class="img-thumbnail" style="max-height: 60px;">
                                    </td>
                                    <td>{{ $banner->title }}</td>
                                    <td>{{ $banner->subtitle }}</td>
                                    <td>
                                        @if($banner->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Pasif</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu haberi silmek istediğinizden emin misiniz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Henüz haber eklenmemiş</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Haber Ekle Bölümü -->
    <div class="card bg-dark border-0 mb-4">
        <div class="card-header bg-dark py-3 border-0">
            <h6 class="m-0 font-weight-bold text-white">Haber Ekle</h6>
        </div>
        <div class="card-body">
            @if(class_exists('\App\Models\Banner'))
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section" value="home_banner">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label text-white">Başlık</label>
                        <input type="text" class="form-control bg-gray-700 border-0 text-white" id="title" name="title" placeholder="Örn: ARAÇ PARÇALARI">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="subtitle" class="form-label text-white">Alt Başlık</label>
                        <input type="text" class="form-control bg-gray-700 border-0 text-white" id="subtitle" name="subtitle" placeholder="Örn: Kaliteli ve Uygun Fiyatlı">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="link" class="form-label text-white">Link (Opsiyonel)</label>
                        <input type="text" class="form-control bg-gray-700 border-0 text-white" id="link" name="link" placeholder="Örn: https://example.com/page">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="order" class="form-label text-white">Sıralama</label>
                        <input type="number" class="form-control bg-gray-700 border-0 text-white" id="order" name="order" value="0">
                        <small class="text-muted">Düşük sayılar önce gösterilir</small>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="image" class="form-label text-white">Görsel</label>
                        <input type="file" class="form-control bg-gray-700 border-0 text-white" id="image" name="image" required>
                        <small class="text-muted">Önerilen boyut: 1200x600px, Maksimum dosya boyutu: 2MB</small>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                            <label class="form-check-label text-white" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Haberi Kaydet
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>

    <!-- Site Ayarları -->
    <div class="card bg-dark border-0 mb-4">
        <div class="card-header bg-dark py-3 border-0">
            <h6 class="m-0 font-weight-bold text-white">Site Ayarları</h6>
        </div>
        <div class="card-body">
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
        <div class="card-header bg-dark py-3 border-0 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-white">Son İşlemler</h6>
            <a href="#" class="btn btn-primary btn-sm">
                <i class="fas fa-list me-2"></i>Tümünü Gör
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="ps-4">İşlem</th>
                            <th scope="col">Tarih</th>
                            <th scope="col">Durum</th>
                            <th scope="col" class="text-end pe-4">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Örnek işlemler -->
                        <tr>
                            <td class="ps-4">Yeni parça eklendi</td>
                            <td>10.03.2024 14:30</td>
                            <td><span class="badge bg-success">Başarılı</span></td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Kategori güncellendi</td>
                            <td>10.03.2024 14:25</td>
                            <td><span class="badge bg-success">Başarılı</span></td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
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
