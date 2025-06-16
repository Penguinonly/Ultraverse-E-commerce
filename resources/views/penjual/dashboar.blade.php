@extends('layouts.penjual.master')

@section('title', 'Beranda Penjual')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/penjual.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<div class="main">
  <div class="section-title">Status Properti</div>
  <div class="status-boxes">
    <div class="status-box">
      <h3>Proses</h3>
      <p>0</p>
    </div>
    <div class="status-box">
      <h3>Disetujui</h3>
      <p>0</p>
    </div>
    <div class="status-box">
      <h3>Dilihat</h3>
      <p>0</p>
    </div>
    <div class="status-box">
      <h3>Tawaran</h3>
      <p>0</p>
    </div>
    <div class="status-box">
      <h3>Akad</h3>
      <p>0</p>
    </div>
  </div>

  <div class="section-title">Properti Saya</div>
  <div class="property-list">
    <!-- Card 1 -->
    <div class="property-card">
      <div class="property-image"></div>
      <div class="property-info">
        <div class="property-title">Dijual cepat rumah 2 lt. di Kav. Polri Jelambar Jakarta Barat LT/LB = 254m²/300 m²</div>
        <div class="property-location">JELAMBAR, JAKARTA BARAT</div>
        <div class="property-price">Rp. 600.000.000,00</div>
        <div class="property-features">4 🛏️ | 3 🚽 | 254 M2 | ✅ Lulus Uji</div>
        <div class="property-actions">
          <div class="btn">Ubah</div>
          <div class="btn">Hapus</div>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="property-card">
      <div class="property-image"></div>
      <div class="property-info">
        <div class="property-title">Dijual cepat rumah 2 lt. di Kav. Polri Jelambar Jakarta Barat LT/LB = 254m²/300 m²</div>
        <div class="property-location">JELAMBAR, JAKARTA BARAT</div>
        <div class="property-price">Rp. 770.000.000,00</div>
        <div class="property-features">4 🛏️ | 3 🚽 | 254 M2 | ✅ Lulus Uji</div>
        <div class="property-actions">
          <div class="btn">Ubah</div>
          <div class="btn">Hapus</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
