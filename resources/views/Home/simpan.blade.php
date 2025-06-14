<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InHouse - Properti Tersimpan</title>
    <link rel="stylesheet" href="{{ asset('css/Home_direct/search_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Home_direct/simpan.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
@extends('layouts.app')

@section('title', 'Properti Tersimpan')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/simpan/styleSimpan.css') }}">
@endsection

@section('content')
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
</body>
</html>
