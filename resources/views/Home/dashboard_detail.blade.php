@extends('layouts.app')

@section('content')
    <!-- DETAIL PROPERTI -->
    <section class="detail-property">
        <div class="gallery">
            <div class="main-image">
                <img src="{{ asset('images/Dashboard/Rumah1.jpg') }}" alt="Rumah Detail" id="mainImage">
            </div>
            <div class="thumbs">
                <img src="{{ asset('images/Dashboard/Rumah1.jpg') }}" alt="Thumb 1" class="active" onclick="changeImage(this)">
                <img src="{{ asset('images/Dashboard/R1B1.jpg') }}" alt="Thumb 2" onclick="changeImage(this)">
                <img src="{{ asset('images/Dashboard/R1B2.jpg') }}" alt="Thumb 3" onclick="changeImage(this)">
                <img src="{{ asset('images/Dashboard/R1B3.jpg') }}" alt="Thumb 4" onclick="changeImage(this)">
                <img src="{{ asset('images/Dashboard/R1B4.jpg') }}" alt="Thumb 5" onclick="changeImage(this)">
                <img src="{{ asset('images/Dashboard/R1B5.jpg') }}" alt="Thumb 6" onclick="changeImage(this)">
                <img src="{{ asset('images/Dashboard/R1B6.jpg') }}" alt="Thumb 7" onclick="changeImage(this)">
                <img src="{{ asset('images/Dashboard/R1B7.jpg') }}" alt="Thumb 8" onclick="changeImage(this)">
                <img src="{{ asset('images/Dashboard/R1B8.jpg') }}" alt="Thumb 9" onclick="changeImage(this)">
            </div>
        </div>
        <div class="info">
            <h2>Rumah Modern Minimalis</h2>
            <p class="location">PAREPARE, SULAWESI SELATAN</p>
            <p class="price">Rp 800.000.000,00</p>
            <p class="price-words">(Delapan Ratus Juta Rupiah)</p>
            <div class="property-details">
                <span><i class="fas fa-bed"></i> 2</span>
                <span><i class="fas fa-bath"></i> 1</span>
                <span><i class="fas fa-ruler-combined"></i> 90 M²</span>
                <span><i class="fas fa-check-circle success"></i> Lulus Uji</span>
            </div>
            <div class="actions">
                <a href="{{ route('transaksi') }}" class="btn-primary">Beli</a>
                <button class="btn-secondary" onclick="toggleSave(this)">
                    <i class="fas fa-bookmark"></i> Simpan
                </button>
            </div>
        </div>
    </section>

    <!-- Detail Properti -->
    <section class="detail-info">
        <h3>Detail Properti</h3>
        <ul>
            <li><strong>Alamat:</strong> Jl. Semesta C4-20, Ujung, Parepare, Sulawesi Selatan</li>
            <li><strong>Status Listing:</strong> Dijual cepat, siap huni</li>
            <li><strong>Harga:</strong> Rp 800.000.000,00<br>
                <em>(Delapan ratus juta rupiah)</em>
            </li>
        </ul>
    </section>

    <!-- Spesifikasi -->
    <section class="spec-table">
        <h3>Spesifikasi</h3>
        <table>
            <thead>
                <tr>
                    <th>Fitur</th>
                    <th>Rincian</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Luas Tanah</td><td>90 m²</td></tr>
                <tr><td>Luas Bangunan</td><td>± 45–55 m<sup>2</sup>*</td></tr>
                <tr><td>Kamar Tidur</td><td>2</td></tr>
                <tr><td>Kamar Mandi</td><td>1</td></tr>
                <tr><td>Carport</td><td>Muat 1 mobil</td></tr>
                <tr><td>Tingkat</td><td>1 lantai</td></tr>
                <tr><td>Status Legalitas</td><td>Lulus Uji / IMB lengkap</td></tr>
            </tbody>
        </table>
    </section>
@endsection

@section('scripts')
<script>
function changeImage(thumb) {
    // Remove active class from all thumbnails
    document.querySelectorAll('.thumbs img').forEach(img => img.classList.remove('active'));
    // Add active class to clicked thumbnail
    thumb.classList.add('active');
    // Update main image
    document.getElementById('mainImage').src = thumb.src;
}

function toggleSave(btn) {
    btn.classList.toggle('saved');
    const icon = btn.querySelector('i');
    if (btn.classList.contains('saved')) {
        icon.style.color = '#FFB800';
    } else {
        icon.style.color = '#8C8C8C';
    }
}
</script>
@endsection
