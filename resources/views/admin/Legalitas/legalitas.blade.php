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
  <link rel="stylesheet" href="css/legal.css" />
</head>

<body>
  <div class="container app">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-icons">
        <div class="icon"><i class="fas fa-home"></i></div>
        <div class="icon"><i class="fas fa-user"></i></div>
        <div class="icon active"><i class="fas fa-file-alt"></i></div>
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

      <!-- Ganti dari <h1>User Manage</h1> dst... -->
<div class="content">
  <h1>Legalitas</h1>
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Nama</th>
            <th>Rumah</th>
            <th>Dokumen</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>11/11/2022</td>
            <td>Budi Aman</td>
            <td class="text-center">
              <a href="link-ke-gambar-rumah1.png" target="_blank" title="Lihat Rumah"><i class="fas fa-eye"></i></a>
            </td>
            <td class="text-center">
              <a href="link-ke-dokumen1.pdf" target="_blank" title="Lihat Dokumen"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>14/07/2020</td>
            <td>Udin</td>
            <td class="text-center">
              <a href="link-ke-gambar-rumah2.png" target="_blank" title="Lihat Rumah"><i class="fas fa-eye"></i></a>
            </td>
            <td class="text-center">
              <a href="link-ke-dokumen2.pdf" target="_blank" title="Lihat Dokumen"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          <!-- Tambah baris lain sesuai data -->
        </tbody>
      </table>
    </div>
  </div>
</div>