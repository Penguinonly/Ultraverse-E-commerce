<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">▶</button>
    <div class="menu-item {{ Request::is('/') ? 'active' : '' }}">
        <i class="fas fa-home"></i><span>Beranda</span>
    </div>
    <div class="menu-item {{ Request::routeIs('user.*') ? 'active' : '' }}">
        <i class="fas fa-user"></i><span>User</span>
    </div>
    <div class="menu-item {{ Request::routeIs('dokumen') ? 'active' : '' }}">
        <i class="fas fa-file-alt"></i><span>Legalitas</span>
    </div>
    <div class="menu-item">
        <i class="fas fa-wallet"></i><span>Transaksi</span>
    </div>
    <div class="menu-item {{ Request::routeIs('jadwal.*') ? 'active' : '' }}">
        <i class="fas fa-calendar-days"></i><span>Jadwal</span>
    </div>
    <div class="menu-item">
        <i class="fas fa-briefcase"></i><span>Riwayat</span>
    </div>
    <div class="menu-item">
        <i class="fas fa-envelope"></i><span>Kotak Masuk</span>
    </div>
    <div class="menu-item {{ Request::routeIs('chat') ? 'active' : '' }}">
        <i class="fas fa-comment-dots"></i><span>Pesan</span>
    </div>
    <div class="spacer"></div>
    <div class="menu-item">
        <i class="fas fa-cog"></i><span>Pengaturan</span>
    </div>
    <form method="POST" action="{{ route('auth.logout') }}" style="margin: 0;">
        @csrf
        <button type="submit" class="menu-item" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left; padding: 10px 16px;">
            <i class="fas fa-right-from-bracket"></i><span>Keluar</span>
        </button>
    </form>
</div>
