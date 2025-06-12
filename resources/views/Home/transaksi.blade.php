<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Transaksi Properti</title>
  <link rel="stylesheet" href="styleTrans.css" />
</head>
<body>
  <div class="container">
    <!-- HEADER -->
    <header class="header">
      <a href="../Dashboard/search.html" aria-label="Kembali">&larr;</a>
      <h1>Transaksi Properti</h1>
    </header>

    <!-- NAV TABS -->
    <nav class="tabs">
      <button class="tab active" data-target="tab-data">Pengisian Data</button>
      <button class="tab" data-target="tab-dokumen">Dokumen</button>
      <button class="tab" data-target="tab-rincian">Rincian</button>
    </nav>

    <!-- TAB CONTENT: DATA -->
    <div id="tab-data" class="tab-content active">
      <form class="form">
        <!-- Data Diri -->
        <section class="form-section">
          <h2>Data Diri</h2>
          <div class="form-group">
            <label for="ktp">Nomor KTP</label>
            <input type="text" id="ktp" name="ktp" placeholder="Masukkan nomor KTP" />
          </div>
          <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" />
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="contoh@domain.com" />
          </div>
          <div class="form-group">
            <label for="telp">Nomor Telepon</label>
            <input type="tel" id="telp" name="telp" placeholder="08xx-xxxx-xxxx" />
          </div>
          <div class="form-group">
            <label for="alamat">Address</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
          </div>
        </section>
        <!-- Data Pengajuan -->
        <section class="form-section">
          <h2>Data Pengajuan</h2>
          <div class="form-group">
            <label for="harga">Harga Properti</label>
            <input type="text" id="harga" name="harga" value="Rp 800.000.000,00" readonly />
          </div>
          <div class="form-group">
            <label for="uangmuka">Uang Muka</label>
            <input type="text" id="uangmuka" name="uangmuka" value="Rp 10.000.000,00" readonly />
          </div>
          <div class="form-group">
            <label for="jenis">Jenis pembayaran</label>
            <select id="jenis" name="jenis">
              <option value="" disabled selected>Pilih jenis pembayaran</option>
              <option value="cash">Cash</option>
              <option value="kpr">KPR</option>
            </select>
          </div>
        </section>
        <button type="submit" class="btn-next">Selanjutnya</button>
      </form>
    </div>

    <!-- TAB CONTENT: DOKUMEN -->
    <div id="tab-dokumen" class="tab-content">
  <form class="form-doc">
    <h2 class="section-title">Dokumen Pemilik</h2>
        <div class="doc-group">
      <label for="ktp-img">KTP Pemilik</label>
      <div class="upload-box" id="preview-ktp">
        <input type="file" id="ktp-img" accept="image/*" hidden />
        <label for="ktp-img" class="upload-label">+ Tambah Foto</label>
      </div>
    </div>
        <div class="doc-group">
      <label for="pasfoto-img">Pas Foto</label>
      <div class="upload-box" id="preview-pas">
        <input type="file" id="pasfoto-img" accept="image/*" hidden />
        <label for="pasfoto-img" class="upload-label">+ Tambah Foto</label>
      </div>
    </div>
        <div class="doc-group">
      <label for="kk-img">Kartu Keluarga (KK)</label>
      <div class="upload-box" id="preview-kk">
        <input type="file" id="kk-img" accept="image/*" hidden />
        <label for="kk-img" class="upload-label">+ Tambah Foto</label>
      </div>
    </div>
        <p class="agree-text">Saya menyetujui Syarat dan Ketentuan.</p>
        <div class="terms-box">
          <p>Dengan melengkapi formulir ini, Calon pembeli dan penjual telah menyatakan bahwa:</p>
          <ul>
            <li>Semua informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan.</li>
            <li>Pembeli memiliki kemampuan finansial yang cukup untuk melakukan transaksi pembelian properti yang diminati.</li>
            <li>Pembeli bersedia mengikuti seluruh proses dan ketentuan pembelian properti yang berlaku di InHouse.</li>
          </ul>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-text">
            <input class="form-check-input mt-0" type="checkbox" value="" label for="agree-terms"> Saya menyetujui Syarat dan Ketentuan</div>
          </div>
        <button type="button" class="btn-next" id="btn-doc-next" disabled>Selanjutnya</button>
      </form>
    </div>

    <!-- TAB CONTENT: RINCIAN -->
    <div id="tab-rincian" class="tab-content">
      <div class="section">
        <div class="section-header">Informasi Detail</div>
        <div class="section-body">
          <div class="detail-row">
            <div class="detail-label">Suku Bunga per tahun</div>
            <div class="detail-value">3%</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Masa Cicilan</div>
            <div class="detail-value">120 Bulan</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Jumlah Pinjaman</div>
            <div class="detail-value">Rp 800.000,00</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Uang Muka</div>
            <div class="detail-value">Rp 10.000.000,00</div>
          </div>
        </div>
      </div>
      <div class="section">
        <div class="section-header">Biaya Notaris</div>
        <div class="section-body notaris-list">
          <div class="detail-row">
            <div class="detail-label">Akta Jual Beli</div>
            <div class="detail-value">Rp 5.000.000,00</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Bea Balik Nama</div>
            <div class="detail-value">Rp 5.000.000,00</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Akta SKMHT</div>
            <div class="detail-value">Rp 2.000.000,00</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Cek Sertifikat dan Legalitas</div>
            <div class="detail-value">Rp 10.000.000,00</div>
          </div>
          <div class="detail-row">
            <div class="detail-label">Inspeksi Bangunan</div>
            <div class="detail-value">Rp 3.000.000,00</div>
          </div>
        </div>
      </div>
      <div class="summary">
        <div class="summary-item">
          <h3>Angsuran Per Bulan</h3>
          <div class="amount">Rp 7.628.240,00</div>
        </div>
        <div class="summary-item">
          <h3>Pembayaran Pertama</h3>
          <div class="amount">Rp 25.000.000,00</div>
        </div>
        <div class="summary-note">(Angsuran + DP + Biaya Notaris)</div>
      </div>
      <div class="button-group">
        <button class="btn cancel">Batal</button>
        <button class="btn pay">Bayar</button>
      </div>
    </div>

  </div>

  <script>
    // Simple tab switcher
    document.querySelectorAll('.tab').forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.dataset.target;
        document.querySelectorAll('.tab, .tab-content').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(target).classList.add('active');
      });
    });
  </script>
</body>
</html>
