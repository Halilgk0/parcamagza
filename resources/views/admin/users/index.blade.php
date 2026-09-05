@extends('layouts.admin')

@section('title', 'Kullanıcı Yönetimi - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-white">Kullanıcı Yönetimi</h1>
            <p class="text-gray-400">Sistemdeki tüm kullanıcıları yönetin</p>
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
                            <th scope="col" class="ps-4">Kullanıcı</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            @if($user->profile_photo)
                                                <img src="{{ Storage::url($user->profile_photo) }}" 
                                                     alt="{{ $user->name }}"
                                                     class="rounded-circle"
                                                     width="40"
                                                     height="40">
                                            @else
                                                <div class="rounded-circle bg-gray-700 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-gray-300"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-white">{{ $user->name }}</h6>
                                            <small class="text-gray-400">Kayıt: {{ $user->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="badge bg-red-500">Admin</span>
                                    @else
                                        <span class="badge bg-gray-600">Kullanıcı</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Pasif</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">
                                    <i class="fas fa-users fa-2x mb-3 d-block"></i>
                                    Henüz hiç kullanıcı bulunmuyor
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
