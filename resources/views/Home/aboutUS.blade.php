<!-- aboutus.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InHouse - About Us</title>
  <link rel="stylesheet" href="{{ asset('css/Home_direct/aboutUS.css')}}">
</head>
<body>
  <!-- Header/Nav -->
  <header>
    <div class="container nav">
      <a href="#" class="logo">
        <img src="images/aboutUs/Logo.png" alt="InHouse Logo" class="logo-img" />
        <span class="brand">InHouse</span>
      </a>
      <nav class="nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('service') }}">Service</a>
        <a href="{{ route('aboutUS') }}" class="active">About us</a>

      </nav>
      <a href="{{ route('login') }}" class="btn-login">Login</a>
    </div>
  </header>

  <!-- Hero About Section -->
  <section class="hero-about">
    <img src="images/aboutUs/LogoHitam.png" alt="InHouse Symbol" class="hero-logo" />
    <h1 class="hero-title">About Us</h1>
  </section>

  <!-- Intro Text -->
  <section class="about-intro container">
    <div class="intro-head">
      <h2>We Rising<br/>Raising Others</h2>
    </div>
    <div class="intro-body">
      <p>At InHouse, we believe that finding or selling a home shouldn’t be complicated or risky. Born from the growing need for a secure and transparent digital property marketplace in Indonesia, our platform was developed to connect buyers and sellers through a reliable, user-friendly, and efficient online experience.</p>
      <p>Our mission is to revolutionize the way real estate transactions happen — by providing verified property listings, document authentication, smart search features, and real-time updates. Whether you’re a homeowner looking to sell or a buyer in search of your dream home, InHouse is here to guide you every step of the way.</p>
    </div>
  </section>

  <!-- Vision & Mission -->
  <section class="vision-mission container">
    <article>
      <h2>Vision</h2>
      <p>To become Indonesia’s most trusted digital real estate e‑commerce, empowering people to buy and sell properties safely, transparently, and efficiently — anytime, anywhere.</p>
    </article>
    <article>
      <h2>Mission</h2>
      <p>To provide a secure and user‑friendly platform that connects property buyers and sellers with ease and confidence. To enhance transparency in property transactions through document verification and trusted listings. To simplify the search process with smart filters and interactive digital maps. To support digital transformation in the real estate industry by offering innovative and scalable solutions. To build a healthy property ecosystem that reduces fraud and expands market access for agents and individuals alike.</p>
    </article>
  </section>

  <!-- Values -->
  <section class="values container">
    <h2>Our Values</h2>
    <ul class="values-list">
      <li>Excellence</li>
      <li>Enthusiasm</li>
      <li>Integrity</li>
      <li>Team Work</li>
      <li>Customer Satisfaction</li>
    </ul>
  </section>

  <!-- Team Board -->
  <section class="team container">
    <h2>Board of Team Work</h2>
    <div class="team-members">
      <!-- Member Card -->
      <div class="member">
        <img src="images/aboutUs/Yuki Kirei Nasruddin.jpeg" alt="Yuki Kirei Nasruddin" />
        <h3>Yuki Kirei Nasruddin</h3>
        <p class="role">Project Manager</p>
      </div>
      <div class="member">
        <img src="images/aboutUs/Andi Muhammad Rifai.jpg" alt="Andi Muhammad Rifai" />
        <h3>Andi Muhammad Rifai</h3>
        <p class="role">Database Engineer</p>
      </div>
      <div class="member">
        <img src="images/aboutUs/Safri Nur Saputra.jpg" alt="Safri Nur Saputra" />
        <h3>Safri Nur Saputra</h3>
        <p class="role">System Analyst & QA Specialist</p>
      </div>
      <div class="member">
        <img src="images/aboutUs/Gian Hervicky Thamrin.jpg" alt="Gian Hervicky Thamrin" />
        <h3>Gian Hervicky Thamrin</h3>
        <p class="role">Backend Programmer</p>
      </div>
      <div class="member">
        <img src="images/aboutUs/Riska Haniriadi.jpg" alt="Riska Haniriadi" />
        <h3>Riska Haniriadi</h3>
        <p class="role">Web Designer & Frontend Programming</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container footer-content">
      <div class="footer-logo">
        <img src="images/aboutUS/Logo.png" alt="InHouse Logo" />
        <span>InHouse</span>
      </div>
      <div class="footer-info">
        <p>Address: Jl.Semesta No 1006, Ujung, Parepare, Sulawesi Selatan, Indonesia</p>
        <p>Email: inhouse@google.com | Phone: (021) 590 9000 / (021) 1234 2435</p>
      </div>
    </div>
  </footer>
</body>
</html>