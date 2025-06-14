@extends('layouts.app')

@section('title', 'Upload Rumah - Dokumen')

@section('styles')
<link href="{{ asset('css/Agen_Properti/Dokumen.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <header>
        <button class="back" onclick="history.back()">&larr;</button>
        <h1>Upload Rumah</h1>
    </header>

    <nav class="tab-nav">
        <a class="tab" href="{{ route('rumah.index') }}">Rumah</a>
        <a class="tab active" href="{{ route('dokumen.index') }}">Dokumen</a>
        <a class="tab" href="{{ route('jadwal.index') }}">Jadwal</a>
    </nav>

    <form class="upload-form" method="POST" action="{{ route('dokumen.store') }}" enctype="multipart/form-data">
        @csrf
        <h2 class="section-title">Dokumen Kepemilikan & Legalitas</h2>

        <div class="form-group">
            <label>Sertifikat Tanah / SHM / HGB</label>
            <div class="photo-box" data-input="sertifikat">+ Tambah Foto</div>
            <input type="file" name="sertifikat" hidden>
        </div>

        <div class="form-group">
            <label>IMB / PBG</label>
            <div class="photo-box" data-input="imb">+ Tambah Foto</div>
            <input type="file" name="imb" hidden>
        </div>

        <div class="form-group">
            <label>SPPT PBB</label>
            <div class="photo-box" data-input="sppt">+ Tambah Foto</div>
            <input type="file" name="sppt" hidden>
        </div>

        <div class="form-group">
            <label>Bukti Pembayaran Pajak 5 Tahun Terakhir</label>
            <div class="photo-box" data-input="pajak">+ Tambah Foto</div>
            <input type="file" name="pajak" hidden>
        </div>

        <div class="form-group">
            <label>Akta Jual Beli (jika rumah dibeli dari orang lain sebelumnya)</label>
            <div class="photo-box" data-input="akta">+ Tambah Foto</div>
            <input type="file" name="akta" hidden>
        </div>

        <h2 class="section-title">Dokumen Pemilik</h2>

        <div class="form-group">
            <label>KTP Pemilik</label>
            <div class="photo-box" data-input="ktp">+ Tambah Foto</div>
            <input type="file" name="ktp" hidden>
        </div>

        <div class="form-group">
            <label>Kartu Keluarga (KK)</label>
            <div class="photo-box" data-input="kk">+ Tambah Foto</div>
            <input type="file" name="kk" hidden>
        </div>

        <button class="next-btn" type="submit">Selanjutnya</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
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
