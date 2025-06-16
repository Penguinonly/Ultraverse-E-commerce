@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Home_direct/aboutUS.css') }}">

<!-- Header/Nav -->
<header>
  <div class="container nav">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ asset('images/aboutUS/Logo.png') }}" alt="Logo Hitam" class="logo-img">
      <span class="brand">InHouse</span>
    </a>
    <nav class="nav-links">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('service') }}">Service</a>
      <a href="{{ route('aboutUS') }}" class="active">About us</a>
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

<!-- Hero About Section -->
<section class="hero-about">
  <img src="{{ asset('images/aboutUS/LogoHitam.png') }}" alt="Logo Hitam" class="hero-logo">
  <h1 class="hero-title">About Us</h1>
</section>

<!-- Intro Text -->
<section class="about-intro container">
  <div class="intro-head">
    <h2>We Rising<br/>Raising Others</h2>
  </div>
  <div class="intro-body">
    <p>At InHouse, we believe that finding or selling a home shouldn't be complicated or risky. Born from the growing need for a secure and transparent digital property marketplace in Indonesia, our platform was developed to connect buyers and sellers through a reliable, user-friendly, and efficient online experience.</p>
    <p>Our mission is to revolutionize the way real estate transactions happen — by providing verified property listings, document authentication, smart search features, and real-time updates. Whether you're a homeowner looking to sell or a buyer in search of your dream home, InHouse is here to guide you every step of the way.</p>
  </div>
</section>

<!-- Vision & Mission -->
<section class="vision-mission container">
  <article class="vision">
    <h2>Vision</h2>
    <p>To become Indonesia's most trusted and innovative digital real estate marketplace, empowering people to make informed property decisions with confidence.</p>
  </article>
  
  <article class="mission">
    <h2>Mission</h2>
    <ul>
      <li>Provide a secure and transparent platform for property transactions</li>
      <li>Simplify the property buying and selling process through technology</li>
      <li>Ensure all listings are verified and authentic</li>
      <li>Offer comprehensive support throughout the entire property journey</li>
      <li>Foster a community of trusted real estate professionals</li>
    </ul>
  </article>
</section>

<!-- Team Section -->
<section class="team container">
  <h2>Our Team</h2>
  <div class="team-grid">
    <article class="team-member">
      <img src="{{ asset('images/team/leader.jpg') }}" alt="Team Leader">
      <h3>Ahmad Rizky</h3>
      <p>Founder & CEO</p>
    </article>
    <article class="team-member">
      <img src="{{ asset('images/team/tech.jpg') }}" alt="Tech Lead">
      <h3>Sarah Wijaya</h3>
      <p>Chief Technology Officer</p>
    </article>
    <article class="team-member">
      <img src="{{ asset('images/team/operations.jpg') }}" alt="Operations Lead">
      <h3>Budi Santoso</h3>
      <p>Head of Operations</p>
    </article>
  </div>
</section>

<!-- Contact Section -->
<section class="contact container">
  <h2>Get in Touch</h2>
  <div class="contact-info">
    <div class="contact-item">
      <i class="fas fa-map-marker-alt"></i>
      <p>Jl. Gatot Subroto No. 123<br>Jakarta Selatan, 12950</p>
    </div>
    <div class="contact-item">
      <i class="fas fa-phone"></i>
      <p>+62 21 555 0123</p>
    </div>
    <div class="contact-item">
      <i class="fas fa-envelope"></i>
      <p>contact@inhouse.id</p>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="footer-logo">
      <img src="{{ asset('images/aboutUS/Logo.png') }}" alt="InHouse Logo" class="footer-logo-img">
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