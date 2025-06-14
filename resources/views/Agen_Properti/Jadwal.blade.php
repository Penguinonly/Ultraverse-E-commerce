@extends('layouts.app')

@section('title', 'Upload Rumah - Jadwal')

@section('styles')
<link href="{{ asset('css/Agen_Properti/Jadwal.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="main-content">
    <header>
        <button class="back" onclick="history.back()">&larr;</button>
        <h1>Upload Rumah</h1>
    </header>

    <nav class="nav-tabs">
        <a href="{{ route('rumah.index') }}" class="tab">Rumah</a>
        <a href="{{ route('dokumen.index') }}" class="tab">Dokumen</a>
        <a href="{{ route('jadwal.index') }}" class="tab active">Jadwal</a>
    </nav>

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
                        <option value="09:00" @if(old('time') == '09:00') selected @endif>09:00</option>
                        <option value="11:00" @if(old('time') == '11:00') selected @endif>11:00</option>
                        <option value="13:00" @if(old('time') == '13:00') selected @endif>13:00</option>
                        <option value="15:00" @if(old('time') == '15:00') selected @endif>15:00</option>
                    </select>
                </div>
            </div>
        </section>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Upload</button>
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
@endsection
