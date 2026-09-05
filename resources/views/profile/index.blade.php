@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        @include('profile.partials.sidebar')
        
        <div class="col-lg-9">
            <!-- Profil Bilgileri -->
            <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
                <div class="card-header bg-dark border-0 py-3">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-user-circle me-2"></i>Profil Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Profil Fotoğrafı -->
                            <div class="col-md-3 text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    @if(auth()->user()->profile_photo)
                                        <img src="{{ Storage::url(auth()->user()->profile_photo) }}" 
                                             alt="{{ auth()->user()->name }}" 
                                             class="rounded-circle img-fluid mb-3"
                                             style="width: 150px; height: 150px; object-fit: cover;"
                                             id="profilePhotoPreview">
                                    @else
                                        <div class="bg-gray-700 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                                             style="width: 150px; height: 150px;"
                                             id="profilePhotoPreview">
                                            <i class="fas fa-user fa-4x text-gray-400"></i>
                                        </div>
                                    @endif
                                    
                                    <label class="btn btn-sm btn-primary position-absolute bottom-0 start-50 translate-middle-x" style="width: 120px;">
                                        <i class="fas fa-camera me-2"></i>Değiştir
                                        <input type="file" name="profile_photo" class="d-none" accept="image/*" id="profilePhotoInput">
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Kişisel Bilgiler -->
                            <div class="col-md-9">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-white">Ad Soyad</label>
                                        <input type="text" name="name" class="form-control bg-gray-800 border-gray-700 text-white" 
                                               value="{{ auth()->user()->name }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label text-white">E-posta</label>
                                        <input type="email" name="email" class="form-control bg-gray-800 border-gray-700 text-white" 
                                               value="{{ auth()->user()->email }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label text-white">Telefon</label>
                                        <input type="tel" name="phone" class="form-control bg-gray-800 border-gray-700 text-white" 
                                               value="{{ auth()->user()->phone }}">
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary mt-4">
                                    <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Şifre Değiştirme -->
            <div class="card bg-dark border-0 rounded-lg shadow-sm">
                <div class="card-header bg-dark border-0 py-3">
                    <h5 class="card-title text-white mb-0">
                        <i class="fas fa-lock me-2"></i>Şifre Değiştir
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" id="passwordForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-white">Mevcut Şifre</label>
                                <input type="password" name="current_password" class="form-control bg-gray-800 border-gray-700 text-white" required>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label text-white">Yeni Şifre</label>
                                <input type="password" name="new_password" class="form-control bg-gray-800 border-gray-700 text-white" required>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label text-white">Yeni Şifre (Tekrar)</label>
                                <input type="password" name="new_password_confirmation" class="form-control bg-gray-800 border-gray-700 text-white" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-4">
                            <i class="fas fa-key me-2"></i>Şifreyi Değiştir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-gray-800 {
    background-color: #1f2937;
}
.border-gray-700 {
    border-color: #374151;
}
.text-gray-400 {
    color: #9ca3af;
}
</style>
@endpush

@push('scripts')
<script>
document.getElementById('profilePhotoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profilePhotoPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.id = 'profilePhotoPreview';
                img.className = 'rounded-circle img-fluid mb-3';
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.objectFit = 'cover';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(file);
    }
});

// AJAX form submission for profile update
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                text: data.message,
                background: '#1a1a1a',
                color: '#fff'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Hata!',
            text: 'Bir hata oluştu. Lütfen tekrar deneyin.',
            background: '#1a1a1a',
            color: '#fff'
        });
    });
});

// AJAX form submission for password update
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                text: data.message,
                background: '#1a1a1a',
                color: '#fff'
            });
            form.reset();
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Hata!',
            text: 'Bir hata oluştu. Lütfen tekrar deneyin.',
            background: '#1a1a1a',
            color: '#fff'
        });
    });
});
</script>
@endpush
@endsection
