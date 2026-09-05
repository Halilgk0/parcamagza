@extends('layouts.admin')

@section('title', 'E-posta Temaları')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-white">E-posta Temaları</h1>
            <p class="text-gray-400">E-posta gönderirken kullanabileceğiniz temalar</p>
        </div>
        <a href="{{ route('admin.email-templates.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Yeni Tema Ekle
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
                            <th scope="col">İsim</th>
                            <th scope="col">Konu</th>
                            <th scope="col">Açıklama</th>
                            <th scope="col">Durum</th>
                            <th scope="col" class="text-end pe-4">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($templates as $template)
                            <tr>
                                <td class="ps-4">{{ $template->id }}</td>
                                <td>{{ $template->name }}</td>
                                <td>{{ $template->subject }}</td>
                                <td>{{ Str::limit($template->description ?? '-', 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $template->is_active ? 'success' : 'danger' }}">
                                        {{ $template->is_active ? 'Aktif' : 'Pasif' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.email-templates.edit', $template) }}" 
                                       class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.email-templates.destroy', $template) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bu temayı silmek istediğinizden emin misiniz?');">
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
                                    <i class="fas fa-envelope fa-2x mb-3 d-block"></i>
                                    Henüz e-posta teması eklenmemiş.
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