<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InHouse - Sign In</title>
  <link rel="stylesheet" href="{{ asset('css/Login/sign.css') }}?v={{ time() }}">
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

    {{-- Login Form --}}
    <form method="POST" action="{{ route('authenticate') }}">
      @csrf
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>
      <button type="submit" class="btn">Login</button>
    </form>

    <div>
      <p class="toggle-link">
        Don't have an account?
        <a href="{{ url('/create') }}" class="btn-login">Create</a>
      </p>
    </div>
  </div>
</body>
</html>
