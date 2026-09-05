<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }} Admin Panel</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #1a1a1a;
            color: #fff;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #2d2d2d;
            padding: 1rem;
            overflow-y: auto;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }
        
        .nav-link {
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        
        .nav-link.active {
            background-color: #e31837;
            color: #fff;
        }
        
        .card {
            background-color: #2d2d2d;
            border: none;
            border-radius: 0.5rem;
        }
        
        .table {
            color: #fff;
        }
        
        .table th {
            border-color: #404040;
            background-color: #1f2937;
        }
        
        .table td {
            border-color: #404040;
            background-color: #2d2d2d;
        }
        
        .table thead, .table tfoot {
            background-color: #1f2937;
        }
        
        .btn-primary {
            background-color: #e31837;
            border-color: #e31837;
        }
        
        .btn-primary:hover {
            background-color: #c01530;
            border-color: #c01530;
        }
        
        /* Dark theme form elements */
        .form-control, .form-select {
            background-color: #1f2937 !important;
            border-color: #404040 !important;
            color: #fff !important;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: #1f2937 !important;
            border-color: #e31837 !important;
            color: #fff !important;
            box-shadow: 0 0 0 0.25rem rgba(227, 24, 55, 0.25) !important;
        }
        
        select.form-control option, .form-select option {
            background-color: #1f2937 !important;
            color: #fff !important;
        }
        
        .btn-outline-light {
            color: #fff;
            border-color: #4b5563;
        }
        
        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        
        .alert {
            border: 1px solid transparent;
        }
        
        .bg-light {
            background-color: #2d2d2d !important;
        }
        
        /* Badge styling */
        .badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
        }
        
        /* Table inputs */
        .table input.form-control,
        .table select.form-select,
        input, 
        select, 
        textarea {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #fff !important;
        }
        
        /* Small form boxes */
        input:read-only, 
        input:disabled,
        input[readonly],
        textarea:read-only,
        textarea:disabled,
        textarea[readonly] {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #fff !important;
            opacity: 0.8;
        }
        
        /* Info boxes */
        .bg-gray-800, 
        td .bg-light, 
        th .bg-light, 
        .table .bg-light {
            background-color: #1f2937 !important;
        }
        
        .border-secondary {
            border-color: #374151 !important;
        }
        
        .text-gray-400 {
            color: #9ca3af;
        }
        
        /* Fix for any Bootstrap generated components */
        .bg-white, .bg-body, .breadcrumb, .pagination {
            background-color: #2d2d2d !important;
        }
        
        .text-dark {
            color: #fff !important;
        }
        
        /* Fix for card backgrounds */
        .card, .card-header, .card-body, .card-footer {
            background-color: #2d2d2d !important;
        }
        
        /* Pagination styling */
        .page-link {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #fff !important;
        }
        
        .page-item.active .page-link {
            background-color: #e31837 !important;
            border-color: #e31837 !important;
        }
        
        /* Fix for breadcrumbs */
        .breadcrumb-item a {
            color: #9ca3af !important;
        }
        
        .breadcrumb-item.active {
            color: #fff !important;
        }
        
        /* Fix for tables */
        .table-striped>tbody>tr:nth-of-type(odd)>* {
            background-color: #1f2937 !important;
            color: #fff !important;
        }
        
        .table-hover tbody tr:hover {
            background-color: #374151 !important;
            color: #fff !important;
        }
        
        /* Ensure all inputs in tables have dark backgrounds */
        td input, td select, td textarea, 
        th input, th select, th textarea {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #fff !important;
        }
        
        /* Fix any remaining white backgrounds */
        [class*="bg-white"] {
            background-color: #2d2d2d !important;
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
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header mb-4">
            <h3>{{ config('app.name') }} Admin</h3>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i>
                    Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.parts.index') }}" class="nav-link {{ request()->routeIs('admin.parts.*') ? 'active' : '' }}">
                    <i class="fas fa-cogs me-2"></i>
                    Parçalar
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Siparişler
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder me-2"></i>
                    Kategoriler
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.brands.index') }}" class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                    <i class="fas fa-building me-2"></i>
                    Markalar
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.models.index') }}" class="nav-link {{ request()->routeIs('admin.models.*') ? 'active' : '' }}">
                    <i class="fas fa-car me-2"></i>
                    Modeller
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i>
                    Kullanıcılar
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.emails.index') }}" class="nav-link {{ request()->routeIs('admin.emails.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope me-2"></i>
                    E-posta Gönder
                </a>
            </li>
            
            <li class="nav-item">
                <a href="{{ route('admin.footer.index') }}" class="nav-link {{ request()->routeIs('admin.footer.*') ? 'active' : '' }}">
                    <i class="fas fa-sitemap me-2"></i>
                    Footer Ayarları
                </a>
            </li>
            

            <li class="nav-item mt-4">
                <a href="{{ route('home') }}" class="nav-link text-danger">
                    <i class="fas fa-arrow-left me-2"></i>
                    Siteye Dön
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>