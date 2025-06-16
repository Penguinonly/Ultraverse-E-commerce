<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'InHouse') }} - @yield('title', '')</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/In_Home/Logo.png') }}" type="image/x-icon"/>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Common CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/sidebar.css') }}">
    
    <!-- Authentication CSS -->
    @guest
        <link rel="stylesheet" href="{{ asset('css/Login/sign.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Login/create.css') }}">
    @endguest
    
    <!-- Role-specific CSS -->
    @auth
        @if(auth()->user()->role === 'admin')
            <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
        @elseif(auth()->user()->role === 'penjual')
            <link rel="stylesheet" href="{{ asset('css/Agen_Properti/beranda.css') }}">
            <link rel="stylesheet" href="{{ asset('css/Agen_Properti/data.css') }}">
            <link rel="stylesheet" href="{{ asset('css/Agen_Properti/Dokumen.css') }}">
            <link rel="stylesheet" href="{{ asset('css/Agen_Properti/Jadwal.css') }}">
            <link rel="stylesheet" href="{{ asset('css/Transaksi.css') }}">
        @elseif(auth()->user()->role === 'pembeli')
            <link rel="stylesheet" href="{{ asset('css/simpan/styleSimpan.css') }}">
            <link rel="stylesheet" href="{{ asset('css/Transaksi.css') }}">
        @endif
    @endauth
    
    <!-- Feature-specific CSS -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Chabot/chat.css') }}">
    
    <!-- Home Pages CSS -->
    @if(Request::is('/') || Request::is('aboutUS') || Request::is('service'))
        <link rel="stylesheet" href="{{ asset('css/Home_direct/In_Home.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Home_direct/aboutUS.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Home_direct/services.css') }}">
    @endif
    
    <!-- Property Pages CSS -->
    @if(Request::is('properti*'))
        <link rel="stylesheet" href="{{ asset('css/Home_direct/search_dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Home_direct/detail_dashboard.css') }}">
    @endif
    
    <!-- Additional CSS -->
    @stack('styles')
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    @if(auth()->check() && !Request::is('/') && !Request::is('aboutUS') && !Request::is('service'))
        <div class="container">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="sidebar-logo">
                    <a href="{{ route('home') }}" title="InHouse">
                        <img src="{{ asset('images/logo-yellow.png') }}" alt="InHouse Logo">
                    </a>
                </div>
                <div class="sidebar-icons">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="icon {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                            <i class="fas fa-chart-line"></i>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="icon {{ Request::routeIs('admin.users.*') ? 'active' : '' }}" title="Users">
                            <i class="fas fa-users"></i>
                        </a>
                        <a href="{{ route('admin.properti.index') }}" class="icon {{ Request::routeIs('admin.properti.*') ? 'active' : '' }}" title="Properties">
                            <i class="fas fa-home"></i>
                        </a>
                        <a href="{{ route('admin.transaksi.index') }}" class="icon {{ Request::routeIs('admin.transaksi.*') ? 'active' : '' }}" title="Transactions">
                            <i class="fas fa-money-bill-wave"></i>
                        </a>
                    @elseif(auth()->user()->role === 'penjual')
                        <a href="{{ route('penjual.dashboard') }}" class="icon {{ Request::routeIs('penjual.dashboard') ? 'active' : '' }}" title="Dashboard">
                            <i class="fas fa-house"></i>
                        </a>
                        <a href="{{ route('penjual.properti.index') }}" class="icon {{ Request::routeIs('penjual.properti.*') ? 'active' : '' }}" title="My Properties">
                            <i class="fas fa-building"></i>
                        </a>
                        <a href="{{ route('penjual.transaksi.index') }}" class="icon {{ Request::routeIs('penjual.transaksi.*') ? 'active' : '' }}" title="Transactions">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </a>
                    @else
                        <a href="{{ route('pembeli.dashboard') }}" class="icon {{ Request::routeIs('pembeli.dashboard') ? 'active' : '' }}" title="Dashboard">
                            <i class="fas fa-house"></i>
                        </a>
                        <a href="{{ route('properti.index') }}" class="icon {{ Request::routeIs('properti.*') ? 'active' : '' }}" title="Browse Properties">
                            <i class="fas fa-search"></i>
                        </a>
                        <a href="{{ route('pembeli.favorit') }}" class="icon {{ Request::routeIs('pembeli.favorit') ? 'active' : '' }}" title="Saved Properties">
                            <i class="fas fa-bookmark"></i>
                        </a>
                        <a href="{{ route('pembeli.transaksi.index') }}" class="icon {{ Request::routeIs('pembeli.transaksi.*') ? 'active' : '' }}" title="My Transactions">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </a>
                    @endif
                    
                    <a href="{{ route('pesan.index') }}" class="icon {{ Request::routeIs('pesan.*') ? 'active' : '' }}" title="Messages">
                        <i class="fas fa-message"></i>
                    </a>
                </div>
                <div class="sidebar-bottom">
                    @if(auth()->user()->role === 'penjual')
                        <a href="{{ route('penjual.properti.create') }}" class="icon upload-icon" title="Add Property">
                            <i class="fas fa-upload"></i>
                        </a>
                    @endif
                    <a href="{{ route('profile') }}" class="icon {{ Request::routeIs('profile') ? 'active' : '' }}" title="Profile">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="{{ route('notifications') }}" class="icon {{ Request::routeIs('notifications') ? 'active' : '' }}" title="Notifications">
                        <i class="fas fa-bell"></i>
                        @if(session('unread_notifications_count', 0) > 0)
                            <span class="notification-badge">{{ session('unread_notifications_count') }}</span>
                        @endif
                    </a>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    @else
        @yield('content')
    @endif
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
