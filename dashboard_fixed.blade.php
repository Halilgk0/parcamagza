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
