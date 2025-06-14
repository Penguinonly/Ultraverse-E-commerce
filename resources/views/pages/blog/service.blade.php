<head>
  …
  <link href="/layout/css/style.css" rel="stylesheet">
  <link href="/css/services.css"rel="stylesheet">
</head>

{{-- resources/views/service.blade.php --}}
@extends('layouts.template')

@section('content')
<!-- Hero Section -->
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
      <p>At InHouse, we provide ...</p>
    </li>
    <!-- lanjutkan yang lain -->
  </ul>
</main>
@endsection
