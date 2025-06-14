<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'InHouse') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/Home_direct/search_dashboard.css') }}">
    @yield('styles')
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <a href="{{ url('/') }}" title="InHouse">
                    <img src="{{ asset('images/logo-yellow.png') }}" alt="InHouse Logo">
                </a>
            </div>
            <div class="sidebar-icons">
                <a href="{{ url('dashboard_search') }}" class="icon {{ Request::is('dashboard_search') ? 'active' : '' }}" title="Beranda">
                    <i class="fas fa-house"></i>
                </a>
                <a href="{{ url('Dokumen') }}" class="icon {{ Request::is('Dokumen') ? 'active' : '' }}" title="Dokumen">
                    <i class="fas fa-file-lines"></i>
                </a>
                <a href="{{ url('simpan') }}" class="icon {{ Request::is('simpan') ? 'active' : '' }}" title="Tersimpan">
                    <i class="fas fa-bookmark"></i>
                </a>
                <a href="{{ url('chat') }}" class="icon {{ Request::is('chat') ? 'active' : '' }}" title="Chat">
                    <i class="fas fa-message"></i>
                </a>
            </div>
            <div class="sidebar-bottom">
                <a href="{{ url('Agen_Properti/Rumah') }}" class="icon upload-icon {{ Request::is('Agen_Properti/Rumah*') ? 'active' : '' }}" title="Upload Properti">
                    <i class="fas fa-upload"></i>
                </a>
                <a href="{{ url('data') }}" class="icon {{ Request::is('data') ? 'active' : '' }}" title="Profil">
                    <i class="fas fa-user"></i>
                </a>
                <a href="{{ url('notifications') }}" class="icon {{ Request::is('notifications') ? 'active' : '' }}" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                </a>
            </div>
        </div>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
