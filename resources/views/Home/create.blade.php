<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InHouse - Profile</title>
  <link rel="stylesheet" href="{{ asset('css/Login/create.css') }}">
</head>
<body>
  <div class="container">
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

    {{-- Form Update Profile --}}
    <form method="POST" action="{{ route('register') }}">
      @csrf
      @method('POST')

      <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        {{-- <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required /> --}}
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        {{-- <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required /> --}}
      </div>

      <div class="form-group">
        <label for="no_telepon">No Telepon</label>
        {{-- <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" required /> --}}
      </div>

      <div class="form-group">
        <label for="alamat">Alamat</label>
        {{-- <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat) }}" required /> --}}
      </div>

      <div class="form-group">
        <label for="pendapatan_perbulan">Pendapatan Perbulan</label>
        {{-- <input type="number" id="pendapatan_perbulan" name="pendapatan_perbulan" value="{{ old('pendapatan_perbulan', $user->pendapatan_perbulan) }}" required /> --}}
      </div>

      <div class="form-group">
        <label for="nama_toko">Nama Toko</label>
        {{-- <input type="number" id="nama_toko name="nama_toko value="{{ old('nama_toko, $user->nama_toko }}" required /> --}}
      </div>

      <button type="submit" class="btn">Update Profile</button>
    </form>

    <hr>

    {{-- Form Update Password --}}
    <h2>Ganti Password</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf
    @method('POST')

      <div class="form-group">
        <label for="current_password">Password Saat Ini</label>
        <input type="password" id="current_password" name="current_password" required />
      </div>

      <div class="form-group">
        <label for="password">Password Baru</label>
        <input type="password" id="password" name="password" required />
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required />
      </div>

      <button type="submit" class="btn">Update Password</button>
    </form>
  </div>
</body>
</html>
