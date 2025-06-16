<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>

  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    rel="stylesheet"
  >

  <!-- CSS Utama -->
  <link rel="stylesheet" href="beranda.css">
</head>
<body>
  <div class="app">
    <!-- SIDEBAR -->
    <div class="sidebar">
      <div class="sidebar-icons">
        <div class="icon active"><i class="fas fa-home"></i></div>
        <div class="icon"><i class="fas fa-user"></i></div>
        <div class="icon"><i class="fas fa-file-alt"></i></div>
        <div class="icon"><i class="fas fa-wallet"></i></div>
        <div class="icon"><i class="fas fa-calendar-days"></i></div>
        <div class="icon"><i class="fas fa-briefcase"></i></div>
        <div class="icon"><i class="fas fa-envelope"></i></div>
        <div class="spacer"></div>
        <div class="icon"><i class="fas fa-cog"></i></div>
        <div class="icon"><i class="fas fa-right-from-bracket"></i></div>
      </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
      <!-- SEARCH BAR & USER MENU -->
      <div class="search-container">
        <div class="search-bar">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Search">
          <button class="search-btn">Search</button>
        </div>
        <div class="user-menu">
          <span class="user-name">Yuki</span>
          <div class="icon"><i class="fas fa-user"></i></div>
        </div>
      </div>

      <div class="content">
        <!-- STATS CARDS -->
        <section class="stats-cards">
          <div class="card">
            <h3>Active Listings</h3>
            <p class="stat-number">2,420</p>
          </div>
          <div class="card">
            <h3>Month's Transactions</h3>
            <p class="stat-number">0</p>
          </div>
          <div class="card">
            <h3>New Users</h3>
            <p class="stat-number">2,420</p>
          </div>
        </section>

        <!-- WIDGETS: TABLE + CALENDAR -->
        <section class="dashboard-widgets">
          <div class="widget table-widget">
            <h4>User Manage</h4>
            <table>
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Name</th>
                  <th>City</th>
                  <th>Status</th>
                  <th>Role</th>
                </tr>
              </thead>
              <tbody>
                <tr><td>11/11/2022</td><td>Budi Aman</td><td>Parepare</td><td>Aktif</td><td>Penjual</td></tr>
                <tr><td>22/10/2022</td><td>Markus Suzak</td><td>Barru</td><td>Aktif</td><td>Pembeli</td></tr>
                <tr><td>22/05/2022</td><td>Jake</td><td>Maros</td><td>Tidak</td><td>Pembeli</td></tr>
                <tr><td>14/07/2020</td><td>Udin</td><td>Makassar</td><td>Aktif</td><td>Penjual</td></tr>
              </tbody>
            </table>
          </div>
<div class="calendar-widget">
  <div class="calendar-card">
    <div class="calendar-header">
      <button class="nav-btn" id="prevMonth">&lt;</button>
      <h3 class="calendar-title" id="calendarTitle">Juni 2025</h3>
      <button class="nav-btn" id="nextMonth">&gt;</button>
    </div>
    <table class="calendar" id="calendarTable">
      <thead>
        <tr>
          <th>Min</th>
          <th>Sen</th>
          <th>Sel</th>
          <th>Rab</th>
          <th>Kam</th>
          <th>Jum</th>
          <th>Sab</th>
        </tr>
      </thead>
      <tbody id="calendarBody">
        <!-- Kalender akan digenerate oleh JavaScript -->
      </tbody>
    </table>
  </div>
</div>

  <!-- Script Kalender -->
  <script>
  const calendarTitle = document.getElementById("calendarTitle");
  const calendarBody = document.getElementById("calendarBody");
  const prevMonthBtn = document.getElementById("prevMonth");
  const nextMonthBtn = document.getElementById("nextMonth");

  let currentDate = new Date();

  function renderCalendar(date) {
    const year = date.getFullYear();
    const month = date.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();
    const prevLastDate = new Date(year, month, 0).getDate();

    const today = new Date();

    const monthNames = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    calendarTitle.textContent = `${monthNames[month]} ${year}`;
    calendarBody.innerHTML = "";

    let dateCount = 1;
    let nextMonthCount = 1;

    for (let row = 0; row < 6; row++) {
      const tr = document.createElement("tr");

      for (let col = 0; col < 7; col++) {
        const td = document.createElement("td");
        let cellDate = row * 7 + col - firstDay + 1;

        if (row === 0 && col < firstDay) {
          td.classList.add("other-month");
          td.textContent = prevLastDate - (firstDay - col - 1);
        } else if (cellDate > lastDate) {
          td.classList.add("other-month");
          td.textContent = nextMonthCount++;
        } else {
          td.textContent = dateCount;

          // Highlight today
          if (
            dateCount === today.getDate() &&
            month === today.getMonth() &&
            year === today.getFullYear()
          ) {
            td.classList.add("today");
          }

          dateCount++;
        }

        tr.appendChild(td);
      }

      calendarBody.appendChild(tr);

      // Stop if all days already rendered
      if (dateCount > lastDate) break;
    }
  }

  // Navigasi bulan
  prevMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
  });

  nextMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
  });

  // Inisialisasi awal
  renderCalendar(currentDate);
</script>
</body>
</html>
