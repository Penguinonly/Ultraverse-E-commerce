<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InHouse - Create Account</title>
  <link rel="stylesheet" href="{{ asset('css/Login/create.css') }}">
</head>
<body>
  <div class="container">
    <h1>InHouse</h1>

    {{-- Tampilkan pesan error jika ada --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Registration Form --}}
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required />
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
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required />
      </div>

      <button type="submit" class="btn">Create Account</button>
    </form>

    <div>
      <p class="toggle-link">
        Already have an account?
        <a href="{{ url('/signIn') }}" class="btn-login">Login</a>
      </p>
    </div>
  </div>
</body>
</html>