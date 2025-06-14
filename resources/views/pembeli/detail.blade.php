<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Rumah – InHouse</title>

  <!-- Hubungkan CSS Laravel -->
  <link rel="stylesheet" href="{{ asset('css/pembeli/styleDetail.css') }}"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

  <!-- DETAIL PROPERTI -->
  <section class="detail-property">
    <div class="gallery">
      <div class="main-image">
        <img src="{{ asset('images/pembeli/Rumah1.jpg') }}" alt="Rumah Detail" />
      </div>
      <div class="thumbs">
        <img src="{{ asset('images/pembeli/Rumah1.jpg') }}" alt="Thumb 1" class="active"/>
        <img src="{{ asset('images/pembeli/R1B1.jpg') }}" alt="Thumb 2"/>
        <img src="{{ asset('images/pembeli/R1B2.jpg') }}" alt="Thumb 3"/>
        <img src="{{ asset('images/pembeli/R1B3.jpg') }}" alt="Thumb 4"/>
        <img src="{{ asset('images/pembeli/R1B4.jpg') }}" alt="Thumb 5"/>
        <img src="{{ asset('images/pembeli/R1B5.jpg') }}" alt="Thumb 6"/>
        <img src="{{ asset('images/pembeli/R1B6.jpg') }}" alt="Thumb 7"/>
        <img src="{{ asset('images/pembeli/R1B7.jpg') }}" alt="Thumb 8"/>
      </div>
    </div>

    <div class="info">
      <h2>Rumah Modern Minimalis</h2>
      <p class="location">PAREPARE, SULAWESI SELATAN</p>
      <p class="price">Rp 800.000.000,00</p>
      <p class="price-words">(Delapan Ratus Juta Rupiah)</p>
      <div class="property-details">
        <span><i class="fas fa-bed"></i> 2</span>
        <span><i class="fas fa-bath"></i> 1</span>
        <span><i class="fas fa-ruler-combined"></i> 90 M²</span>
        <span><i class="fas fa-check-circle"></i> Lulus Uji</span>
      </div>
      <div class="actions">
        <a href="{{ url('/transaksi') }}" class="btn-primary">Beli</a>
        <button class="btn-secondary">Simpan</button>
      </div>
    </div>
  </section>

  <!-- Detail Properti -->
  <section class="detail-info">
    <h3>Detail Properti</h3>
    <ul>
      <li><strong>Alamat:</strong> Jl. Semesta C4-20, Ujung, Parepare, Sulawesi Selatan</li>
      <li><strong>Status Listing:</strong> Dijual cepat, siap huni</li>
      <li><strong>Harga:</strong> Rp 800.000.000,00<br/><em>(Delapan ratus juta rupiah)</em></li>
    </ul>
  </section>

  <!-- Spesifikasi -->
  <section class="spec-table">
    <h3>Spesifikasi</h3>
    <table>
      <thead>
        <tr><th>Fitur</th><th>Rincian</th></tr>
      </thead>
      <tbody>
        <tr><td>Luas Tanah</td><td>90 m²</td></tr>
        <tr><td>Luas Bangunan</td><td>± 45–55 m<sup>2</sup>*</td></tr>
        <tr><td>Kamar Tidur</td><td>2</td></tr>
        <tr><td>Kamar Mandi</td><td>1</td></tr>
        <tr><td>Carport</td><td>Muat 1 mobil</td></tr>
        <tr><td>Tingkat</td><td>1 lantai</td></tr>
        <tr><td>Status Legalitas</td><td>Lulus Uji / IMB lengkap</td></tr>
      </tbody>
    </table>
  </section>

  <!-- Hubungkan JS Laravel -->
  <script src="{{ asset('js/pembeli/script.js') }}"></script>
</body>
</html>