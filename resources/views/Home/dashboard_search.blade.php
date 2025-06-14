<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InHouse - Temukan Rumah Impian Anda</title>
    <link rel="stylesheet" href="{{ asset('css/Home_direct/search_dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">        <!-- Sidebar -->
        <div class="sidebar">            <div class="sidebar-icons">
                <a href="{{ route('dashboard_search') }}" class="icon {{ Request::routeIs('dashboard_search') ? 'active' : '' }}" title="Beranda">
                    <i class="fas fa-home"></i>
                </a>                <a href="{{ route('dokumen') }}" class="icon {{ Request::routeIs('dokumen') || Request::routeIs('dokumen.*') ? 'active' : '' }}" title="Dokumen">
                    <i class="fas fa-file-alt"></i>
                </a>
                <a href="{{ route('simpan') }}" class="icon {{ Request::routeIs('simpan') ? 'active' : '' }}" title="Tersimpan">
                    <i class="fas fa-bookmark"></i>
                </a>
                <a href="{{ route('chat') }}" class="icon {{ Request::routeIs('chat') ? 'active' : '' }}" title="Chat">
                    <i class="fas fa-comments"></i>
                </a>
                <div class="spacer"></div>                  <a href="{{ route('profile.show') }}" class="icon {{ Request::routeIs('profile.*') || Request::routeIs('profile.show') ? 'active' : '' }}" title="Profil">
                    <i class="fas fa-user"></i>
                </a>
                <a href="{{ route('notifications') }}" class="icon {{ Request::routeIs('notifications') ? 'active' : '' }}" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                </a>
            </div>
        </div>

        <div class="main-content">
            <!-- Header Banner -->            <!-- Header Banner -->
            <div class="header-banner">
                <div class="banner-overlay">
                    <div class="header-top">
                        <div class="logo-container">
                            <h1>Welcome to InHouse</h1>
                            <p>Your journey to a new home begins here. Trust us to make it seamless, secure, and successful.</p>
                        </div>
                        <div class="user-menu">
                            <div class="notification-icon">
                            </div>
                            <div class="user-profile">
                                @if(session('user'))
                                    <span>{{ session('user')['name'] }}</span>
                                    <span class="role">{{ ucfirst(session('user')['role']) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="search">
                    <button class="search-btn">Search</button>
                </div>
                <div class="filter-options">
                    <button class="filter-btn">
                        <i class="fas fa-map-marker-alt"></i>
                        Location
                    </button>
                    <button class="filter-btn">
                        <i class="fas fa-dollar-sign"></i>
                        Price
                    </button>
                </div>
            </div>

            <!-- Property Grid -->            <div class="property-grid">
                <!-- Property Cards -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="{{ asset('images/Dashboard/Rumah1.jpg') }}" alt="Rumah Modern">
                    </div>
                    <div class="property-info">
                        <h3>Rumah Modern Minimalis</h3>
                        <p class="location">PAREPARE, SULAWESI SELATAN</p>
                        <div class="property-details">
                            <span><i class="fas fa-bed"></i> 2</span>
                            <span><i class="fas fa-bath"></i> 1</span>
                            <span><i class="fas fa-ruler-combined"></i> 90 M²</span>
                            <span><i class="fas fa-check-circle"></i> Lulus Uji</span>
                        </div>
                        <div class="property-actions">
                            <button class="btn-primary">Beli</button>
                            <button class="btn-secondary">Simpan</button>
                        </div>
                    </div>
                </div>

                <div class="property-card">
                    <div class="property-image">
                        <img src="{{ asset('images/Dashboard/Rumah2.jpg') }}" alt="Rumah Minimalis">
                    </div>
                    <div class="property-info">
                        <h3>Rumah Minimalis Elegan</h3>
                        <p class="location">PAREPARE, SULAWESI SELATAN</p>
                        <div class="property-details">
                            <span><i class="fas fa-bed"></i> 4</span>
                            <span><i class="fas fa-bath"></i> 3</span>
                            <span><i class="fas fa-ruler-combined"></i> 254 M²</span>
                            <span><i class="fas fa-check-circle"></i> Lulus Uji</span>
                        </div>
                        <div class="property-actions">
                            <button class="btn-primary">Beli</button>
                            <button class="btn-secondary">Simpan</button>
                        </div>
                    </div>
                </div>

                <div class="property-card">
                    <div class="property-image">
                        <img src="{{ asset('images/Dashboard/Rumah3.jpg') }}" alt="Rumah Klasik">
                    </div>
                    <div class="property-info">
                        <h3>Rumah Klasik Asri</h3>
                        <p class="location">PAREPARE, SULAWESI SELATAN</p>
                        <div class="property-details">
                            <span><i class="fas fa-bed"></i> 4</span>
                            <span><i class="fas fa-bath"></i> 3</span>
                            <span><i class="fas fa-ruler-combined"></i> 254 M²</span>
                            <span><i class="fas fa-check-circle"></i> Lulus Uji</span>
                        </div>
                        <div class="property-actions">
                            <button class="btn-primary">Beli</button>
                            <button class="btn-secondary">Simpan</button>
                        </div>
                    </div>
                </div>

                <div class="property-card">
                    <div class="property-image">
                        <img src="{{ asset('images/Dashboard/Rumah4.jpg') }}" alt="Rumah Industrial">
                    </div>
                    <div class="property-info">
                        <h3>Rumah Industrial Kontemporer</h3>
                        <p class="location">PAREPARE, SULAWESI SELATAN</p>
                        <div class="property-details">
                            <span><i class="fas fa-bed"></i> 4</span>
                            <span><i class="fas fa-bath"></i> 3</span>
                            <span><i class="fas fa-ruler-combined"></i> 254 M²</span>
                            <span><i class="fas fa-check-circle"></i> Lulus Uji</span>
                        </div>
                        <div class="property-actions">
                            <button class="btn-primary">Beli</button>
                            <button class="btn-secondary">Simpan</button>
                        </div>
                    </div>
                </div>

                <div class="property-card">
                    <div class="property-image">
                        <img src="{{ asset('images/Dashboard/Rumah5.jpg') }}" alt="Rumah Tropis">
                    </div>
                    <div class="property-info">
                        <h3>Rumah Tropis</h3>
                        <p class="location">TORAJA, SULAWESI SELATAN</p>
                        <div class="property-details">
                            <span><i class="fas fa-bed"></i> 3</span>
                            <span><i class="fas fa-bath"></i> 2</span>
                            <span><i class="fas fa-ruler-combined"></i> 150 M²</span>
                            <span><i class="fas fa-check-circle"></i> Lulus Uji</span>
                        </div>
                        <div class="property-actions">
                            <button class="btn-primary">Beli</button>
                            <button class="btn-secondary">Simpan</button>
                        </div>
                    </div>
                </div>

                <div class="property-card">
                    <div class="property-image">
                        <img src="{{ asset('images/Dashboard/Rumah6.jpg') }}" alt="Rumah Urban">
                    </div>
                    <div class="property-info">
                        <h3>Rumah Urban Compact</h3>
                        <p class="location">PAREPARE, SULAWESI SELATAN</p>
                        <div class="property-details">
                            <span><i class="fas fa-bed"></i> 3</span>
                            <span><i class="fas fa-bath"></i> 2</span>
                            <span><i class="fas fa-ruler-combined"></i> 120 M²</span>
                            <span><i class="fas fa-check-circle"></i> Lulus Uji</span>
                        </div>
                        <div class="property-actions">
                            <button class="btn-primary">Beli</button>
                            <button class="btn-secondary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/Dashboard_script.js') }}"></script>
</body>
</html>