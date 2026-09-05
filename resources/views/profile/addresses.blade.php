@extends('layouts.app')

@section('title', 'Adreslerim')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Profil Sidebar -->
        @include('profile.partials.sidebar')

        <!-- Adresler İçeriği -->
        <div class="col-lg-9">
            <div class="card bg-dark border-0 rounded-lg shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-white mb-0">Adreslerim</h4>
                        <button type="button" 
                                class="btn btn-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addAddressModal">
                            <i class="fas fa-plus me-2"></i>Yeni Adres Ekle
                        </button>
                    </div>

                    <div class="row g-4">
                        @forelse($addresses as $address)
                            <div class="col-md-6">
                                <div class="card bg-gray-800 border-0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="text-white mb-0">{{ $address->title }}</h5>
                                            <div class="dropdown">
                                                <button class="btn btn-link text-gray-400 p-0" 
                                                        type="button"
                                                        data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end bg-dark border-0">
                                                    <li>
                                                        <button type="button" 
                                                                class="dropdown-item text-white"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editAddressModal"
                                                                data-address="{{ json_encode($address) }}">
                                                            <i class="fas fa-edit me-2"></i>Düzenle
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('profile.addresses.destroy', $address) }}" 
                                                              method="POST"
                                                              onsubmit="return confirm('Bu adresi silmek istediğinizden emin misiniz?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash-alt me-2"></i>Sil
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <p class="text-white mb-1">{{ $address->name }}</p>
                                        <p class="text-gray-400 mb-2">{{ $address->phone }}</p>
                                        <p class="text-gray-400 mb-1">
                                            {{ $address->address }}
                                        </p>
                                        <p class="text-gray-400 mb-0">
                                            {{ $address->district }}/{{ $address->city }} - {{ $address->postal_code }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-map-marker-alt fa-3x text-gray-400 mb-3"></i>
                                <h5 class="text-white">Henüz adresiniz bulunmuyor</h5>
                                <p class="text-gray-400">Siparişleriniz için yeni bir teslimat adresi ekleyebilirsiniz.</p>
                                <button type="button" 
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addAddressModal">
                                    <i class="fas fa-plus me-2"></i>Yeni Adres Ekle
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Yeni Adres Ekleme Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-gray-700">
                <h5 class="modal-title text-white">Yeni Adres Ekle</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label text-white">Adres Başlığı</label>
                        <input type="text" 
                               class="form-control bg-gray-700 border-0 text-white" 
                               id="title" 
                               name="title" 
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label text-white">Ad Soyad</label>
                        <input type="text" 
                               class="form-control bg-gray-700 border-0 text-white" 
                               id="name" 
                               name="name" 
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label text-white">Telefon</label>
                        <input type="tel" 
                               class="form-control bg-gray-700 border-0 text-white" 
                               id="phone" 
                               name="phone" 
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label text-white">Adres</label>
                        <textarea class="form-control bg-gray-700 border-0 text-white" 
                                  id="address" 
                                  name="address" 
                                  rows="3" 
                                  required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label text-white">İl</label>
                            <input type="text" 
                                   class="form-control bg-gray-700 border-0 text-white" 
                                   id="city" 
                                   name="city" 
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="district" class="form-label text-white">İlçe</label>
                            <input type="text" 
                                   class="form-control bg-gray-700 border-0 text-white" 
                                   id="district" 
                                   name="district" 
                                   required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="postal_code" class="form-label text-white">Posta Kodu</label>
                        <input type="text" 
                               class="form-control bg-gray-700 border-0 text-white" 
                               id="postal_code" 
                               name="postal_code" 
                               required>
                    </div>
                </div>
                <div class="modal-footer border-gray-700">
                    <button type="button" class="btn btn-link text-gray-400" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Adres Düzenleme Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-gray-700">
                <h5 class="modal-title text-white">Adres Düzenle</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAddressForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label text-white">Adres Başlığı</label>
                        <input type="text" 
                               class="form-control bg-gray-700 border-0 text-white" 
                               id="edit_title" 
                               name="title" 
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_name" class="form-label text-white">Ad Soyad</label>
                        <input type="text" 
                               class="form-control bg-gray-700 border-0 text-white" 
                               id="edit_name" 
                               name="name" 
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label text-white">Telefon</label>
                        <input type="tel" 
                               class="form-control bg-gray-700 border-0 text-white" 
                               id="edit_phone" 
                               name="phone" 
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_address" class="form-label text-white">Adres</label>
                        <textarea class="form-control bg-gray-700 border-0 text-white" 
                                  id="edit_address" 
                                  name="address" 
                                  rows="3" 
                                  required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_city" class="form-label text-white">İl</label>
                            <input type="text" 
                                   class="form-control bg-gray-700 border-0 text-white" 
                                   id="edit_city" 
                                   name="city" 
                                   required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_district" class="form-label text-white">İlçe</label>
                            <input type="text" 
                                   class="form-control bg-gray-700 border-0 text-white" 
                                   id="edit_district" 
                                   name="district" 
                                   required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_postal_code" class="form-label text-white">Posta Kodu</label>
                        <input type="text" 
                               class="form-control bg-gray-700 border-0 text-white" 
                               id="edit_postal_code" 
                               name="postal_code" 
                               required>
                    </div>
                </div>
                <div class="modal-footer border-gray-700">
                    <button type="button" class="btn btn-link text-gray-400" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Adres düzenleme modalını hazırla
document.getElementById('editAddressModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget
    const address = JSON.parse(button.getAttribute('data-address'))
    const form = this.querySelector('#editAddressForm')
    
    form.action = `/profile/addresses/${address.id}`
    form.querySelector('#edit_title').value = address.title
    form.querySelector('#edit_name').value = address.name
    form.querySelector('#edit_phone').value = address.phone
    form.querySelector('#edit_address').value = address.address
    form.querySelector('#edit_city').value = address.city
    form.querySelector('#edit_district').value = address.district
    form.querySelector('#edit_postal_code').value = address.postal_code
})
</script>
@endpush

@endsection
