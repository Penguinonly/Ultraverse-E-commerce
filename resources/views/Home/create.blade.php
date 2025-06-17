<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InHouse - Buat Akun</title>
  <link rel="stylesheet" href="{{ asset('css/Login/create.css') }}">
</head>
<body>
  <div class="container">
    <h1>Daftar Akun</h1>

    {{-- Tampilkan pesan sukses --}}
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tampilkan pesan error --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required />
      </div>
      
      <div class="form-group">
        <label for="no_telepon">No Telepon</label>
        <input type="text" id="no_telepon" name="no_telepon" required />
      </div>
      
       <div class="form-group">
        <label for="nama_toko">Nama Toko(opsional)</label>
        <input type="text" id="nama_toko" name="nama_toko" placeholder="Isi Jika Mendaftar Sebagai Penjual" />
      </div>

      <button type="submit" class="btn">Buat Akun</button>
    </form>

    <div class="toggle-link">
      <p>Sudah punya akun?
        <a href="{{ route('login') }}">Login</a>
      </p>
    </div>
  </div>
</body>
</html>
