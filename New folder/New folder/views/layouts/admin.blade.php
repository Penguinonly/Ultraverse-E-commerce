<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <nav class="bg-gray-800 w-64 min-h-screen px-4 py-6">
            <div class="flex items-center mb-8">
                <span class="text-white text-2xl font-semibold">Admin Panel</span>
            </div>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-300 py-2 px-4 hover:bg-gray-700 rounded">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}" class="flex items-center text-gray-300 py-2 px-4 hover:bg-gray-700 rounded">
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.properties') }}" class="flex items-center text-gray-300 py-2 px-4 hover:bg-gray-700 rounded">
                        <span>Properties</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.verifications') }}" class="flex items-center text-gray-300 py-2 px-4 hover:bg-gray-700 rounded">
                        <span>Verifications</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            <header class="bg-white shadow">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h1 class="text-xl font-semibold">@yield('header')</h1>
                    <div class="flex items-center">
                        <span class="mr-4">{{ session('nama') }}</span>
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-800">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
