@extends('layouts.admin')

@section('title', 'Marka Yönetimi - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-white">Marka Yönetimi</h1>
            <p class="text-gray-400">Araç markalarını yönetin</p>
        </div>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Yeni Marka
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-dark border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="ps-4">Marka</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Model Sayısı</th>
                            <th scope="col">Parça Sayısı</th>
                            <th scope="col">Durum</th>
                            <th scope="col" class="text-end pe-4">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="brand-logo me-3">
                                            @if($brand->logo)
                                                <div class="bg-gray-700 rounded-xl p-2" style="width: 60px; height: 60px;">
                                                    <img src="{{ Storage::url($brand->logo) }}" 
                                                         alt="{{ $brand->name }}" 
                                                         class="img-fluid"
                                                         style="filter: brightness(0) invert(1);">
                                                </div>
                                            @else
                                                <div class="rounded-xl bg-gray-700 d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px;">
                                                    <i class="fas fa-building text-gray-300 fa-2x"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-white">{{ $brand->name }}</h6>
                                            <small class="text-gray-400">{{ $brand->slug }}</small>
                                            @if($brand->children->count() > 0)
                                                <span class="badge bg-info ms-2">{{ $brand->children->count() }} Alt Marka</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($brand->parent)
                                        <span class="badge bg-secondary">{{ $brand->parent->name }} Alt Markası</span>
                                    @else
                                        <span class="badge bg-dark">Ana Marka</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $brand->models_count ?? 0 }} Model</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $brand->parts_count ?? 0 }} Parça</span>
                                </td>
                                <td>
                                    @if($brand->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.brands.edit', $brand) }}" 
                                       class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bu markayı silmek istediğinizden emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-400">
                                    <i class="fas fa-building fa-2x mb-3 d-block"></i>
                                    Henüz hiç marka bulunmuyor
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection