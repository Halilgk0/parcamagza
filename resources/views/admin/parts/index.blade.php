@extends('layouts.admin')

@section('title', 'Parça Yönetimi - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-white">Parça Yönetimi</h1>
            <p class="text-gray-400">Araç parçalarını yönetin</p>
        </div>
        <div>
            <a href="{{ route('admin.parts.bulk.form') }}" class="btn btn-success me-2">
                <i class="fas fa-file-excel me-2"></i>Toplu Parça Yükle
            </a>
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

    <div class="card bg-dark border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="ps-4">ID</th>
                            <th scope="col">Görsel</th>
                            <th scope="col">Parça Adı</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Parça No</th>
                            <th scope="col">Fiyat</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Durum</th>
                            <th scope="col" class="text-end pe-4">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parts as $part)
                            <tr>
                                <td class="ps-4">{{ $part->id }}</td>
                                <td>
                                    @if($part->image)
                                        <img src="{{ Storage::url($part->image) }}" 
                                             alt="{{ $part->name }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 50px;">
                                    @else
                                        <span class="text-gray-400">Görsel Yok</span>
                                    @endif
                                </td>
                                <td>{{ $part->name }}</td>
                                <td>{{ $part->category->name }}</td>
                                <td>{{ $part->part_number }}</td>
                                <td>{{ number_format($part->price, 2) }} TL</td>
                                <td>
                                    <span class="badge bg-{{ $part->stock_quantity > 0 ? 'success' : 'danger' }}">
                                        {{ $part->stock_quantity }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $part->is_active ? 'success' : 'danger' }}">
                                        {{ $part->is_active ? 'Aktif' : 'Pasif' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.parts.edit', $part) }}" 
                                       class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.parts.destroy', $part) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bu parçayı silmek istediğinizden emin misiniz?');">
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
                                <td colspan="9" class="text-center py-4 text-gray-400">
                                    <i class="fas fa-cog fa-2x mb-3 d-block"></i>
                                    Henüz parça eklenmemiş.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end p-3">
                {{ $parts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 