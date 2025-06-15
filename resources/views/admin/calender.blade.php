<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kalender Slot</title>
  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"
  >

  <!-- CSS Utama -->
  <link rel="stylesheet" href="calendar.css">
</head>
<body>
  <div class="app">
    <!-- SIDEBAR -->
    <div class="sidebar">
      <div class="sidebar-icons">
        <div class="icon"><i class="fas fa-home"></i></div>
        <div class="icon"><i class="fas fa-user"></i></div>
        <div class="icon"><i class="fas fa-file-alt"></i></div>
        <div class="icon"><i class="fas fa-wallet"></i></div>
        <div class="icon active"><i class="fas fa-calendar-days"></i></div>
        <div class="icon"><i class="fas fa-briefcase"></i></div>
        <div class="icon"><i class="fas fa-envelope"></i></div>
        <div class="spacer"></div>
        <div class="icon"><i class="fas fa-cog"></i></div>
        <div class="icon"><i class="fas fa-right-from-bracket"></i></div>
      </div>
    </div>

<div class="main">
  <div class="month-select">
    <select>
      <option>Agustus 2025</option>
    </select>
  </div>

  <div class="weekdays">
    <div class="day-box">
      <div>Sen</div>
      <div><strong>4</strong></div>
      <div>7 slot</div>
    </div>
    <div class="day-box selected">
      <div>Sel</div>
      <div><strong>5</strong></div>
      <div>4 slot</div>
    </div>
    <div class="day-box">
      <div>Rab</div>
      <div><strong>6</strong></div>
      <div>2 slot</div>
    </div>
    <div class="day-box">
      <div>Kam</div>
      <div><strong>7</strong></div>
      <div>10 slot</div>
    </div>
    <div class="day-box">
      <div>Jum</div>
      <div><strong>8</strong></div>
      <div>3 slot</div>
    </div>
    <div class="day-box">
      <div>Sab</div>
      <div><strong>9</strong></div>
      <div>2 slot</div>
    </div>
    <div class="day-box">
      <div>Min</div>
      <div><strong>10</strong></div>
      <div>0 slot</div>
    </div>
  </div>

  <div class="today-section">
    <h3>Hari ini</h3>
    <div class="slot-box"></div>
    <div class="slot-box"></div>
    <div class="slot-box"></div>
  </div>
</div>
</body>
</html>
