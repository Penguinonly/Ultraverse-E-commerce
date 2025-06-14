<!-- aboutus.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="{{ asset('css/In_Home.css') }}">
  <title>InHouse - Home</title>
</head>

<body>
  <!-- Header/Nav -->
  <header>
    <div class="container nav">
      <a href="#" class="logo">
        <img src="{{ asset('images/aboutUS/Logo.png') }}" alt="Logo Hitam" class="logo-img">
        <span class="brand">InHouse</span>
      </a>
     <nav class="nav-links">
          <a href="{{ url('/Home') }}" class="active">Home</a>

          <a href="{{ url('/service') }}">Service</a>

          <a href="{{ url('/aboutUS') }}">About us</a>
      </nav>
      <a href="../Login/signIn.html" class="btn-login">Login</a>
    </div>
  </header>

  <!-- Hero About Section -->
  <section class="hero-about">
    <<img src="{{ asset('images/aboutUS/LogoHitam.png') }}" alt="Logo Hitam" class="hero-logo">
    <h1 class="hero-title">Home</h1>
  </section>