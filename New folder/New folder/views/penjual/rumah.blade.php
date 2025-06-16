<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Rumah</title>
  <link rel="stylesheet" href="{{ asset('css/Agen_Properti/rumah.css') }}">
</head>
<body>

  <div class="container">
    <header>
      <button class="back">&larr;</button>
      <h1>Upload Rumah</h1>
    </header>

    <nav class="tab-nav">
      <a class="tab" href="rumah.blade.php">Rumah</a>
      <a class="tab" href="dokumen.blade.php">Dokumen</a>
      <a class="tab" href="jadwal.blade.php">Jadwal</a>
    </nav>

    <form class="upload-form">
      <div class="form-group photo-upload">
        <label>Foto rumah</label>
        <div class="photo-box">+ Tambah Foto</div>
      </div>

      <div class="form-group">
        <label>Judul</label>
        <input type="text" placeholder="Masukkan Nama Rumah kamu">
      </div>

      <div class="form-group">
        <label>Luas Bangunan</label>
        <input type="text" placeholder="Masukkan Luas Bangunan kamu">
      </div>

      <div class="form-group">
        <label>Unit</label>
        <select>
          <option>Pilih Unit</option>
        </select>
      </div>

      <div class="form-group">
        <label>Harga</label>
        <input type="text" placeholder="Atur harga yang pas buat kamu">
      </div>

      <div class="form-group">
        <label>Lokasi</label>
        <select>
          <option>Pilih Lokasi</option>
        </select>
      </div>

      <button class="next-btn" type="submit">Selanjutnya</button>
    </form>
  </div>

</body>
</html>
