@extends('layouts.admin')

@section('title', 'Kullanıcı Düzenle - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-dark border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-2 text-white">Kullanıcı Düzenle</h1>
                            <p class="text-gray-400">{{ $user->name }} kullanıcısının bilgilerini düzenleyin</p>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left me-2"></i>Geri Dön
                        </a>
                    </div>

                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="name" class="form-label text-white">Ad Soyad</label>
                                    <input type="text" 
                                           class="form-control bg-gray-700 border-0 text-white @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label text-white">E-posta Adresi</label>
                                    <input type="email" 
                                           class="form-control bg-gray-700 border-0 text-white @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label text-white">Şifre</label>
                                    <input type="password" 
                                           class="form-control bg-gray-700 border-0 text-white @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Değiştirmek için yeni şifre girin">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-gray-400">Şifreyi değiştirmek istemiyorsanız boş bırakın</small>
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label text-white">Şifre Tekrar</label>
                                    <input type="password" 
                                           class="form-control bg-gray-700 border-0 text-white" 
                                           id="password_confirmation" 
                                           name="password_confirmation">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="profile_photo" class="form-label text-white">Profil Fotoğrafı</label>
                                    <div class="profile-preview mb-3 text-center">
                                        <div class="bg-gray-700 rounded-xl p-4 d-flex align-items-center justify-content-center" style="height: 150px;">
                                            @if($user->profile_photo)
                                                <img src="{{ Storage::url($user->profile_photo) }}" 
                                                     alt="{{ $user->name }}" 
                                                     class="img-fluid rounded-circle" 
                                                     style="max-height: 100%;">
                                            @else
                                                <i class="fas fa-user fa-3x text-gray-400"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <input type="file" 
                                           class="form-control bg-gray-700 border-0 text-white @error('profile_photo') is-invalid @enderror" 
                                           id="profile_photo" 
                                           name="profile_photo"
                                           accept="image/*">
                                    @error('profile_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-gray-400 mt-2 d-block">
                                        Önerilen boyut: 200x200px, maksimum boyut: 2MB
                                    </small>
                                </div>

                                <div class="mb-4">
                                    <label for="role" class="form-label text-white">Kullanıcı Rolü</label>
                                    <select class="form-select bg-gray-700 border-0 text-white @error('role') is-invalid @enderror" 
                                            id="role" 
                                            name="role">
                                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Kullanıcı</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Yönetici</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label text-white" for="is_active">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('profile_photo').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.profile-preview');
            preview.innerHTML = `
                <div class="bg-gray-700 rounded-xl p-4 d-flex align-items-center justify-content-center" style="height: 150px;">
                    <img src="${e.target.result}" class="img-fluid rounded-circle" style="max-height: 100%;">
                </div>
            `;
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endpush

@endsection
