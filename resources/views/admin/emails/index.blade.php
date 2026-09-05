@extends('layouts.admin')

@section('title', 'E-posta Gönder - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark border-0">
                <div class="card-header bg-dark border-0">
                    <h3 class="text-white mb-0">E-posta Gönder</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.emails.send') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="recipients" class="form-label text-white">Alıcılar</label>
                            <select class="form-select bg-gray-700 border-0 text-white" 
                                    id="recipients" 
                                    name="recipients"
                                    required>
                                <option value="">Alıcı Seçin</option>
                                <option value="all">Tüm Kullanıcılar</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('recipients')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white mb-3">E-posta Şablonu</label>
                            
                            <div class="template-selection">
                                <ul class="nav nav-tabs mb-3" id="templateTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="custom-tab" data-bs-toggle="tab" data-bs-target="#custom-content-tab" type="button" role="tab" aria-controls="custom-content-tab" aria-selected="true">
                                            <i class="fas fa-edit me-2"></i>Özel İçerik
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="templates-tab" data-bs-toggle="tab" data-bs-target="#templates-content-tab" type="button" role="tab" aria-controls="templates-content-tab" aria-selected="false">
                                            <i class="fas fa-layer-group me-2"></i>Hazır Şablonlar
                                        </button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content" id="templateTabContent">
                                    <!-- Özel İçerik Tab -->
                                    <div class="tab-pane fade show active" id="custom-content-tab" role="tabpanel" aria-labelledby="custom-tab">
                                        <div class="card bg-gray-800 border-0">
                                            <div class="card-body">
                                                <h5 class="card-title text-white mb-3">Özel E-posta İçeriği</h5>
                                                <p class="text-light mb-4">Kendi e-posta içeriğinizi oluşturun. E-posta konusu ve içeriğini aşağıdaki alanlara girerek tamamen özelleştirilmiş bir e-posta gönderebilirsiniz.</p>
                                                
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="radio" name="template_selection" id="select-custom" value="" checked>
                                                    <label class="form-check-label text-white" for="select-custom">
                                                        Özel içerik kullan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Hazır Şablonlar Tab -->
                                    <div class="tab-pane fade" id="templates-content-tab" role="tabpanel" aria-labelledby="templates-tab">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="text-white mb-0">Mevcut Şablonlar</h5>
                                            <a href="{{ route('admin.email-templates.create') }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-plus me-1"></i>Yeni Şablon Ekle
                                            </a>
                                        </div>
                                        
                                        <div class="row template-cards">
                                            @forelse($templates as $template)
                                            <div class="col-md-6 col-lg-4 mb-4">
                                                <div class="card template-card h-100 bg-gray-800 border-0">
                                                    <div class="card-header bg-template-{{ $loop->index % 4 }} text-center position-relative">
                                                        @if($template->name == 'Kampanya Fırsatları')
                                                            <i class="fas fa-tag fa-3x text-white mb-2 mt-2"></i>
                                                        @elseif($template->name == 'Hoş Geldiniz')
                                                            <i class="fas fa-hand-sparkles fa-3x text-white mb-2 mt-2"></i>
                                                        @elseif($template->name == 'Sipariş Onayı')
                                                            <i class="fas fa-check-circle fa-3x text-white mb-2 mt-2"></i>
                                                        @elseif($template->name == 'İndirim Kuponu')
                                                            <i class="fas fa-gift fa-3x text-white mb-2 mt-2"></i>
                                                        @else
                                                            <i class="fas fa-envelope fa-3x text-white mb-2 mt-2"></i>
                                                        @endif
                                                        <div class="template-badge">
                                                            <span class="badge bg-white text-dark">Şablon</span>
                                                        </div>
                                                    </div>
                                                    <div class="card-body d-flex flex-column">
                                                        <h5 class="card-title text-white mb-2">{{ $template->name }}</h5>
                                                        <p class="card-text text-light flex-grow-1">{{ Str::limit($template->description ?? 'Açıklama yok', 80) }}</p>
                                                        <div class="mt-2 mb-3">
                                                            <small class="text-muted d-block">Konu: {{ Str::limit($template->subject, 40) }}</small>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio" name="template_selection" id="select-template-{{ $template->id }}" value="{{ $template->id }}">
                                                            <label class="form-check-label text-white" for="select-template-{{ $template->id }}">
                                                                Bu şablonu seç
                                                            </label>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-light mt-2 preview-template" data-template-id="{{ $template->id }}">
                                                            <i class="fas fa-eye me-1"></i>Önizle
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="col-12">
                                                <div class="alert bg-gray-800 text-white">
                                                    <i class="fas fa-info-circle me-2"></i>Henüz hiç e-posta şablonu oluşturulmamış. 
                                                    <a href="{{ route('admin.email-templates-seed') }}" class="text-primary">Örnek şablonları oluşturmak için tıklayın</a> veya 
                                                    <a href="{{ route('admin.email-templates.create') }}" class="text-primary">yeni bir şablon ekleyin</a>.
                                                </div>
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Gizli input, seçilen şablonu saklar -->
                            <input type="hidden" name="template_id" id="template_id" value="">
                            @error('template_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="custom-content" class="mt-4">
                            <div class="mb-4">
                                <label for="subject" class="form-label text-white">Konu</label>
                                <input type="text" 
                                       class="form-control bg-gray-700 border-0 text-white @error('subject') is-invalid @enderror" 
                                       id="subject" 
                                       name="subject" 
                                       value="{{ old('subject') }}">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label text-white">Mesaj</label>
                                <textarea class="form-control bg-gray-700 border-0 text-white @error('message') is-invalid @enderror" 
                                          id="message" 
                                          name="message" 
                                          rows="10">{{ old('message') }}</textarea>
                                <small class="text-muted">
                                    Kullanabileceğiniz değişkenler: <code>{ad}</code>, <code>{email}</code>, <code>{site_adi}</code>
                                </small>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="template-preview" class="mb-4 p-3 border border-secondary rounded d-none">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-white mb-0">Şablon Önizleme</h5>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="edit-template-btn">
                                    <i class="fas fa-edit me-1"></i>Özelleştir
                                </button>
                            </div>
                            <div class="mb-3">
                                <label class="text-white mb-1">Konu:</label>
                                <p class="mb-0 text-white" id="preview-subject"></p>
                            </div>
                            <div>
                                <label class="text-white mb-1">İçerik:</label>
                                <div class="bg-gray-800 p-3 rounded text-light overflow-auto" style="max-height: 400px" id="preview-body"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Gönder
                            </button>
                        </div>
                    </form>

                    <!-- Özelleştirilen şablonun önizlemesi -->
                    <div id="custom-template-preview" class="mt-4 p-3 rounded bg-gray-800 border border-secondary d-none">
                        <h5 class="text-white mb-3">Özelleştirilen Şablon Önizlemesi</h5>
                        <div class="card bg-dark border-0">
                            <div class="card-header bg-dark border-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    <h6 class="text-white mb-0" id="live-preview-subject">E-posta Konusu</h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="bg-dark p-3 rounded text-white overflow-auto" style="max-height: 400px" id="live-preview-body">
                                    E-posta içeriği burada görünecek...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Basic styling for dropdown */
    .form-select {
        background-color: #374151 !important;
        border-color: #374151 !important;
        color: #fff !important;
    }
    
    .form-select option {
        background-color: #1f2937;
        color: #fff;
    }
    
    .bg-gray-800 {
        background-color: #1f2937;
    }
    
    #template-preview {
        background-color: rgba(55, 65, 81, 0.3);
    }
    
    /* Şablon kartları için stil */
    .template-card {
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
        border: 2px solid transparent !important;
    }
    
    .template-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    .template-card.active {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 1px #3b82f6, 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    /* Tab stilleri */
    .nav-tabs {
        border-bottom-color: #374151;
    }
    
    .nav-tabs .nav-link {
        background-color: rgba(55, 65, 81, 0.3);
        border-color: #374151;
        margin-right: 5px;
    }
    
    .nav-tabs .nav-link.active {
        background-color: #1f2937;
        border-color: #374151;
        border-bottom-color: #1f2937;
        color: #000 !important; /* Aktif sekme yazı rengi siyah */
    }
    
    .nav-tabs .nav-link:hover {
        border-color: #4b5563;
    }
    
    /* Şablon header renkleri */
    .bg-template-0 {
        background-color: #1e3a8a;
    }
    
    .bg-template-1 {
        background-color: #1e40af;
    }
    
    .bg-template-2 {
        background-color: #2e7d32;
    }
    
    .bg-template-3 {
        background-color: #9c27b0;
    }
    
    .template-badge {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    
    .form-check-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const templateSelectionInputs = document.querySelectorAll('input[name="template_selection"]');
    const templateIdInput = document.getElementById('template_id');
    const customContent = document.getElementById('custom-content');
    const templatePreview = document.getElementById('template-preview');
    const previewSubject = document.getElementById('preview-subject');
    const previewBody = document.getElementById('preview-body');
    const subjectInput = document.getElementById('subject');
    const messageInput = document.getElementById('message');
    const editTemplateBtn = document.getElementById('edit-template-btn');
    const previewButtons = document.querySelectorAll('.preview-template');
    
    // Canlı önizleme için gerekli elementler
    const customTemplatePreview = document.getElementById('custom-template-preview');
    const livePreviewSubject = document.getElementById('live-preview-subject');
    const livePreviewBody = document.getElementById('live-preview-body');
    
    // Özel içerik değiştiğinde canlı önizlemeyi güncelle
    subjectInput.addEventListener('input', updateLivePreview);
    messageInput.addEventListener('input', updateLivePreview);
    
    function updateLivePreview() {
        if (subjectInput.value || messageInput.value) {
            customTemplatePreview.classList.remove('d-none');
            livePreviewSubject.textContent = subjectInput.value || 'E-posta Konusu';
            livePreviewBody.innerHTML = messageInput.value ? messageInput.value.replace(/\n/g, '<br>') : 'E-posta içeriği...';
        } else {
            customTemplatePreview.classList.add('d-none');
        }
    }
    
    // Şablonlara ait radio button'lara tıklama
    templateSelectionInputs.forEach(input => {
        input.addEventListener('change', function() {
            const templateId = this.value;
            templateIdInput.value = templateId;
            
            if (templateId) {
                // Şablon seçildi, verilerini al ve önizle
                loadTemplatePreview(templateId);
                customTemplatePreview.classList.add('d-none'); // Özel içerik önizlemesini gizle
            } else {
                // Özel içerik seçildi
                templatePreview.classList.add('d-none');
                customContent.classList.remove('d-none');
                updateLivePreview(); // Özel içerik önizlemesini güncelle
            }
        });
    });
    
    // Şablon verilerini yükle ve önizle
    function loadTemplatePreview(templateId) {
        fetch(`/admin/email-templates/${templateId}/data`)
            .then(response => response.json())
            .then(data => {
                // Önizleme alanını göster
                templatePreview.classList.remove('d-none');
                customContent.classList.add('d-none');
                
                // Önizleme içeriğini doldur
                previewSubject.textContent = data.subject;
                previewBody.innerHTML = data.body;
                
                // Form alanlarına da değerleri ata (gizli olsa bile)
                subjectInput.value = data.subject;
                messageInput.value = data.body;
                
                // Şablon kartını active olarak işaretle
                const templateCards = document.querySelectorAll('.template-card');
                templateCards.forEach(card => {
                    if (card.querySelector(`#select-template-${templateId}`)) {
                        card.classList.add('active');
                    } else {
                        card.classList.remove('active');
                    }
                });
            })
            .catch(error => {
                console.error('Şablon verileri alınırken hata oluştu:', error);
            });
    }
    
    // Özelleştir butonuna tıklandığında
    editTemplateBtn.addEventListener('click', function() {
        // Şablon önizlemeyi gizle, özel içerik formunu göster
        templatePreview.classList.add('d-none');
        customContent.classList.remove('d-none');
        
        // Custom tab'ı aktif et
        var customTab = document.getElementById('custom-tab');
        customTab.click();
        
        // Özel içerik radio'yu seç
        document.getElementById('select-custom').checked = true;
        templateIdInput.value = '';
        
        // Canlı önizlemeyi güncelle
        updateLivePreview();
    });
    
    // Tab'lar arası geçişte radio button'ların durumunu güncelle
    document.getElementById('custom-tab').addEventListener('shown.bs.tab', function() {
        document.getElementById('select-custom').checked = true;
        templateIdInput.value = '';
        templatePreview.classList.add('d-none');
        customContent.classList.remove('d-none');
        
        // Özel içerik tab'ı açıldığında canlı önizlemeyi güncelle
        updateLivePreview();
    });
    
    // Şablon içeriklerini düzgün göstermek için tab gösterildiğinde boyut ayarla
    document.getElementById('templates-tab').addEventListener('shown.bs.tab', function() {
        // Eğer aktif bir şablon varsa, preview'ı göster
        const checkedTemplate = document.querySelector('input[name="template_selection"]:checked');
        if (checkedTemplate && checkedTemplate.value) {
            loadTemplatePreview(checkedTemplate.value);
        }
    });

    // Önizleme butonlarına tıklama
    previewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const templateId = this.dataset.templateId;
            
            // İlgili radio button'u seç
            const radioButton = document.getElementById('select-template-' + templateId);
            if (radioButton) {
                radioButton.checked = true;
                
                // Change event'ı tetikle
                const event = new Event('change');
                radioButton.dispatchEvent(event);
            }
        });
    });
});
</script>
@endpush

@endsection 