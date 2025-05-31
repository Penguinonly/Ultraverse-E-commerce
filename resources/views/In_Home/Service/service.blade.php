<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InHouse - Service</title>
  <link rel="stylesheet" href="{{ asset('css/services.css') }}">
</head>
<body>
  <!-- Header/Nav -->
  <header>
    <div class="container nav">
      <a href="#" class="logo">
        <!-- Logo Image -->
        <img src="{{ asset('images/services/Logo.png') }}" alt="InHouse Logo" class="logo-img">
      </a>
      <nav class="nav-links">
          <a href="{{ url('/') }}">Home</a>
          <a href="{{ url('/service') }}">Service</a>
          <a href="{{ url('/aboutUS') }}" class="active">About us</a>
      </nav>
    </div>
  </header>

  <section class="hero-service">
    <div class="container hero-service-content">
      <img src="{{ asset('images/services/LogoHitam.png') }}" alt="Logo Hitam" class="service-logo">
    </div>
    <div class="hero-caption">
      <span>Our Service</span>
    </div>
  </section>

  <!-- Services List -->
  <main class="container service-list">
    <ul>
      <li class="service-item">
        <h3>Verified Property Listings</h3>
        <p>At InHouse, we provide a range of digital solutions to make your property hunting and selling journey easier — from verified listings vetted by licensed agents to secure transaction escrow services.</p>
      </li>
      <li class="service-item">
        <h3>Document Verification</h3>
        <p>We offer a document upload and verification system to ensure that all legal documents associated with a property are authentic and valid, giving buyers peace of mind.</p>
      </li>
      <li class="service-item">
        <h3>Smart Search & Filters</h3>
        <p>Quickly find the right property using our intelligent search tools. Filter results by location, price range, property type, size, and more — all in one convenient place.</p>
      </li>
      <li class="service-item">
        <h3>Agent & Seller Access</h3>
        <p>We provide tools and dashboards for agents and individual sellers to manage their listings, schedules, and customer inquiries efficiently through our online platform.</p>
      </li>
    </ul>
  </main>

  <footer>
    <div class="container">
      <div class="footer-logo">
        <!-- Footer Logo Image -->
        <img src="{{ asset('images/services/Logo.png') }}" alt="Logo Hitam" class="footer-logo-img">
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
