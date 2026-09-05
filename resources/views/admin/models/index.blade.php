@extends('layouts.admin')

@section('title', 'Modeller - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-white">Model Yönetimi</h1>
            <p class="text-gray-400">Araç modellerini yönetin</p>
        </div>
        <a href="{{ route('admin.models.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Yeni Model
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
                            <th scope="col">Marka</th>
                            <th scope="col">Model</th>
                            <th scope="col">Yıl Aralığı</th>
                            <th scope="col">Parça Sayısı</th>
                            <th scope="col">Durum</th>
                            <th scope="col" class="text-end pe-4">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($models as $model)
                            <tr>
                                <td class="ps-4">{{ $model->id }}</td>
                                <td>{{ $model->brand->name }}</td>
                                <td>{{ $model->name }}</td>
                                <td>
                                    @if($model->year_start || $model->year_end)
                                        {{ $model->year_start ?? '?' }} - {{ $model->year_end ?? 'Günümüz' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $model->parts_count ?? 0 }}</td>
                                <td>
                                    @if($model->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.models.edit', $model) }}" 
                                       class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.models.destroy', $model) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Bu modeli silmek istediğinize emin misiniz?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-400">
                                    <i class="fas fa-car fa-2x mb-3 d-block"></i>
                                    Henüz model eklenmemiş.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-3">
                {{ $models->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 