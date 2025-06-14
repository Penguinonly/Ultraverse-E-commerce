<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman Penjual Properti</title>
  <link rel="stylesheet" href="css/sidebar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="app">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <button class="toggle-btn" onclick="toggleSidebar()">▶</button>
      <div class="menu-item active"><i class="fas fa-home"></i><span>Beranda</span></div>
      <div class="menu-item"><i class="fas fa-folder-plus"></i><span>Properti Baru</span></div>
      <div class="menu-item"><i class="fas fa-wallet"></i><span>Transaksi</span></div>
      <div class="menu-item"><i class="fas fa-envelope"></i><span>Pesan</span></div>
      <div class="menu-item"><i class="fas fa-bell"></i><span>Notifikasi</span></div>
      <div class="spacer"></div>
      <div class="menu-item"><i class="fas fa-cog"></i><span>Pengaturan</span></div>
      <div class="menu-item"><i class="fas fa-right-from-bracket"></i><span>Keluar</span></div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
    }
  </script>
</body>
</html>
