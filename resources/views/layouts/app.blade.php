<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    
    @yield('meta')
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Ana Renkler */
            --primary-color: #e31837;
            --primary-hover: #c41430;
            --secondary-color: #333333;
            --secondary-hover: #444444;
            
            /* Arka Plan Renkleri */
            --bg-primary: #111111;
            --bg-secondary: #1a1a1a;
            --bg-dark: #000000;
            
            /* Metin Renkleri */
            --text-primary: #ffffff;
            --text-secondary: #cccccc;
            --text-light: #ffffff;
            
            /* Kenar Çizgisi Renkleri */
            --border-color: #333333;
            --border-hover: #444444;
            
            /* Diğer Renkler */
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.7;
        }

        /* Navbar Styles */
        .navbar {
            background-color: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: var(--text-primary) !important;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .nav-link {
            color: var(--text-primary) !important;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--text-light);
        }

        /* Card Styles */
        .card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
        }

        .card-header {
            background-color: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid var(--border-color);
            color: var(--text-light);
        }

        /* Form Styles */
        .form-control {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .form-control:focus {
            background-color: var(--bg-secondary);
            border-color: var(--primary-color);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.25rem rgba(227, 24, 55, 0.25);
        }

        /* Form text styling */
        .form-check-label, .text-center, p, .form-text {
            color: var(--text-light);
        }

        /* Placeholder text */
        ::placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
            opacity: 1;
        }

        :-ms-input-placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        ::-ms-input-placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        /* Input text color */
        input, textarea, select {
            color: var(--text-light) !important;
        }

        /* Table Styles */
        .table {
            color: var(--text-primary);
        }

        .table th {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .table td {
            border-color: var(--border-color);
        }
        
        /* Ensure all table content has white text */
        table, tr, td, th, table span, table div, .table, .table-dark, .table-dark td {
            color: #fff !important;
        }
        
        /* Fix any text that might be inheriting other colors in tables */
        td *, th *, .table *, .table span, .table div, .table p {
            color: #fff !important;
        }
        
        /* Only exception is for text that should be styled differently */
        td .text-gray-400, 
        td .text-secondary,
        td .text-primary,
        td .text-danger,
        td .text-success,
        td .text-info,
        td .text-warning {
            color: inherit !important;
        }

        /* Footer Styles */
        footer {
            background-color: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            padding: 3rem 0;
            margin-top: 3rem;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 14px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 7px;
            border: 3px solid var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }

        /* Utility Classes */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }

        .pagination .page-link {
            color: var(--primary-color);
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--text-light);
        }

        .dropdown-menu {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .dropdown-item {
            color: var(--text-primary) !important;
        }

        .dropdown-item:hover {
            background-color: var(--bg-primary);
            color: var(--primary-color) !important;
        }

        .dropdown-divider {
            border-color: var(--border-color);
        }

        /* Header Styles */
        .top-bar {
            background-color: var(--secondary-color) !important;
            border-bottom: 1px solid var(--border-color);
            padding: 15px 0;
        }

        .navbar {
            padding: 0.75rem 0;
            background-color: var(--bg-primary) !important;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-nav {
            width: 100%;
            display: flex;
            justify-content: space-around;
        }

        .navbar-nav .nav-item {
            flex: 1 1 auto;
            text-align: center;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar .nav-link {
            color: var(--text-primary) !important;
            padding: 0.75rem 1rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .navbar .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .search-form {
            width: 100%;
        }

        /* Responsive Düzenlemeler */
        @media (max-width: 991.98px) {
            .top-bar {
                padding: 10px 0;
            }
            
            .top-bar .col-lg-3,
            .top-bar .col-lg-6 {
                margin-bottom: 0.5rem;
            }
            
            .top-bar .justify-content-end {
                justify-content: center !important;
            }
            
            .navbar-nav {
                margin-top: 0.5rem;
            }
            
            .navbar .nav-item {
                text-align: center;
            }
            
            .mega-menu {
                position: static;
                width: 100%;
                max-height: 300px;
                overflow-y: auto;
            }
        }

        /* Dropdown hover styles */
        .has-megamenu {
            position: static;
        }

        .has-megamenu:hover .dropdown-menu {
            display: block;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .mega-menu {
            position: absolute;
            left: 0;
            right: 0;
            padding: 1rem;
            margin-top: 0;
            border: none;
            border-radius: 0;
            background: var(--bg-primary);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
            color: var(--text-primary);
        }

        .dropdown-header {
            color: var(--text-primary);
            font-weight: 600;
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.5rem;
        }

        .dropdown-item small {
            opacity: 0.7;
            margin-left: 0.5rem;
        }

        /* Subheadings Styles */
        h1, h2, h3, h4, h5, h6,
        .h1, .h2, .h3, .h4, .h5, .h6,
        .form-label, legend, caption,
        .dropdown-header, .card-title {
            color: var(--text-light);
        }

        @media (max-width: 991.98px) {
            .mega-menu {
                position: static;
                transform: none;
                padding: 0;
            }
            
            .has-megamenu:hover .dropdown-menu {
                transform: none;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header>
        <!-- Top Bar -->
        <div class="top-bar py-3 bg-secondary">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-lg-2 col-6 mb-2 mb-lg-0">
                        <div class="d-flex align-items-center">
                            <a class="text-white text-decoration-none" href="{{ route('home') }}">
                                @if(file_exists(public_path('images/logo.png')))
                                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="img-fluid me-2" style="max-height: 40px;">
                                @elseif(file_exists(public_path('images/logo.jpg')))
                                    <img src="{{ asset('images/logo.jpg') }}" alt="{{ config('app.name') }}" class="img-fluid me-2" style="max-height: 40px;">
                                @else
                                    <i class="fas fa-cog text-primary me-2"></i>
                                @endif
                                <span class="fw-bold fs-4">{{ config('app.name') }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Toggle Button (Sadece Mobil) -->
                    <div class="col-6 d-lg-none text-end">
                        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                            <i class="fas fa-bars text-white"></i>
                        </button>
                    </div>

                    <!-- Arama Formu -->
                    <div class="col-lg-7 col-md-7 mb-2 mb-lg-0">
                        <form class="d-flex search-form" action="{{ route('parts.search') }}" method="GET">
                            <div class="input-group">
                                <input class="form-control" type="search" name="q" placeholder="Parça ara..." required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Kullanıcı Alanı -->
                    <div class="col-lg-3 col-md-5">
                        <div class="d-flex justify-content-end align-items-center">
                        @auth
                                <a href="{{ route('profile.favorites') }}" class="text-white text-decoration-none me-4">
                                    <i class="fas fa-heart fs-5"></i>
                                </a>
                                <a href="{{ route('cart.index') }}" class="text-white text-decoration-none me-4 position-relative">
                                    <i class="fas fa-shopping-cart fs-5"></i>
                                    @if(auth()->user()->cart && auth()->user()->cart->itemCount() > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            {{ auth()->user()->cart->itemCount() }}
                                        </span>
                                    @endif
                            </a>
                            <a href="{{ route('profile.show') }}" class="text-white text-decoration-none">
                                    <i class="fas fa-user fs-5 me-1"></i><span class="d-none d-md-inline-block">{{ Str::limit(Auth::user()->name, 10) }}</span>
                            </a>
                        @else
                                <a href="{{ route('login') }}" class="text-white text-decoration-none me-4">
                                    <i class="fas fa-sign-in-alt fs-5 me-1"></i><span class="d-none d-md-inline-block">Giriş Yap</span>
                            </a>
                            <a href="{{ route('register') }}" class="text-white text-decoration-none">
                                    <i class="fas fa-user-plus fs-5 me-1"></i><span class="d-none d-md-inline-block">Kayıt Ol</span>
                            </a>
                        @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header - Markalar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav mx-auto">
                        @foreach($brands as $brand)
                        <li class="nav-item dropdown has-megamenu">
                            <a class="nav-link" href="#" data-bs-toggle="dropdown">
                                {{ $brand->name }}
                            </a>
                            <div class="dropdown-menu mega-menu">
                                <h6 class="dropdown-header">{{ $brand->name }} Modelleri</h6>
                                @foreach($brand->models as $model)
                                <a class="dropdown-item" href="{{ route('parts.index', ['model' => $model->slug]) }}">
                                    {{ $model->name }}
                                    @if($model->year_start || $model->year_end)
                                    <small class="text-secondary">
                                        {{ $model->year_start ?? '' }} {{ $model->year_end ? '- '.$model->year_end : '' }}
                                    </small>
                                    @endif
                                </a>
                                @endforeach
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Flash Messages -->
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-white mb-3">{{ is_array(config('site.footer.company_name')) ? config('app.name') : config('site.footer.company_name', config('app.name')) }}</h5>
                    <p class="text-gray mb-0">{{ is_array(config('site.footer.company_description')) ? config('app.description', 'Araç parçaları için güvenilir adresiniz.') : config('site.footer.company_description', config('app.description', 'Araç parçaları için güvenilir adresiniz.')) }}</p>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h5 class="text-white mb-3">Bağlantılar</h5>
                    <div class="row">
                        <div class="col-6">
                            @php
                                $mainLinks = \App\Models\FooterLink::where('column', 'main')
                                    ->where('is_active', true)
                                    ->orderBy('position')
                                    ->get();
                                
                                $supportLinks = \App\Models\FooterLink::where('column', 'support')
                                    ->where('is_active', true)
                                    ->orderBy('position')
                                    ->get();
                            @endphp
                            
                            @if($mainLinks->count() > 0)
                                <ul class="list-unstyled">
                                    @foreach($mainLinks as $link)
                                        <li>
                                            <a href="{{ $link->url }}" class="text-gray text-decoration-none">
                                                {{ $link->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        
                        <div class="col-6">
                            @if($supportLinks->count() > 0)
                    <ul class="list-unstyled">
                                    @foreach($supportLinks as $link)
                                        <li>
                                            <a href="{{ $link->url }}" class="text-gray text-decoration-none">
                                                {{ $link->title }}
                                            </a>
                                        </li>
                                    @endforeach
                    </ul>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h5 class="text-white mb-3">{{ is_array(config('site.footer.contact_heading')) ? 'İletişim' : config('site.footer.contact_heading', 'İletişim') }}</h5>
                    <ul class="list-unstyled text-gray mb-0">
                        @if(!is_array(config('site.footer.contact_phone')))
                        <li><i class="fas {{ !is_array(config('site.footer.contact_phone_icon')) ? config('site.footer.contact_phone_icon', 'fa-phone') : 'fa-phone' }} me-2"></i>{{ config('site.footer.contact_phone') }}</li>
                        @endif
                        
                        @if(!is_array(config('site.footer.contact_email')))
                        <li><i class="fas {{ !is_array(config('site.footer.contact_email_icon')) ? config('site.footer.contact_email_icon', 'fa-envelope') : 'fa-envelope' }} me-2"></i>{{ config('site.footer.contact_email') }}</li>
                        @endif
                        
                        @if(!is_array(config('site.footer.contact_address')))
                        <li><i class="fas {{ !is_array(config('site.footer.contact_address_icon')) ? config('site.footer.contact_address_icon', 'fa-map-marker-alt') : 'fa-map-marker-alt' }} me-2"></i>{{ config('site.footer.contact_address') }}</li>
                        @endif
                    </ul>
                    
                    @php
                        $socialLinks = \App\Models\FooterLink::where('column', 'social')
                            ->where('is_active', true)
                            ->orderBy('position')
                            ->get();
                    @endphp
                    
                    @if($socialLinks->count() > 0)
                        <div class="mt-3">
                            @foreach($socialLinks as $link)
                                <a href="{{ $link->url }}" class="btn btn-outline-light btn-sm me-2 mb-2" target="_blank" rel="noopener">
                                    <i class="fab fa-{{ strtolower(str_replace(['http://', 'https://', 'www.', '.com'], '', parse_url($link->url, PHP_URL_HOST))) }} me-1"></i>
                                    {{ $link->title }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <hr class="border-dark">
            
            <div class="row">
                <div class="col-md-6 text-gray">
                    <p class="mb-0">{{ is_array(config('site.footer.copyright_text')) ? '© ' . date('Y') . ' Parça Mağaza. Tüm hakları saklıdır.' : config('site.footer.copyright_text', '© ' . date('Y') . ' Parça Mağaza. Tüm hakları saklıdır.') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    @php
                        $legalLinks = \App\Models\FooterLink::where('column', 'legal')
                            ->where('is_active', true)
                            ->orderBy('position')
                            ->get();
                    @endphp
                    
                    @if($legalLinks->count() > 0)
                        <div class="text-gray">
                            @foreach($legalLinks as $link)
                                <a href="{{ $link->url }}" class="text-gray text-decoration-none me-3">
                                    {{ $link->title }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <script>
    // Remove data-bs-toggle attribute on desktop
    function updateDropdownBehavior() {
        const dropdownLinks = document.querySelectorAll('.has-megamenu .nav-link');
        if (window.innerWidth >= 992) {
            dropdownLinks.forEach(link => {
                link.removeAttribute('data-bs-toggle');
            });
        } else {
            dropdownLinks.forEach(link => {
                link.setAttribute('data-bs-toggle', 'dropdown');
            });
        }
    }

    // Update on load and resize
    window.addEventListener('load', updateDropdownBehavior);
    window.addEventListener('resize', updateDropdownBehavior);
    </script>
</body>
</html>