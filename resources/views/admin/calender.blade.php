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
  <link rel="stylesheet" href="{{ asset('css/admin/calendar.css') }}">
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
  <div class="calendar-container">
    <div class="calendar-header">
        <h1>Schedule Manager</h1>
        <select class="month-select">
            <option value="2025-06">June 2025</option>
            <option value="2025-07">July 2025</option>
            <option value="2025-08" selected>August 2025</option>
            <option value="2025-09">September 2025</option>
        </select>
    </div>

    <div class="calendar-tools">
        <button class="tool-button active">Day View</button>
        <button class="tool-button">Week View</button>
        <button class="tool-button">Month View</button>
        <button class="tool-button">Add Slot</button>
    </div>

    <div class="weekdays">
        <div class="day-box">
            <div class="weekday">Mon</div>
            <div class="date">4</div>
            <div class="slots">7 slots</div>
        </div>
        <div class="day-box selected">
            <div class="weekday">Tue</div>
            <div class="date">5</div>
            <div class="slots">4 slots</div>
        </div>
        <div class="day-box">
            <div class="weekday">Wed</div>
            <div class="date">6</div>
            <div class="slots">6 slots</div>
        </div>
        <div class="day-box">
            <div class="weekday">Thu</div>
            <div class="date">7</div>
            <div class="slots">5 slots</div>
        </div>
        <div class="day-box">
            <div class="weekday">Fri</div>
            <div class="date">8</div>
            <div class="slots">3 slots</div>
        </div>
        <div class="day-box">
            <div class="weekday">Sat</div>
            <div class="date">9</div>
            <div class="slots">2 slots</div>
        </div>
        <div class="day-box">
            <div class="weekday">Sun</div>
            <div class="date">10</div>
            <div class="slots">Closed</div>
        </div>
    </div>

    <div class="time-slots">
        <h2>Available Slots - August 5, 2025</h2>
        
        <div class="time-slot">
            <div class="time-slot-info">
                <div class="time-slot-time">09:00 - 10:00</div>
                <span class="time-slot-status status-available">Available</span>
            </div>
            <div class="time-slot-actions">
                <button class="action-btn btn-primary">Book</button>
                <button class="action-btn btn-danger">Block</button>
            </div>
        </div>

        <div class="time-slot">
            <div class="time-slot-info">
                <div class="time-slot-time">10:00 - 11:00</div>
                <span class="time-slot-status status-booked">Booked</span>
            </div>
            <div class="time-slot-actions">
                <button class="action-btn btn-primary" disabled>View</button>
            </div>
        </div>

        <div class="time-slot">
            <div class="time-slot-info">
                <div class="time-slot-time">11:00 - 12:00</div>
                <span class="time-slot-status status-available">Available</span>
            </div>
            <div class="time-slot-actions">
                <button class="action-btn btn-primary">Book</button>
                <button class="action-btn btn-danger">Block</button>
            </div>
        </div>

        <!-- More time slots... -->
    </div>
</div>
</body>
</html>
