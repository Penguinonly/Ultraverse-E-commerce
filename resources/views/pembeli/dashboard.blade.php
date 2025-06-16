<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InHouse - Temukan Rumah Impian Anda</title>
      <!-- CSS (pembeli) -->
    <link rel="stylesheet" href="{{ asset('css/pembeli/style.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- ... konten ... -->

        <!-- Contoh Gambar -->
        <img src="{{ asset('images/pembeli/Rumah1.jpg') }}" alt="Rumah di Sulawesi Selatan">
        <img src="{{ asset('images/pembeli/Rumah2.jpg') }}" alt="Rumah di Sulawesi Selatan">
        <!-- Lanjutkan gambar lain dengan path sesuai -->
    </div>

    <!-- Script (pembeli) -->
    <script src="{{ asset('js/pembeli/script.js') }}"></script>
</body>

<body>
    <div class="container">
        <!-- Sidebar -->
   
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header Banner -->
            <div class="header-banner">
                <div class="banner-overlay">
                    <div class="header-top">
                        <div class="logo-container">
                            <h1>Welcome to InHouse</h1>
                            <p>Your journey to a new home begins here. Trust us to make it seamless, secure, and successful.</p>
                        </div>
                        <div class="user-menu">
                            <div class="notification-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="user-profile">
                                <span>User</span>
                                <div class="avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
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

            <!-- Property Listings -->
            <div class="property-grid">
                <!-- Property 1 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="Rumah1.jpg" alt="Rumah di Sulawesi Selatan">
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

                <!-- Property 2 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="Rumah2.jpg" alt="Rumah di Sulawesi Selatan">
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

                <!-- Property 3 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="Rumah3.jpg" alt="Rumah di Sulawesi Selatan">
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

                <!-- Property 4 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="Rumah4.jpg" alt="Rumah di Sulawesi Selatan">
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

                <!-- Property 5 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="Rumah5.jpg" alt="Rumah di Sulawesi Selatan">
                    </div>
                    <div class="property-info">
                        <h3>Rumah Tropis </h3>
                        <p class="location">TORAJA, SULAWESI SELATAN</p>
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

                <!-- Property 6 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="Rumah6.jpg" alt="Rumah di Sulawesi Selatan">
                    </div>
                    <div class="property-info">
                        <h3>Rumah Urban Compact</h3>
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

                <!-- Property 7 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="Rumah7.jpg" alt="Rumah di Sulawesi Selatan">
                    </div>
                    <div class="property-info">
                        <h3>(Tanpa Nama)</h3>
                        <p class="location">BARRU, SULAWESI SELATAN</p>
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

                <!-- Property 8 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="Rumah8.jpg" alt="Rumah di Sulawesi Selatan">
                    </div>
                    <div class="property-info">
                        <h3>(Tanpa Nama)</h3>
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

                <!-- Property 9 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="Rumah9.jpg" alt="Rumah di Sulawesi Selatan">
                    </div>
                    <div class="property-info">
                        <h3>(Tanpa Nama)</h3>
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
            </div>
        </div>
    </div>
<script src="script.js"></script>
</body>
</html>