@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Home_direct/In_Home.css') }}">

<header>
  <div class="container nav">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ asset('images/In_Home/Logo.png') }}" alt="Logo Hitam" class="logo-img">
      InHouse
    </a>
    <nav class="nav-links">
      <a href="{{ route('home') }}" class="active">Home</a>
      <a href="{{ route('service') }}">Service</a>
      <a href="{{ route('aboutUS') }}">About us</a>
      <a href="{{ route('properti.index') }}">Properties</a>
    </nav>
    @guest
      <div class="auth-buttons">
        <a href="{{ route('login') }}" class="btn-login">Sign In</a>
        <a href="{{ route('register') }}" class="btn-register">Register</a>
      </div>
    @else
      <div class="auth-buttons">
        <a href="{{ route('dashboard') }}" class="btn-dashboard">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button type="submit" class="btn-logout">Logout</button>
        </form>
      </div>
    @endguest
  </div>
</header>

<section class="hero">
  <div class="container hero-content">
    <h1 class="hero-title">Welcome to <span class="italic">InHouse</span></h1>
    <p class="hero-subtitle">Your journey to a new home begins here. Trust us to make it seamless, secure, and successful.</p>
    <a href="{{ route('properti.search') }}" class="btn-search">Search for properties</a>
  </div>
</section>

<div class="container">
  <section class="section" id="featured-properties">
    <h2>Featured Properties</h2>
    <div class="property-grid">
      @forelse($featuredProperties as $property)
        <div class="property-card">
          <img src="{{ $property->foto_utama ? asset('storage/' . $property->foto_utama) : asset('images/placeholder.jpg') }}" alt="{{ $property->nama }}">
          <div class="property-info">
            <h3>{{ $property->nama }}</h3>
            <p class="price">Rp {{ number_format($property->harga, 0, ',', '.') }}</p>
            <p class="location">{{ $property->lokasi }}</p>
            <a href="{{ route('properti.show', $property->id) }}" class="btn-view">View Details</a>
          </div>
        </div>
      @empty
        <p class="no-properties">No featured properties available at the moment.</p>
      @endforelse
    </div>
  </section>

  <section class="section" id="about-us">
    <img src="{{ asset('images/In_Home/pexels-elevate-digital-784230-1647907.jpg') }}" alt="Team discussing real estate">
    <div class="section-text">
      <h2>Melangkah bersama kami</h2>
      <p>Memangkah bukanlah hal yang mudah untuk mencari hunian yang tepat. Oleh karena itu, InHouse hadir untuk mempermudah perjalanan Anda menemukan rumah impian...</p>
      <a href="{{ route('aboutUS') }}" class="btn-learn-more">Learn More</a>
    </div>
  </section>

  <section class="section reverse" id="services">
    <img src="{{ asset('images/In_Home/pexels-fauxels-3184291.jpg') }}" alt="Meeting and Handshake">
    <div class="section-text">
      <h2>Sedang mencari atau ingin menjual rumah?</h2>
      <p>Dimanapun Anda berada, kami siap membantu. Anda bisa mengakses listing rumah terbaik, menjangkau pembeli potensial, dan memaksimalkan nilai properti Anda dengan mudah.</p>
      <a href="{{ route('service') }}" class="btn-learn-more">Our Services</a>
    </div>
  </section>
</div>

<footer>
  <div class="container">
    <div class="footer-logo">
      <img src="{{ asset('images/In_Home/Logo.png') }}" alt="InHouse Logo" class="footer-logo-img">
      <span class="footer-brand">InHouse</span>
    </div>
    <nav class="footer-links">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('service') }}">Services</a>
      <a href="{{ route('aboutUS') }}">About Us</a>
      <a href="{{ route('properti.index') }}">Properties</a>
      @guest
        <a href="{{ route('login') }}">Sign In</a>
        <a href="{{ route('register') }}">Register</a>
      @endguest
    </nav>
    <p class="copyright">&copy; {{ date('Y') }} InHouse. All rights reserved.</p>
  </div>
</footer>
@endsection

