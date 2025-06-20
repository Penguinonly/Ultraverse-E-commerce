<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Beranda Penjual</title>
  <link rel="stylesheet" href="{{ asset('css/Agen_Properti/beranda.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="sidebar">
      <div class="sidebar-icons">
          <div class="icon active"><i class="fas fa-home"></i></div>
          <div class="icon"><i class="fas fa-credit-card"></i></div>
          <div class="icon"><i class="fas fa-bookmark"></i></div>
          <div class="icon"><i class="fas fa-comments"></i></div>
          <div class="spacer"></div>
          <div class="icon"><i class="fas fa-user"></i></div>
          <div class="icon"><i class="fas fa-bell"></i></div>
          </div>
      </div>

  <!-- Main Content -->
  <div class="main">
    <div class="section-title">Status Properti</div>
    <div class="status-boxes">
      <div class="status-box">
        <h3>Proses</h3>
        <p>0</p>
      </div>
      <div class="status-box">
        <h3>Disetujui</h3>
        <p>0</p>
      </div>
      <div class="status-box">
        <h3>Dilihat</h3>
        <p>0</p>
      </div>
      <div class="status-box">
        <h3>Tawaran</h3>
        <p>0</p>
      </div>
      <div class="status-box">
        <h3>Akad</h3>
        <p>0</p>
      </div>
    </div>

    <div class="section-title">Properti Saya</div>
    <div class="property-list">
      <!-- Card 1 -->
      <div class="property-card">
        <div class="property-image"></div>
        <div class="property-info">
          <div class="property-title">Dijual cepat rumah 2 lt. di Kav. Polri Jelambar Jakarta Barat LT/LB = 254m²/300 m²</div>
          <div class="property-location">JELAMBAR, JAKARTA BARAT</div>
          <div class="property-price">Rp. 600.000.000,00</div>
          <div class="property-features">4 🛏️ | 3 🚽 | 254 M2 | ✅ Lulus Uji</div>
          <div class="property-actions">
            <div class="btn">Ubah</div>
            <div class="btn">Hapus</div>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="property-card">
        <div class="property-image"></div>
        <div class="property-info">
          <div class="property-title">Dijual cepat rumah 2 lt. di Kav. Polri Jelambar Jakarta Barat LT/LB = 254m²/300 m²</div>
          <div class="property-location">JELAMBAR, JAKARTA BARAT</div>
          <div class="property-price">Rp. 770.000.000,00</div>
          <div class="property-features">4 🛏️ | 3 🚽 | 254 M2 | ✅ Lulus Uji</div>
          <div class="property-actions">
            <div class="btn">Ubah</div>
            <div class="btn">Hapus</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
