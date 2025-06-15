<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>User Manage</title>

  <!-- FONT AWESOME -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  <link rel="stylesheet" href="css/manage.css" />
</head>

<body>
  <div class="container app">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-icons">
        <div class="icon"><i class="fas fa-home"></i></div>
        <div class="icon active"><i class="fas fa-user"></i></div>
        <div class="icon"><i class="fas fa-file-alt"></i></div>
        <div class="icon"><i class="fas fa-wallet"></i></div>
        <div class="icon"><i class="fas fa-calendar"></i></div>
        <div class="icon"><i class="fas fa-briefcase"></i></div>
        <div class="icon"><i class="fas fa-envelope"></i></div>
        <div class="spacer"></div>
        <div class="icon"><i class="fas fa-cog"></i></div>
        <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
      </div>
    </div>

    <!-- Main content -->
    <main class="main">
      <!-- Search Bar -->
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
        <h1>User Manage</h1>
        <div class="card">
          <div class="card-body table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th>City</th>
                  <th>Alamat</th>
                  <th>Foto KTP</th>
                  <th>Data Pembeli</th>
                  <th>Status</th>
                  <th>Peran</th>
                  <th class="actions">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>11/11/2022</td>
                  <td>Budi Aman</td>
                  <td>abc@gmail.com</td>
                  <td>081234566432</td>
                  <td>Parepare</td>
                  <td>Jl Semesta</td>
                  <td><img src="ktp1.png" alt="" class="ktp-thumb"></td>
                  <td>Member Sejak 2021</td>
                  <td>Aktif</td>
                  <td>Penjual</td>
                  <td class="actions">
                    <!-- Link/icon Edit -->
                    <a href="#" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <!-- Link/icon Hapus -->
                    <a href="#" title="Hapus">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
                <!-- baris lain -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
