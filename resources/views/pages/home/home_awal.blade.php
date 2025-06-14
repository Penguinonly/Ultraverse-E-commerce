@extends('layouts.template')

@push('css')
<link rel="stylesheet" href="{{ asset('css/In_Home.css') }}">
@endpush

@section('title', 'InHouse - Home')

@section('content')

  <section class="hero">
    <div class="container hero-content">
      <h1 class="hero-title">Welcome to <span class="italic">InHouse</span></h1>
      <p class="hero-subtitle">Your journey to a new home begins here. Trust us to make it seamless, secure, and successful.</p>
      <a href="#" class="btn-search">Search for properties</a>
    </div>
  </section>

  <div class="container">
    <section class="section">
      <img src="{{ asset('images/In_Home/pexels-elevate-digital-784230-1647907.jpg') }}" alt="Team discussing real estate">
      <div class="section-text">
        <h2>Melangkah bersama kami</h2>
        <p>Memangkah bukanlah hal yang mudah untuk mencari hunian yang tepat. Oleh karena itu, InHouse hadir untuk mempermudah perjalanan Anda menemukan rumah impian. Temukan properti terpercaya, dokumen terverifikasi, dan fitur pencarian yang intuitif. Semua dalam satu. Ayo mulai jelajahi rumah idaman Anda bersama InHouse hari ini!</p>
      </div>
    </section>

    <section class="section reverse">
      <img src="{{ asset('images/In_Home/pexels-fauxels-3184291.jpg') }}" alt="Meeting and Handshake">
      <div class="section-text">
        <h2>Sedang mencari atau ingin menjual rumah?</h2>
        <p>Dimanapun Anda berada, kami siap membantu. Anda bisa mengakses listing rumah terbaik, menjangkau pembeli potensial, dan memaksimalkan nilai properti Anda dengan mudah.</p>
      </div>
    </section>
  </div>

@endsection
