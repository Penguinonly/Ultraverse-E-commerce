<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Rumah - Dokumen</title>
  <link rel="stylesheet" href="{{ asset('css/Agen_Properti/dokumen.css') }}">
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

      <h2 class="section-title">Dokumen Kepemilikan & Legalitas</h2>

      <div class="form-group">
        <label>Sertifikat Tanah / SHM / HGB</label>
        <div class="photo-box">+ Tambah Foto</div>
      </div>

      <div class="form-group">
        <label>IMB / PBG</label>
        <div class="photo-box">+ Tambah Foto</div>
      </div>

      <div class="form-group">
        <label>SPPT PBB</label>
        <div class="photo-box">+ Tambah Foto</div>
      </div>

      <div class="form-group">
        <label>Bukti Pembayaran Pajak 5 Tahun Terakhir</label>
        <div class="photo-box">+ Tambah Foto</div>
      </div>

      <div class="form-group">
        <label>Akta Jual Beli (jika rumah dibeli dari orang lain sebelumnya)</label>
        <div class="photo-box">+ Tambah Foto</div>
      </div>

      <h2 class="section-title">Dokumen Pemilik</h2>

      <div class="form-group">
        <label>KTP Pemilik</label>
        <div class="photo-box">+ Tambah Foto</div>
      </div>

      <div class="form-group">
        <label>Kartu Keluarga (KK)</label>
        <div class="photo-box">+ Tambah Foto</div>
      </div>

      <button class="next-btn" type="submit">Selanjutnya</button>
    </form>
  </div>

</body>
</html>
