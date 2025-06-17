<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InHouse - Home</title>
  <link rel="stylesheet" href="{{ asset('css/Home_direct/In_Home.css') }}">
</head>
<body>
  <header>
    <div class="container nav">
      <a href="#" class="logo">
        <img src="images/services/Logo.png" alt="InHouse Logo" class="logo-img" />
        <span class="brand">InHouse</span>
      </a>
      <nav class="nav-links">
        <a href="{{ route('home') }}" class="active">Home</a>
        <a href="{{ route('service') }}" >Service</a>
         <a href="{{ route('aboutUS') }}">About us</a>
      </nav>
      <a href="{{ route('login') }}"class="btn-login">Login</a>
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
    <div class="section-wrapper"></div>
      <section class="section">
        <img src="images/In_Home/pexels-elevate-digital-784230-1647907.jpg" alt="Team discussing real estate" />
        <div class="section-text">
          <h2>Melangkah bersama kami</h2>
          <p>Memangkah bukanlah hal yang mudah untuk mencari hunian yang tepat. Oleh karena itu, InHouse hadir untuk mempermudah perjalanan Anda menemukan rumah impian. Temukan properti terpercaya, dokumen terverifikasi, dan fitur pencarian yang intuitif. Semua dalam satu. Ayo mulai jelajahi rumah idaman Anda bersama InHouse hari ini!</p>
        </div>
      </section>

      <section class="section reverse">
        <img src="images/In_Home/pexels-fauxels-3184291.jpg" alt="Meeting and handshake" />
        <div class="section-text">
          <h2>Sedang mencari atau ingin menjual rumah?</h2>
          <p>Dimanapun Anda berada, kami siap membantu. Anda bisa mengakses listing rumah terbaik, menjangkau pembeli potensial, dan memaksimalkan nilai properti Anda dengan mudah.</p>
        </div>
      </section>
    </div>

  <footer>
    <div class="container">
      <div class="footer-logo">
        <!-- Footer Logo Image -->
        <img src="images/In_Home/Logo.png" alt="InHouse Logo" class="footer-logo-img" />
        <span class="footer-brand">InHouse</span>
      </div>
      <div class="footer-info">
        <p>Address: Jl.Semesta No 1006, Ujung, Parepare, Sulawesi Selatan, Indonesia</p>
        <p>Email: inhouse@google.com | Phone: (021) 590 9000 / (021) 1234 2435</p>
      </div>
    </div>
  </footer>
</body>
</html>