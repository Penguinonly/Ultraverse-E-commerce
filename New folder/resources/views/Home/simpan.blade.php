@extends('layouts.app')

@section('title', 'Properti Tersimpan')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/Home_direct/search_dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/Home_direct/simpan.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/simpan/styleSimpan.css') }}">
<style>
    .logo-nav {
        position: fixed;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        background: #ffffff;
        padding: 15px 10px;
        border-radius: 0 10px 10px 0;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .logo-nav .nav-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .logo-button {
        width: 35px;
        height: 35px;
        padding: 5px;
        background: none;
        border: none;
        cursor: pointer;
        transition: transform 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-button img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .logo-button:hover {
        transform: scale(1.1);
    }

    .logo-button.active {
        background-color: #FFA62B;
        border-radius: 50%;
    }

    .property-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .property-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .property-card:hover {
        transform: translateY(-5px);
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-content {
        max-width: 400px;
        margin: 0 auto;
    }

    .btn-explore {
        display: inline-block;
        padding: 10px 20px;
        background-color: #FFA62B;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px;
        transition: background-color 0.3s;
    }

    .btn-explore:hover {
        background-color: #ff8c00;
    }
</style>
@endsection

@section('content')
<!-- Add Logo Navigation -->
<nav class="logo-nav">
    <div class="nav-button">
        <a href="{{ route('home') }}" class="logo-button">
            <img src="{{ asset('images/lotus-logo.png') }}" alt="Home">
        </a>
        <a href="{{ route('dashboard_search') }}" class="logo-button">
            <i class="fas fa-search"></i>
        </a>
        <a href="{{ route('saved_properties') }}" class="logo-button active">
            <i class="fas fa-bookmark"></i>
        </a>
        <a href="{{ route('messages') }}" class="logo-button">
            <i class="fas fa-comments"></i>
        </a>
        <a href="{{ route('favorites') }}" class="logo-button">
            <i class="fas fa-heart"></i>
        </a>
        <a href="{{ route('profile') }}" class="logo-button">
            <i class="fas fa-user"></i>
        </a>
    </div>
</nav>

<div class="main-content">
    <!-- Header Section -->
    <div class="header-banner">
        <div class="banner-overlay">
            <div class="header-content">
                <h1>Properti Tersimpan</h1>
                <p>Daftar properti yang Anda simpan untuk dilihat nanti</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="search-section">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari properti tersimpan...">
            <button type="button" class="search-btn">Search</button>
        </div>
        <div class="filter-options">
            <button class="filter-btn">
                <i class="fas fa-location-dot"></i>
                Location
            </button>
            <button class="filter-btn">
                <i class="fas fa-dollar-sign"></i>
                Price
            </button>
        </div>
    </div>

    <!-- Property Grid -->
    <div class="property-grid">
        @forelse($savedProperties as $property)
            <div class="property-card">
                <div class="property-image">
                    <img src="{{ asset($property->image_url) }}" alt="{{ $property->title }}">
                    <button class="save-btn active" title="Hapus dari tersimpan">
                        <i class="fas fa-bookmark"></i>
                    </button>
                </div>
                <div class="property-content">
                    <h3>{{ $property->title }}</h3>
                    <p class="location">{{ $property->location }}</p>
                    <div class="property-specs">
                        <span><i class="fas fa-bed"></i> {{ $property->bedrooms }}</span>
                        <span><i class="fas fa-bath"></i> {{ $property->bathrooms }}</span>
                        <span><i class="fas fa-ruler-combined"></i> {{ $property->area }} M²</span>
                        <span class="verified"><i class="fas fa-circle-check"></i> Lulus Uji</span>
                    </div>
                    <div class="price">
                        <h4>Rp {{ number_format($property->price, 0, ',', '.') }}</h4>
                    </div>
                    <div class="property-actions">
                        <button class="btn-buy">Beli</button>
                        <button class="btn-remove">
                            <i class="fas fa-bookmark"></i>
                            Tersimpan
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-bookmark"></i>
                    <h3>Belum ada properti tersimpan</h3>
                    <p>Simpan properti yang menarik untuk dilihat nanti</p>
                    <a href="{{ route('dashboard_search') }}" class="btn-explore">
                        Jelajahi Properti
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($savedProperties) && $savedProperties->hasPages())
        <div class="pagination">
            {{ $savedProperties->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle save/unsave buttons
    document.querySelectorAll('.btn-remove, .save-btn').forEach(button => {
        button.addEventListener('click', function() {
            const card = this.closest('.property-card');
            if (confirm('Anda yakin ingin menghapus properti ini dari daftar tersimpan?')) {
                // Animate the removal
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    card.remove();
                    // Check if grid is empty
                    if (document.querySelectorAll('.property-card').length === 0) {
                        location.reload(); // Show empty state
                    }
                }, 300);
            }
        });
    });
});
</script>
@endsection

