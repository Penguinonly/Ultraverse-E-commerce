
<link rel="stylesheet" href="{{ asset('css/Home_direct/In_Home.css') }}">

<header>
  <div class="container nav">
    <a href="#" class="logo">
      <img src="{{ asset('images/In_Home/Logo.png') }}" alt="Logo Hitam" class="logo-img">
      InHouse
    </a>
    <nav class="nav-links">
      <a href="{{ url('/') }}">Home</a>
      <a href="#layanan">Service</a>
      <a href="#tentang" class="active">About us</a>
    </nav>
    <a href="{{ url('/create') }}" class="btn-login">Login</a>
  </div>
</header>

<section class="hero">
  <div class="container hero-content">
    <h1 class="hero-title">Welcome to <span class="italic">InHouse</span></h1>
    <p class="hero-subtitle">Your journey to a new home begins here. Trust us to make it seamless, secure, and successful.</p>
    <a href="#" class="btn-search">Search for properties</a>
  </div>
</section>

<div class="container">
  <section class="section" id="tentang">
    <img src="{{ asset('images/In_Home/pexels-elevate-digital-784230-1647907.jpg') }}" alt="Team discussing real estate">
    <div class="section-text">
      <h2>Melangkah bersama kami</h2>
      <p>Memangkah bukanlah hal yang mudah untuk mencari hunian yang tepat. Oleh karena itu, InHouse hadir untuk mempermudah perjalanan Anda menemukan rumah impian...</p>
    </div>
  </section>

  <section class="section reverse" id="layanan">
    <img src="{{ asset('images/In_Home/pexels-fauxels-3184291.jpg') }}" alt="Meeting and Handshake">
    <div class="section-text">
      <h2>Sedang mencari atau ingin menjual rumah?</h2>
      <p>Dimanapun Anda berada, kami siap membantu. Anda bisa mengakses listing rumah terbaik, menjangkau pembeli potensial, dan memaksimalkan nilai properti Anda dengan mudah.</p>
    </div>
  </section>
</div>

<footer>
  <div class="container">
    <div class="footer-logo">
      <img src="{{ asset('images/In_Home/Logo.png') }}" alt="InHouse Logo" class="footer-logo-img">
      <span class="footer-brand">InHouse</span>
    </div>
    <div class="footer-info">
      <p>Address: Jl.Semesta No 1006, Ujung, Parepare, Sulawesi Selatan, Indonesia</p>
      <p>Email: inhouse@google.com | Phone: (021) 590 9000 / (021) 1234 2435</p>
    </div>
  </div>
</footer>

