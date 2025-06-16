{{-- resources/views/layouts/penjual/master.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
</head>
<body>
  @include('layouts.penjual.sidebar')

  <main class="content">
    @yield('content')
  </main>

  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>
