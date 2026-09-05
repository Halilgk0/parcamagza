@extends('layouts.admin')

@section('title', 'Kategori Yönetimi - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-white">Kategori Yönetimi</h1>
            <p class="text-gray-400">Ürün kategorilerini yönetin</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Yeni Kategori
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
                            <th scope="col" class="ps-4">ID</th>
                            <th scope="col">İkon</th>
                            <th scope="col">Kategori Adı</th>
                            <th scope="col">Üst Kategori</th>
                            <th scope="col">Parça Sayısı</th>
                            <th scope="col">Durum</th>
                            <th scope="col" class="text-end pe-4">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="ps-4">{{ $category->id }}</td>
                                <td>
                                    <i class="fas {{ $category->icon ?? 'fa-folder' }} fa-lg"></i>
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->parent->name ?? '-' }}</td>
                                <td>{{ $category->parts_count }}</td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?');">
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
                                <td colspan="7" class="text-center py-4 text-gray-400">
                                    <i class="fas fa-folder-open fa-2x mb-3 d-block"></i>
                                    Henüz kategori bulunmuyor
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
