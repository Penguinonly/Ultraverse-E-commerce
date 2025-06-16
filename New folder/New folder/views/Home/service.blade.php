@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Home_direct/service.css') }}">

<!-- Header/Nav -->
<header>
  <div class="container nav">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ asset('images/In_Home/Logo.png') }}" alt="Logo Hitam" class="logo-img">
      <span class="brand">InHouse</span>
    </a>
    <nav class="nav-links">
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('service') }}" class="active">Service</a>
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

<!-- Hero Section -->
<section class="hero-service">
  <div class="container">
    <h1 class="hero-title">Our Services</h1>
    <p class="hero-subtitle">Comprehensive solutions for all your real estate needs</p>
  </div>
</section>

<!-- Main Services -->
<section class="services container">
  <div class="services-grid">
    <article class="service-card">
      <div class="service-icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <h3>Verified Property Listings</h3>
      <p>Browse through our carefully verified property listings. Each property is vetted by our licensed agents to ensure authenticity and quality.</p>
    </article>

    <article class="service-card">
      <div class="service-icon">
        <i class="fas fa-file-alt"></i>
      </div>
      <h3>Document Verification</h3>
      <p>Our secure document verification system ensures all property documents are authentic and valid, providing peace of mind for buyers.</p>
    </article>

    <article class="service-card">
      <div class="service-icon">
        <i class="fas fa-search"></i>
      </div>
      <h3>Smart Search</h3>
      <p>Find your perfect property using our advanced search tools. Filter by location, price, size, and more to narrow down your options.</p>
    </article>
  </div>
</section>

<!-- For Buyers -->
<section class="buyer-services container">
  <h2>For Property Buyers</h2>
  <div class="services-grid">
    <article class="service-card">
      <h3>Property Alerts</h3>
      <p>Get notified when new properties matching your criteria are listed.</p>
    </article>

    <article class="service-card">
      <h3>Virtual Tours</h3>
      <p>View properties from the comfort of your home with our virtual tour feature.</p>
    </article>

    <article class="service-card">
      <h3>Finance Calculator</h3>
      <p>Calculate monthly payments and total costs with our finance tools.</p>
    </article>
  </div>
</section>

<!-- For Sellers -->
<section class="seller-services container">
  <h2>For Property Sellers</h2>
  <div class="services-grid">
    <article class="service-card">
      <h3>Professional Listings</h3>
      <p>Create attractive, professional listings with our easy-to-use tools.</p>
    </article>

    <article class="service-card">
      <h3>Market Analysis</h3>
      <p>Get insights into property values and market trends in your area.</p>
    </article>

    <article class="service-card">
      <h3>Buyer Matching</h3>
      <p>Connect with verified buyers looking for properties like yours.</p>
    </article>
  </div>
</section>

<!-- Premium Services -->
<section class="premium-services container">
  <h2>Premium Services</h2>
  <div class="premium-grid">
    <article class="premium-card">
      <h3>Professional Photography</h3>
      <p>High-quality photography services to showcase your property at its best.</p>
      <a href="{{ route('login') }}" class="btn-premium">Learn More</a>
    </article>

    <article class="premium-card">
      <h3>Legal Assistance</h3>
      <p>Expert legal support throughout the buying or selling process.</p>
      <a href="{{ route('login') }}" class="btn-premium">Learn More</a>
    </article>
  </div>
</section>

<!-- Call to Action -->
<section class="cta container">
  <div class="cta-content">
    <h2>Ready to Get Started?</h2>
    <p>Join InHouse today and experience our premium real estate services.</p>
    @guest
      <div class="cta-buttons">
        <a href="{{ route('register') }}" class="btn-primary">Sign Up Now</a>
        <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
      </div>
    @else
      <a href="{{ route('dashboard') }}" class="btn-primary">Go to Dashboard</a>
    @endguest
  </div>
</section>

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
