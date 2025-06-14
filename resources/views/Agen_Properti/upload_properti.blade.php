<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Rumah - InHouse</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Agen_Properti/upload_properti.css') }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-icons">
                <a href="{{ route('dashboard_search') }}" class="icon">
                    <i class="fas fa-home"></i>
                </a>
                <a href="{{ route('dokumen') }}" class="icon">
                    <i class="fas fa-file-alt"></i>
                </a>
                <a href="{{ route('simpan') }}" class="icon">
                    <i class="fas fa-bookmark"></i>
                </a>
                <a href="{{ route('chat') }}" class="icon">
                    <i class="fas fa-comments"></i>
                </a>
                <a href="{{ route('properti.upload') }}" class="icon active">
                    <i class="fas fa-upload"></i>
                </a>
                <div class="spacer"></div>
                <a href="{{ route('user.data') }}" class="icon">
                    <i class="fas fa-user"></i>
                </a>
                <a href="{{ route('notifications') }}" class="icon">
                    <i class="fas fa-bell"></i>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <a href="{{ route('dashboard_search') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Upload Rumah</span>
                </a>
            </div>

            <!-- Tab Navigation -->
            <div class="tabs">
                <a href="{{ route('properti.upload', ['section' => 'rumah']) }}" 
                   class="tab {{ $section === 'rumah' ? 'active' : '' }}">Rumah</a>
                <a href="{{ route('properti.upload', ['section' => 'dokumen']) }}" 
                   class="tab {{ $section === 'dokumen' ? 'active' : '' }}">Dokumen</a>
                <a href="{{ route('properti.upload', ['section' => 'jadwal']) }}" 
                   class="tab {{ $section === 'jadwal' ? 'active' : '' }}">Jadwal</a>
            </div>

            <!-- Form Sections -->
            @if($section === 'rumah')
            <form id="rumahForm" class="upload-form" action="{{ route('properti.save.rumah') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Foto rumah</label>
                    <div class="photo-upload" onclick="document.getElementById('foto').click()">
                        <input type="file" id="foto" name="foto[]" multiple accept="image/*" style="display: none">
                        <div class="upload-box">
                            <span class="plus">+</span>
                            <span>Tambah Foto</span>
                        </div>
                    </div>
                    <div id="preview" class="photo-preview"></div>
                </div>

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" placeholder="Masukkan Nama Rumah kamu" required>
                </div>

                <div class="form-group">
                    <label>Luas Bangunan</label>
                    <input type="text" name="luas_bangunan" placeholder="Masukkan Luas Bangunan kamu" required>
                </div>

                <div class="form-group">
                    <label>Unit</label>
                    <select name="unit" required>
                        <option value="">Pilih Unit</option>
                        <option value="rumah">Rumah</option>
                        <option value="apartemen">Apartemen</option>
                        <option value="ruko">Ruko</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" placeholder="Atur harga yang pas buat kamu" required>
                </div>

                <div class="form-group">
                    <label>Lokasi</label>
                    <select name="lokasi" required>
                        <option value="">Pilih Lokasi</option>
                        <option value="parepare">Parepare</option>
                        <option value="makassar">Makassar</option>
                        <option value="toraja">Toraja</option>
                    </select>
                </div>

                <button type="submit" class="next-btn">Selanjutnya</button>
            </form>
            @endif

            @if($section === 'dokumen')
            <form id="dokumenForm" class="upload-form" action="{{ route('properti.save.dokumen') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Sertifikat</label>
                    <div class="photo-upload" onclick="document.getElementById('sertifikat').click()">
                        <input type="file" id="sertifikat" name="dokumen[]" accept=".pdf,.doc,.docx" style="display: none">
                        <div class="photo-box">+ Tambah Dokumen</div>
                    </div>
                </div>

                <h2 class="section-title">Dokumen Pemilik</h2>

                <div class="form-group">
                    <label>KTP Pemilik</label>
                    <div class="photo-upload" onclick="document.getElementById('ktp').click()">
                        <input type="file" id="ktp" name="ktp" accept="image/*" style="display: none">
                        <div class="photo-box">+ Tambah Foto</div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Kartu Keluarga (KK)</label>
                    <div class="photo-upload" onclick="document.getElementById('kk').click()">
                        <input type="file" id="kk" name="kk" accept="image/*" style="display: none">
                        <div class="photo-box">+ Tambah Foto</div>
                    </div>
                </div>

                <button type="submit" class="next-btn">Selanjutnya</button>
            </form>
            @endif

            @if($section === 'jadwal')
            <form id="jadwalForm" class="schedule-form" action="{{ route('properti.save.jadwal') }}" method="POST">
                @csrf
                <section class="inspection-section">
                    <label class="checkbox-container">
                        <input type="checkbox" id="agreement" name="agreement" required>
                        <span>Saya menyetujui Syarat dan Ketentuan Inspeksi.</span>
                    </label>
                    
                    <div class="info-box">
                        <p>Jenis Inspeksi yang akan dilakukan:</p>
                        <ul>
                            <li>Struktur Bangunan</li>
                            <li>Instalasi Listrik & Air</li>
                            <li>Atap & Talang Air</li>
                            <li>Drainase</li>
                            <li>HVAC (Pemanas, Ventilasi, dan AC)</li>
                            <li>Keamanan Kebakaran</li>
                            <li>Aksesibilitas & Keselamatan Penghuni</li>
                            <li>Survey Tanah & Geoteknik</li>
                        </ul>
                    </div>
                </section>

                <section class="date-time-section">
                    <h2>Preferensi tanggal & waktu</h2>
                    <div class="datetime-wrapper">
                        <div class="form-group">
                            <label for="tanggal">Pilih Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="waktu">Pilih Waktu</label>
                            <select id="waktu" name="waktu" required>
                                <option value="">-- Pilih Waktu --</option>
                                <option value="09:00">09:00</option>
                                <option value="11:00">11:00</option>
                                <option value="13:00">13:00</option>
                                <option value="15:00">15:00</option>
                            </select>
                        </div>
                    </div>
                </section>

                <button type="submit" class="upload-btn">Upload</button>
            </form>
            @endif
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Photo preview for Rumah section
        const fotoInput = document.getElementById('foto');
        if (fotoInput) {
            fotoInput.addEventListener('change', function() {
                const preview = document.getElementById('preview');
                preview.innerHTML = '';
                
                [...this.files].forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                        preview.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            });
        }

        // Form submission handling
        ['rumahForm', 'dokumenForm', 'jadwalForm'].forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    try {
                        const formData = new FormData(this);
                        const response = await fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const result = await response.json();
                        if (result.status === 'success') {
                            window.location.href = result.redirect;
                        } else {
                            alert(result.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
