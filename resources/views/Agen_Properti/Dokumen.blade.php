@extends('layouts.app')

@section('title', 'Upload Rumah')

@section('styles')
    <link href="{{ asset('css/shared/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Agen_Properti/Dokumen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Agen_Properti/Jadwal.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="app">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="toggle-btn" onclick="toggleSidebar()">▶</button>
        <a href="{{ url('/') }}" class="menu-item {{ Request::is('/') ? 'active' : '' }}">
            <i class="fas fa-home"></i><span>Beranda</span>
        </a>
        <a href="{{ route('dokumen') }}" class="menu-item {{ Request::routeIs('dokumen') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i><span>Legalitas</span>
        </a>
        <a href="{{ route('jadwal.index') }}" class="menu-item {{ Request::routeIs('jadwal.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-days"></i><span>Jadwal</span>
        </a>
        <a href="{{ route('chat') }}" class="menu-item {{ Request::routeIs('chat') ? 'active' : '' }}">
            <i class="fas fa-comment-dots"></i><span>Pesan</span>
        </a>
        <div class="spacer"></div>
        <a href="{{ route('profile.show') }}" class="menu-item {{ Request::routeIs('profile.*') ? 'active' : '' }}">
            <i class="fas fa-user"></i><span>Profil</span>
        </a>
        <form method="POST" action="{{ route('auth.logout') }}" class="menu-item">
            @csrf
            <button type="submit" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                <i class="fas fa-right-from-bracket"></i><span>Keluar</span>
            </button>
        </form>
    </div>

    <div class="main-content">
        <header>
            <button class="back" onclick="history.back()">&larr;</button>
            <h1>Upload Rumah</h1>
        </header>

        <nav class="tab-nav">
            <a class="tab" href="{{ route('rumah.index') }}">Rumah</a>
            <a class="tab" href="{{ route('dokumen.index') }}">Dokumen</a>
            <a class="tab" href="{{ route('jadwal.index') }}">Jadwal</a>
        </nav>

        <!-- Form Upload Dokumen -->
        <form class="upload-form" method="POST" action="{{ route('dokumen.store') }}" enctype="multipart/form-data">
            @csrf
            <h2 class="section-title">Dokumen Kepemilikan & Legalitas</h2>

            @foreach ([
                'sertifikat' => 'Sertifikat Tanah / SHM / HGB',
                'imb' => 'IMB / PBG',
                'sppt' => 'SPPT PBB',
                'pajak' => 'Bukti Pembayaran Pajak 5 Tahun Terakhir',
                'akta' => 'Akta Jual Beli (jika rumah dibeli dari orang lain sebelumnya)',
            ] as $name => $label)
                <div class="form-group">
                    <label>{{ $label }}</label>
                    <div class="photo-box" data-input="{{ $name }}">+ Tambah Foto</div>
                    <input type="file" name="{{ $name }}" hidden>
                </div>
            @endforeach

            <h2 class="section-title">Dokumen Pemilik</h2>

            @foreach ([
                'ktp' => 'KTP Pemilik',
                'kk' => 'Kartu Keluarga (KK)',
            ] as $name => $label)
                <div class="form-group">
                    <label>{{ $label }}</label>
                    <div class="photo-box" data-input="{{ $name }}">+ Tambah Foto</div>
                    <input type="file" name="{{ $name }}" hidden>
                </div>
            @endforeach

            <button class="next-btn" type="submit">Upload Dokumen</button>
        </form>

        <hr>

        <!-- Form Jadwal -->
        <form class="schedule-form" method="POST" action="{{ route('jadwal.store') }}">
            @csrf
            <section class="inspection-section">
                <label class="checkbox-container">
                    <input type="checkbox" id="agreement" name="agreement" required 
                        @if(old('agreement')) checked @endif>
                    Saya menyetujui Syarat dan Ketentuan Inspeksi.
                </label>

                <div class="info-box">
                    <h3>Jenis Inspeksi yang akan dilakukan:</h3>
                    <ul>
                        <li><i class="fas fa-building"></i> Struktur Bangunan</li>
                        <li><i class="fas fa-bolt"></i> Instalasi Listrik & Air</li>
                        <li><i class="fas fa-home"></i> Atap & Talang Air</li>
                        <li><i class="fas fa-water"></i> Drainase</li>
                        <li><i class="fas fa-wind"></i> HVAC (Pemanas, Ventilasi, dan AC)</li>
                        <li><i class="fas fa-fire-extinguisher"></i> Keamanan Kebakaran</li>
                        <li><i class="fas fa-universal-access"></i> Aksesibilitas & Keselamatan Penghuni</li>
                        <li><i class="fas fa-mountain"></i> Survey Tanah & Geoteknik</li>
                    </ul>
                </div>
            </section>

            <section class="date-time-section">
                <h2>Preferensi tanggal & waktu</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Pilih Tanggal</label>
                        <input type="date" id="date" name="date" class="form-control" required 
                            min="{{ date('Y-m-d') }}" value="{{ old('date') }}">
                    </div>

                    <div class="form-group">
                        <label for="time">Pilih Waktu</label>
                        <select id="time" name="time" class="form-control" required>
                            <option value="">-- Pilih Waktu --</option>
                            @foreach (['09:00','11:00','13:00','15:00'] as $time)
                                <option value="{{ $time }}" @if(old('time') == $time) selected @endif>{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Kirim Jadwal</button>
                <button type="button" class="btn-secondary" onclick="history.back()">Kembali</button>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('collapsed');
    }

    document.querySelectorAll('.photo-box').forEach(box => {
        const input = box.parentElement.querySelector('input[type="file"]');
        box.addEventListener('click', () => input.click());
        input.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                box.classList.add('has-file');
                box.textContent = e.target.files[0].name;
            }
        });
    });
</script>
@endsection
