{{-- resources/views/layouts/penjual/sidebar.blade.php --}}
<div class="app">
  <div class="sidebar" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">▶</button>

    {{-- Beranda --}}
    <a href="{{ route('penjual.dashboard') }}"
       class="menu-item @if(request()->routeIs('penjual.dashboard')) active @endif">
      <i class="fas fa-home"></i>
      <span>Beranda</span>
    </a>

    {{-- Transaksi --}}
    <a href="{{ route('penjual.transaksi.index') }}"
       class="menu-item @if(request()->is('penjual/transaksi*')) active @endif">
      <i class="fas fa-wallet"></i>
      <span>Transaksi</span>
    </a>

    {{-- Favorit --}}
    <a href="{{ route('penjual.favorit') }}"
       class="menu-item @if(request()->routeIs('penjual.favorit')) active @endif">
      <i class="fas fa-bookmark"></i>
      <span>Favorit</span>
    </a>

    {{-- Kotak Masuk --}}
    <a href="{{ route('penjual.inbox') }}"
       class="menu-item @if(request()->routeIs('penjual.inbox')) active @endif">
      <i class="fas fa-envelope"></i>
      <span>Kotak Masuk</span>
    </a>

    {{-- Pesan --}}
    <a href="{{ route('penjual.pesan') }}"
       class="menu-item @if(request()->routeIs('penjual.pesan')) active @endif">
      <i class="fas fa-comment-dots"></i>
      <span>Pesan</span>
    </a>

    <div class="spacer"></div>

    {{-- Pengaturan --}}
    <a href="{{ route('penjual.pengaturan') }}"
       class="menu-item @if(request()->routeIs('penjual.pengaturan')) active @endif">
      <i class="fas fa-cog"></i>
      <span>Pengaturan</span>
    </a>

    {{-- Logout --}}
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       class="menu-item">
      <i class="fas fa-right-from-bracket"></i>
      <span>Keluar</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </div>
</div>

{{-- Script toggler bisa kamu letakkan di master.blade.php penjual --}}
@push('scripts')
<script>
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
  }
</script>
@endpush
