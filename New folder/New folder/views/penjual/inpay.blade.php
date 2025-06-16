<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inpay Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/Agen_Properti/inpay.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <x-layouts.seller.sidebar></x-layouts.seller.sidebar>
  <main class="main">
    <div class="top-card">
      <div class="logo">Inpay</div>
      <div class="numbers">
        <div>4563</div><div>6748</div><div>3754</div><div>1773</div>
      </div>
      <div class="balance">RP. 8,453.00</div>
      <div class="provider">
        <span>Mastercard</span>
        <svg viewBox="0 0 24 24">
          <circle cx="10.5" cy="12" r="4.5" opacity="0.5"/><circle cx="13.5" cy="12" r="4.5"/>
        </svg>
      </div>
    </div>
    <section class="features">
      <div class="feature-item">
        <!-- Top Up Icon -->
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"/><polyline points="12 8 12 12 14 12"/><polyline points="16 12 18 12 18 16"/></svg>
        <span>Top Up</span>
      </div>
      <div class="feature-item">
        <!-- Transfer Tunai Icon -->
        <svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M7 12h10"/><polyline points="12 7 12 12 14 10"/></svg>
        <span>Transfer Tunai</span>
      </div>
      <div class="feature-item">
        <!-- Bayar KPR Icon -->
        <svg viewBox="0 0 24 24"><path d="M4 7h16v14H4z"/><path d="M4 11h16"/><circle cx="18" cy="16" r="2"/></svg>
        <span>Bayar KPR</span>
      </div>
      <div class="feature-item">
        <!-- Mutasi Transaksi Icon -->
        <svg viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
        <span>Mutasi Transaksi</span>
      </div>
    </section>
  </main>
</body>
</html>
