<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - InHouse</title>
    <link rel="stylesheet" href="{{ asset('css/Home_direct/search_dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-icons">
                <a href="{{ url('dashboard_search') }}" class="icon {{ Request::is('dashboard_search') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                </a>
                <a href="{{ url('Dokumen') }}" class="icon {{ Request::is('Dokumen') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                </a>
                <a href="{{ url('simpan') }}" class="icon {{ Request::is('simpan') ? 'active' : '' }}">
                    <i class="fas fa-bookmark"></i>
                </a>
                <a href="{{ url('chat') }}" class="icon {{ Request::is('chat') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                </a>
                <div class="spacer"></div>
                <a href="{{ url('data') }}" class="icon {{ Request::is('data') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                </a>
                <a href="{{ url('notifications') }}" class="icon {{ Request::is('notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Notifications</h1>
            <p>Notifications will appear here...</p>
        </div>
    </div>
</body>
</html>
