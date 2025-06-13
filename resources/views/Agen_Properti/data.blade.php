<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verifikasi Data Diri</title>
  <link rel="stylesheet" href="{{ asset('css/Agen_Properti/data.css') }}">
</head>
<body>
  <div class="container">
    <div class="back-arrow">&#8592;</div>
    <h2>Verifikasi data diri</h2>
    <form>
      <div class="form-row">
        <div class="form-group">
          <label for="first-name">First Name</label>
          <input type="text" id="first-name" placeholder="First Name">
        </div>
        <div class="form-group">
          <label for="last-name">Last Name</label>
          <input type="text" id="last-name" placeholder="Last Name">
        </div>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Email">
      </div>

      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" placeholder="Phone Number">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="dob">Date Birth</label>
          <select id="dob">
            <option value="">Pilih Tanggal Lahir</option>
          </select>
        </div>
        <div class="form-group">
          <label for="city">City</label>
          <select id="city">
            <option value="">Pilih Kota</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <input type="address" rows="3" placeholder="Address">
      </div>

      <div class="upload-section">
        <div>
          <label>Upload Foto KTP</label>
          <div class="upload-box">+ Tambah Foto</div>
        </div>

        <div>
          <label>Verifikasi Wajah</label>
          <div class="upload-box">+ Tambah Foto</div>
        </div>
      </div>

      <div class="checkbox-container">
        <input type="checkbox" id="terms">
        <label for="terms">Saya menyetujui Syarat dan Ketentuan.</label>
      </div>

      <div class="terms-box">
        <ul>
          <li>Semua info yang diberikan kepada kami adalah akurat.</li>
          <li>Penjual memiliki izin untuk menawarkan properti di 1nHouse.</li>
          <li>Apabila penjual memasukkan informasi palsu maka akan dikenakan sanksi sesuai ketentuan hukum.</li>
        </ul>
      </div>

      <button class="btn-submit" type="submit">Create Account</button>
    </form>
  </div>
</body>
</html>
