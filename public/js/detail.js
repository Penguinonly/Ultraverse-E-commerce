document.addEventListener('DOMContentLoaded', () => {
  // ===== DATA PROPERTI =====
  const properties = [
    {
      id: 1,
      imageMain: 'Rumah1.jpg',
      thumbs: ['Rumah1.jpg', 'R1B1.jpg', 'R1B2.jpg', 'R1B3.jpg', 'R1B4.jpg', 'R1B5.jpg', 'R1B6.jpg', 'R1B7.jpg'],
      title: 'Rumah Modern Minimalis',
      location: 'PAREPARE, SULAWESI SELATAN',
      price: 'Rp 800.000.000,00',
      priceWords: '(Delapan Ratus Juta Rupiah)',
      details: { bed: 2, bath: 1, area: '90 M²', approved: 'Lulus Uji' },
      address: 'Jl. Semesta C4-20, Ujung, Parepare, Sulawesi Selatan',
      listing: 'Dijual cepat, siap huni',
      specs: {
        land: '90 m²',
        building: '± 45–55 m²',
        rooms: 2,
        bathrooms: 1,
        carport: 'Muat 1 mobil',
        floors: '1 lantai',
        legal: 'Lulus Uji / IMB lengkap'
      }
    },
    // ... tambahkan properti lainnya di sini (seperti data no.2 sampai 9)
  ];

  const path = window.location.pathname;

  // ===== HALAMAN SEARCH =====
  if (path.endsWith('search.html') || path.endsWith('/')) {
    const cards = document.querySelectorAll('.property-card');
    cards.forEach((card, idx) => {
      card.style.cursor = 'pointer';
      card.addEventListener('click', () => {
        sessionStorage.setItem('selectedProperty', JSON.stringify(properties[idx]));
        window.location.href = 'detail.html';
      });
    });
  }

  // ===== HALAMAN DETAIL =====
  if (path.endsWith('detail.html')) {
    const stored = sessionStorage.getItem('selectedProperty');
    if (!stored) return;

    const prop = JSON.parse(stored);

    // Update gambar utama
    const mainImg = document.querySelector('.main-image img');
    if (mainImg) {
      mainImg.src = prop.imageMain;
    }

    // Update thumbnail
    const thumbsContainer = document.querySelector('.thumbs');
    if (thumbsContainer) {
      thumbsContainer.innerHTML = prop.thumbs.map((src, i) =>
        `<img src="${src}" alt="Thumb ${i + 1}" class="${i === 0 ? 'active' : ''}" />`
      ).join('');

      const thumbs = thumbsContainer.querySelectorAll('img');
      thumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
          if (mainImg) mainImg.src = thumb.src;
          thumbs.forEach(t => t.classList.remove('active'));
          thumb.classList.add('active');
        });
      });
    }

    // Informasi properti
    document.querySelector('.info h2').textContent = prop.title;
    document.querySelector('.info .location').textContent = prop.location;
    document.querySelector('.info .price').textContent = prop.price;
    document.querySelector('.info .price-words').textContent = prop.priceWords;

    // Detail (bed, bath, area, approved)
    const detailsSpans = document.querySelectorAll('.property-details span');
    if (detailsSpans.length >= 4) {
      detailsSpans[0].innerHTML = `<i class="fas fa-bed"></i> ${prop.details.bed}`;
      detailsSpans[1].innerHTML = `<i class="fas fa-bath"></i> ${prop.details.bath}`;
      detailsSpans[2].innerHTML = `<i class="fas fa-ruler-combined"></i> ${prop.details.area}`;
      detailsSpans[3].innerHTML = `<i class="fas fa-check-circle"></i> ${prop.details.approved}`;
    }

    // Detail tambahan
    const listItems = document.querySelectorAll('.detail-info ul li');
    if (listItems.length >= 3) {
      listItems[0].innerHTML = `<strong>Alamat:</strong> ${prop.address}`;
      listItems[1].innerHTML = `<strong>Status Listing:</strong> ${prop.listing}`;
      listItems[2].innerHTML = `<strong>Harga:</strong> ${prop.price}<br/><em>${prop.priceWords}</em>`;
    }

    // Tabel spesifikasi
    const rows = document.querySelectorAll('.spec-table tbody tr');
    if (rows.length >= 7) {
      rows[0].children[1].textContent = prop.specs.land;
      rows[1].children[1].textContent = prop.specs.building;
      rows[2].children[1].textContent = prop.specs.rooms;
      rows[3].children[1].textContent = prop.specs.bathrooms;
      rows[4].children[1].textContent = prop.specs.carport;
      rows[5].children[1].textContent = prop.specs.floors;
      rows[6].children[1].textContent = prop.specs.legal;
    }
  }
});
