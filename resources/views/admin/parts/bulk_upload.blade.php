@extends('layouts.admin')

@section('title', 'Toplu Parça Yükleme')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-white">Toplu Parça Yükleme</h1>
    </div>

    <div class="card bg-dark border-0 shadow mb-4">
        <div class="card-header py-3 bg-gray-800 border-0">
            <h6 class="m-0 font-weight-bold text-white">Excel ile Toplu Parça Yükleme</h6>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="alert alert-info bg-dark text-info border border-info">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-info-circle fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="text-info">Excel Dosyası Gereksinimleri</h5>
                        <p class="mb-0">
                            Excel dosyanız şu sütunları içermelidir: <code>name</code> (isim), <code>part_number</code> (parça numarası), <code>price</code> (fiyat), <code>brand</code> (marka), <code>description</code> (açıklama), <code>stock_quantity</code> (stok miktarı)
                        </p>
                        <p class="mb-0 mt-2">
                            İsteğe bağlı sütunlar: <code>condition</code> (durum), <code>manufacturer</code> (üretici), <code>specifications</code> (özellikler), <code>compatibility</code> (uyumluluk), <code>compatible_models</code> (uyumlu modeller)
                        </p>
                        <p class="mb-0 mt-2">
                            <a href="{{ asset('templates/parts_upload_template.csv') }}" class="btn btn-outline-info btn-sm mt-2 me-2">
                                <i class="fas fa-download me-1"></i> CSV Şablonu İndir
                            </a>
                            <a href="{{ asset('templates/parts_upload_instructions.txt') }}" class="btn btn-outline-secondary btn-sm mt-2">
                                <i class="fas fa-file-alt me-1"></i> Talimatları İndir
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.parts.bulk.process') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label text-white">Excel Dosyası</label>
                            <input type="file" class="form-control @error('excel_file') is-invalid @enderror" 
                                id="excel_file" name="excel_file" required accept=".xlsx,.xls,.csv">
                            <small class="text-white">Desteklenen dosya tipleri: .xlsx, .xls, .csv</small>
                            @error('excel_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_id" class="form-label text-white">Kategori</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                                <option value="">Kategori Seçin</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-white">Tüm yüklenen parçalar için bir kategori seçin</small>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card bg-gray-800 border-0 mb-4">
                    <div class="card-header bg-gray-800 border-0">
                        <h6 class="mb-0 text-white">İşleme Özellikleri</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="create_brands" name="create_brands" value="1" checked>
                            <label class="form-check-label text-white" for="create_brands">
                                Olmayan markaları otomatik oluştur
                            </label>
                            <small class="d-block text-white">Excel'de belirtilen marka sistemde yoksa otomatik olarak oluşturulur</small>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="update_existing" name="update_existing" value="1">
                            <label class="form-check-label text-white" for="update_existing">
                                Mevcut parçaları güncelle
                            </label>
                            <small class="d-block text-white">Aynı parça numarasına sahip parça varsa bilgilerini günceller</small>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning bg-dark text-warning border border-warning">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="text-warning">Önemli Notlar</h5>
                            <ul class="mb-0">
                                <li>Yükleme sırasında hata olursa, işlem durdurulacak ve hiçbir parça eklenmeyecektir.</li>
                                <li>Yükleme işlemi büyük dosyalar için biraz zaman alabilir.</li>
                                <li>Desteklenen maksimum dosya boyutu: 10MB</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.parts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Geri
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i> Yükle ve İşle
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-dark border-0 shadow">
        <div class="card-header py-3 bg-gray-800 border-0">
            <h6 class="m-0 font-weight-bold text-white">Excel Dosyası Örnek Yapısı</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-white border-secondary">
                    <thead>
                        <tr>
                            <th>isim</th>
                            <th>parça_numarası</th>
                            <th>fiyat</th>
                            <th>marka</th>
                            <th>açıklama</th>
                            <th>stok_miktarı</th>
                            <th>durum</th>
                            <th>üretici</th>
                            <th>uyumlu_modeller</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Fren Balata Seti</td>
                            <td>FB-12345</td>
                            <td>750.00</td>
                            <td>Bosch</td>
                            <td>Yüksek kaliteli fren balata seti</td>
                            <td>15</td>
                            <td>yeni</td>
                            <td>Bosch</td>
                            <td>Polo, Golf, Passat</td>
                        </tr>
                        <tr>
                            <td>Yağ Filtresi</td>
                            <td>YF-67890</td>
                            <td>120.50</td>
                            <td>Mann</td>
                            <td>Uzun ömürlü yağ filtresi</td>
                            <td>30</td>
                            <td>yeni</td>
                            <td>Mann-Filter</td>
                            <td>Astra, Corsa, Insignia</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-gray-800 {
    background-color: #1f2937;
}
.text-gray-400 {
    color: #ffffff !important;
}
.text-muted {
    color: #ffffff !important;
}
</style>
@endpush

@push('scripts')
<script>
    // Dosya seçildiğinde önizleme
    document.getElementById('excel_file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            document.querySelector('label[for="excel_file"]').innerText = 'Seçilen Dosya: ' + fileName;
        } else {
            document.querySelector('label[for="excel_file"]').innerText = 'Excel Dosyası';
        }
    });
</script>
@endpush
@endsection 