<div class="col-lg-3">
    <!-- Profil Kartı -->
    <div class="card bg-dark border-0 rounded-lg shadow-sm mb-4">
        <div class="card-body p-4 text-center">
            <div class="mb-4">
                @if(auth()->user()->profile_photo)
                    <img src="{{ Storage::url(auth()->user()->profile_photo) }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="rounded-circle img-fluid mb-3"
                         style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <div class="bg-gray-700 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                         style="width: 120px; height: 120px;">
                        <i class="fas fa-user fa-3x text-gray-400"></i>
                    </div>
                @endif
                <h5 class="text-white mb-1">{{ auth()->user()->name }}</h5>
                <p class="text-gray-400 mb-0">{{ auth()->user()->email }}</p>
            </div>
            
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary w-100">
                    <i class="fas fa-tachometer-alt me-2"></i>Yönetim Paneli
                </a>
            @endif
        </div>
    </div>

    <!-- Navigasyon -->
    <div class="card bg-dark border-0 rounded-lg shadow-sm">
        <div class="card-body p-0">
            <nav class="nav flex-column">
                <a href="{{ route('profile.index') }}" 
                   class="nav-link d-flex align-items-center px-4 py-3 text-white {{ request()->routeIs('profile.index') ? 'bg-primary' : 'hover-bg-gray-800' }}">
                    <i class="fas fa-user-circle me-3"></i>
                    <span>Profil Bilgileri</span>
                </a>
                
                <a href="{{ route('profile.orders') }}" 
                   class="nav-link d-flex align-items-center px-4 py-3 text-white {{ request()->routeIs('profile.orders') ? 'bg-primary' : 'hover-bg-gray-800' }}">
                    <i class="fas fa-shopping-bag me-3"></i>
                    <span>Siparişlerim</span>
                    @if($orderCount = auth()->user()->orders()->count())
                        <span class="badge bg-primary ms-auto">{{ $orderCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('profile.favorites') }}" 
                   class="nav-link d-flex align-items-center px-4 py-3 text-white {{ request()->routeIs('profile.favorites') ? 'bg-primary' : 'hover-bg-gray-800' }}">
                    <i class="fas fa-heart me-3"></i>
                    <span>Favorilerim</span>
                    @if($favoriteCount = auth()->user()->favorites()->count())
                        <span class="badge bg-primary ms-auto">{{ $favoriteCount }}</span>
                    @endif
                </a>
                
                <a href="{{ route('profile.addresses') }}" 
                   class="nav-link d-flex align-items-center px-4 py-3 text-white {{ request()->routeIs('profile.addresses') ? 'bg-primary' : 'hover-bg-gray-800' }}">
                    <i class="fas fa-map-marker-alt me-3"></i>
                    <span>Adreslerim</span>
                    @if($addressCount = auth()->user()->addresses()->count())
                        <span class="badge bg-primary ms-auto">{{ $addressCount }}</span>
                    @endif
                </a>
                
                <!-- Çıkış Yap Butonu -->
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="nav-link d-flex align-items-center px-4 py-3 text-white hover-bg-gray-800 border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt me-3"></i>
                        <span>Çıkış Yap</span>
                    </button>
                </form>
            </nav>
        </div>
    </div>
</div>

@push('styles')
<style>
.hover-bg-gray-800:hover {
    background-color: rgba(255, 255, 255, 0.05);
}
</style>
@endpush
