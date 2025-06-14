<header>
  <div class="container nav">
    <a href="#" class="logo">
      <img src="{{ asset('images/aboutUS/Logo.png') }}" alt="Logo Hitam" class="logo-img">
      <span class="brand">InHouse</span>
    </a>
    <nav class="nav-links">
      <a href="{{ url('/') }}">Home</a>
      <a href="{{ url('/service') }}">Service</a>
      <a href="{{ url('/aboutUS') }}" class="active">About us</a>
    </nav>
    <a href="{{ url('/login') }}" class="btn-login">Login</a>
  </div>
</header>
