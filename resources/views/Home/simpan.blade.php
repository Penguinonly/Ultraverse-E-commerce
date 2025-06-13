<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Properti</title>
  <link rel="stylesheet" href="{{ asset('css/simpan/styleSimpan.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-icons">
        <div class="icon"><a href="{{ url('dashboard_search') }}"><i class="fas fa-home"></i></a></div>
        <div class="icon"><i class="fas fa-file-alt"></i></div>
        <div class="icon active"><a href="{{ url('simpan') }}"><i class="fas fa-bookmark"></i></a></div>
        <div class="icon"><i class="fas fa-comments"></i></div>
        <div class="spacer"></div>
        <div class="icon"><i class="fas fa-user"></i></div>
        <div class="icon"><i class="fas fa-bell"></i></div>
      </div>
    </aside>

    <!-- Main content -->
    <main class="main">
      <!-- Search Bar -->
      <div class="search-container">
        <div class="search-bar">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Search" />
          <button class="search-btn">Search</button>
        </div>
        <div class="filter-options">
          <button class="filter-btn">
            <i class="fas fa-map-marker-alt"></i>
            Location
          </button>
          <button class="filter-btn">
            <i class="fas fa-dollar-sign"></i>
            Price
          </button>
        </div>
      </div>

      <!-- Listings -->
      <!-- ... -->
<section class="listings">
  <!-- Card contoh -->
  <div class="card">
    <!-- ganti "Simpan Rumah1" dengan path file nyata -->
    <img src="{{ asset('images/simpan/Simpan Rumah1.jpg') }}" alt="Logo Hitam" class="logo-img">
    <div class="card-body">
      <h3>Rumah Minimalis Modern</h3>
      <p class="location">PAREPARE, SULAWESI SELATAN</p>
      <div class="property-details">
          <span><i class="fas fa-bed"></i> 2</span>
          <span><i class="fas fa-bath"></i> 1</span>
          <span><i class="fas fa-ruler-combined"></i> 90 M²</span>
          <span><i class="fas fa-check-circle"></i> Lulus Uji</span>
      </div>
      <div class="actions">
        <button class="btn buy">Beli</button>
        <button class="btn save">Hapus</button>
      </div>
    </div>
  </div>
  <!-- duplikat card sesuai kebutuhan -->
</section>
    </main>
  </div>
</body>
</html>
