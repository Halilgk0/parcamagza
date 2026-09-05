@extends('layouts.admin')

@section('title', 'Footer Yönetimi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-white">Footer Yönetimi</h1>
        <a href="{{ route('admin.footer.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Yeni Bağlantı Ekle
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-gray-800">
                    <h5 class="mb-0 text-white">Footer Bağlantıları</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        @if($footerLinks->count() > 0)
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-white">Başlık</th>
                                        <th class="text-white">URL</th>
                                        <th class="text-white">Kolon</th>
                                        <th class="text-white">Sıra</th>
                                        <th class="text-white">Durum</th>
                                        <th class="text-end text-white">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($footerLinks as $column => $links)
                                        <tr class="bg-gray-800">
                                            <td colspan="6" class="fw-bold text-white">{{ ucfirst($column) }} Kolonu</td>
                                        </tr>
                                        @foreach($links as $link)
                                            <tr>
                                                <td class="text-white">{{ $link->title }}</td>
                                                <td>
                                                    <a href="{{ $link->url }}" target="_blank" class="text-light">
                                                        {{ Str::limit($link->url, 30) }}
                                                    </a>
                                                </td>
                                                <td class="text-white">{{ $link->column }}</td>
                                                <td class="text-white">{{ $link->position }}</td>
                                                <td>
                                                    @if($link->is_active)
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Pasif</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.footer.edit', $link) }}" class="btn btn-sm btn-outline-light me-1">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.footer.destroy', $link) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu bağlantıyı silmek istediğinize emin misiniz?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-4 text-center">
                                <p class="text-gray-400">Henüz footer bağlantısı bulunmuyor.</p>
                                <a href="{{ route('admin.footer.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus me-1"></i> Bağlantı Ekle
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-gray-800">
                    <h5 class="mb-0 text-white">Şirket Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.footer.company-info') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="footer_company_name" class="form-label text-white">Şirket Adı</label>
                            <input type="text" class="form-control" id="footer_company_name" name="footer_company_name" 
                                value="{{ is_array(config('site.footer.company_name')) ? '' : config('site.footer.company_name', 'Parça Mağaza') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="footer_company_description" class="form-label text-white">Şirket Açıklaması</label>
                            <textarea class="form-control" id="footer_company_description" name="footer_company_description" rows="3">{{ is_array(config('site.footer.company_description')) ? '' : config('site.footer.company_description', 'Türkiye\'nin en güvenilir otomotiv yedek parça mağazası.') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="footer_contact_heading" class="form-label text-white">İletişim Başlığı</label>
                            <input type="text" class="form-control" id="footer_contact_heading" name="footer_contact_heading" 
                                value="{{ is_array(config('site.footer.contact_heading')) ? '' : config('site.footer.contact_heading', 'İletişim') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="footer_contact_email" class="form-label text-white">E-posta</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary">
                                    <select name="footer_contact_email_icon" class="form-select bg-dark border-0 text-white">
                                        <option value="fa-envelope" {{ (!is_array(config('site.footer.contact_email_icon')) && config('site.footer.contact_email_icon', 'fa-envelope') == 'fa-envelope') ? 'selected' : '' }}>✉️ Zarf</option>
                                        <option value="fa-at" {{ (!is_array(config('site.footer.contact_email_icon')) && config('site.footer.contact_email_icon') == 'fa-at') ? 'selected' : '' }}>@ İşareti</option>
                                        <option value="fa-mail-bulk" {{ (!is_array(config('site.footer.contact_email_icon')) && config('site.footer.contact_email_icon') == 'fa-mail-bulk') ? 'selected' : '' }}>📨 E-posta</option>
                                    </select>
                                </span>
                                <input type="email" class="form-control" id="footer_contact_email" name="footer_contact_email" 
                                    value="{{ is_array(config('site.footer.contact_email')) ? '' : config('site.footer.contact_email', 'info@parcamagaza.com') }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="footer_contact_phone" class="form-label text-white">Telefon</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary">
                                    <select name="footer_contact_phone_icon" class="form-select bg-dark border-0 text-white">
                                        <option value="fa-phone" {{ (!is_array(config('site.footer.contact_phone_icon')) && config('site.footer.contact_phone_icon', 'fa-phone') == 'fa-phone') ? 'selected' : '' }}>📞 Telefon</option>
                                        <option value="fa-mobile-alt" {{ (!is_array(config('site.footer.contact_phone_icon')) && config('site.footer.contact_phone_icon') == 'fa-mobile-alt') ? 'selected' : '' }}>📱 Mobil</option>
                                        <option value="fa-phone-alt" {{ (!is_array(config('site.footer.contact_phone_icon')) && config('site.footer.contact_phone_icon') == 'fa-phone-alt') ? 'selected' : '' }}>☎️ Sabit Hat</option>
                                    </select>
                                </span>
                                <input type="text" class="form-control" id="footer_contact_phone" name="footer_contact_phone" 
                                    value="{{ is_array(config('site.footer.contact_phone')) ? '' : config('site.footer.contact_phone', '+90 212 123 45 67') }}">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="footer_contact_address" class="form-label text-white">Adres</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary">
                                    <select name="footer_contact_address_icon" class="form-select bg-dark border-0 text-white">
                                        <option value="fa-map-marker-alt" {{ (!is_array(config('site.footer.contact_address_icon')) && config('site.footer.contact_address_icon', 'fa-map-marker-alt') == 'fa-map-marker-alt') ? 'selected' : '' }}>📍 Konum</option>
                                        <option value="fa-building" {{ (!is_array(config('site.footer.contact_address_icon')) && config('site.footer.contact_address_icon') == 'fa-building') ? 'selected' : '' }}>🏢 Bina</option>
                                        <option value="fa-home" {{ (!is_array(config('site.footer.contact_address_icon')) && config('site.footer.contact_address_icon') == 'fa-home') ? 'selected' : '' }}>🏠 Ev</option>
                                    </select>
                                </span>
                                <textarea class="form-control" id="footer_contact_address" name="footer_contact_address" rows="2">{{ is_array(config('site.footer.contact_address')) ? '' : config('site.footer.contact_address', 'İstanbul, Türkiye') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="footer_copyright_text" class="form-label text-white">Telif Hakkı Metni</label>
                            <input type="text" class="form-control" id="footer_copyright_text" name="footer_copyright_text" 
                                value="{{ is_array(config('site.footer.copyright_text')) ? '' : config('site.footer.copyright_text', '© ' . date('Y') . ' Parça Mağaza. Tüm hakları saklıdır.') }}">
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 