<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Rumah - Detail Properti</title>
  <link rel="stylesheet" href="{{ asset('css/Agen_Properti/Rumah.css') }}">
</head>
<body>

  <div class="container">
    <header>
      <button class="back" onclick="history.back()">&larr;</button>
      <h1>Upload Rumah</h1>
    </header>

    <nav class="tab-nav">
      <a class="tab active" href="{{ route('rumah.index') }}">Rumah</a>
      <a class="tab" href="{{ route('dokumen.index') }}">Dokumen</a>
      <a class="tab" href="{{ route('jadwal.index') }}">Jadwal</a>
    </nav>

    <form class="upload-form" method="POST" action="{{ route('rumah.store') }}" enctype="multipart/form-data">
        @csrf
        <h2 class="section-title">Foto Properti</h2>

        <div class="photos-grid">
            <div class="photo-box main-photo" data-input="main_photo">
                + Foto Utama
                <input type="file" name="main_photo" hidden accept="image/*">
            </div>
            @for ($i = 1; $i <= 6; $i++)
            <div class="photo-box" data-input="photo_{{ $i }}">
                + Tambah Foto
                <input type="file" name="photos[]" hidden accept="image/*">
            </div>
            @endfor
        </div>

        <h2 class="section-title">Detail Properti</h2>

        <div class="form-group">
            <label>Judul Properti</label>
            <input type="text" name="title" placeholder="Contoh: Rumah Minimalis 2 Lantai di Antang" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" rows="4" placeholder="Deskripsikan properti Anda secara detail..." required></textarea>
        </div>

        <div class="price-section">
            <div class="form-group">
                <label>Harga</label>
                <div class="input-group">
                    <span class="prefix">Rp</span>
                    <input type="number" name="price" placeholder="Masukkan harga" required>
                </div>
            </div>

            <div class="form-group">
                <label>Cicilan per Bulan</label>
                <div class="input-group">
                    <span class="prefix">Rp</span>
                    <input type="number" name="monthly_installment" placeholder="Masukkan cicilan per bulan">
                </div>
            </div>
        </div>

        <h2 class="section-title">Spesifikasi</h2>

        <div class="specs-grid">
            <div class="form-group">
                <label>Luas Tanah</label>
                <div class="input-group">
                    <input type="number" name="land_size" required>
                    <span class="suffix">m²</span>
                </div>
            </div>

            <div class="form-group">
                <label>Luas Bangunan</label>
                <div class="input-group">
                    <input type="number" name="building_size" required>
                    <span class="suffix">m²</span>
                </div>
            </div>

            <div class="form-group">
                <label>Kamar Tidur</label>
                <input type="number" name="bedrooms" required>
            </div>

            <div class="form-group">
                <label>Kamar Mandi</label>
                <input type="number" name="bathrooms" required>
            </div>

            <div class="form-group">
                <label>Garasi</label>
                <input type="number" name="garages" required>
            </div>

            <div class="form-group">
                <label>Carport</label>
                <input type="number" name="carports" required>
            </div>
        </div>

        <h2 class="section-title">Lokasi</h2>

        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap properti..." required></textarea>
        </div>

        <div class="location-grid">
            <div class="form-group">
                <label>Provinsi</label>
                <select name="province" required>
                    <option value="">Pilih Provinsi</option>
                    <!-- Add options dynamically -->
                </select>
            </div>

            <div class="form-group">
                <label>Kota/Kabupaten</label>
                <select name="city" required>
                    <option value="">Pilih Kota/Kabupaten</option>
                    <!-- Add options dynamically -->
                </select>
            </div>

            <div class="form-group">
                <label>Kecamatan</label>
                <select name="district" required>
                    <option value="">Pilih Kecamatan</option>
                    <!-- Add options dynamically -->
                </select>
            </div>

            <div class="form-group">
                <label>Kelurahan/Desa</label>
                <select name="village" required>
                    <option value="">Pilih Kelurahan/Desa</option>
                    <!-- Add options dynamically -->
                </select>
            </div>
        </div>

        <button class="next-btn" type="submit">Selanjutnya</button>
    </form>
  </div>

</body>
</html>
