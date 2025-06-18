<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Penting untuk Auth::user()
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController; // Pastikan ini diimport
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\DashboardController; // Jika ini masih digunakan

// Public Routes: Dapat diakses tanpa login
Route::get('/', function () {
    return view('Home.home');
})->name('home');

Route::get('/aboutUS', function () {
    return view('Home.aboutUS');
})->name('aboutUS');

Route::get('/service', function () {
    return view('Home.service');
})->name('service');

// Rute properti publik
Route::prefix('properti')->group(function () {
    Route::get('/', [PropertiController::class, 'index'])->name('properti.index');
    Route::get('/search', [PropertiController::class, 'search'])->name('properti.search');
    Route::get('/{id}', [PropertiController::class, 'show'])->name('properti.show');
});

// Authentication Routes untuk user umum (pembeli/penjual)
// Hanya bisa diakses oleh 'guest' (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/create', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/create', [AuthController::class, 'register'])->name('register.post');
    Route::get('/signIn', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/signIn', [AuthController::class, 'login'])->name('login.post');
});

// Protected Routes: Hanya bisa diakses oleh user yang sudah 'auth' (login)
Route::middleware('auth')->group(function () {
    // Logout untuk user umum
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rute /dashboard umum: ini adalah REDIRECTOR berdasarkan role user
    Route::get('/dashboard', function () {
        $user = Auth::user();
        // Auth::user() seharusnya tidak null di sini karena sudah melewati middleware 'auth'
        if ($user) {
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'penjual' => redirect()->route('penjual.dashboard'),
                'pembeli' => redirect()->route('pembeli.dashboard'),
                default => redirect()->route('home'), // Fallback jika role tidak dikenal
            };
        }
        // Fallback jika entah bagaimana user tidak terautentikasi (seharusnya tidak terjadi)
        return redirect()->route('login');
    })->name('dashboard');

    // Rute profil dan notifikasi user
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    // Rute pesan user
    Route::prefix('pesan')->group(function () {
        Route::get('/', [PesanController::class, 'index'])->name('pesan.index');
        Route::get('/{id}', [PesanController::class, 'show'])->name('pesan.show');
        Route::post('/', [PesanController::class, 'store'])->name('pesan.store');
        Route::delete('/{id}', [PesanController::class, 'destroy'])->name('pesan.destroy');
    });
});


// ===========================================================================================
// ADMIN ROUTES
// ===========================================================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Rute Login & Proses Login Admin (tanpa middleware role)
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);

    // Rute Logout Admin
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Rute yang Dilindungi: HANYA untuk user yang sudah 'auth' DAN memiliki 'rolesession:admin'
    // Middleware 'rolesession:admin' akan memastikan role dan MENYIAPKAN DATA SESI admin
    Route::middleware(['auth', 'rolesession:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');

        Route::prefix('users')->group(function () {
            Route::get('/', [AdminController::class, 'users'])->name('users.index');
            Route::get('/{user}', [AdminController::class, 'showUser'])->name('users.show');
            Route::post('/{user}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
            Route::delete('/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        });

        Route::prefix('properti')->group(function () {
            Route::get('/', [AdminController::class, 'properti'])->name('properti.index');
            Route::get('/{properti}', [AdminController::class, 'showProperti'])->name('properti.show');
            Route::post('/{properti}/verify', [AdminController::class, 'verifyProperti'])->name('properti.verify');
        });

        Route::get('/transaksi', [AdminController::class, 'transaksiIndex'])->name('transaksi.index');
    });
});

// ===========================================================================================
// PENJUAL ROUTES
// ===========================================================================================
Route::middleware(['auth', 'rolesession:penjual'])->prefix('penjual')->name('penjual.')->group(function () { // <-- Middleware rolesession:penjual
    Route::get('/dashboard', [UserController::class, 'penjualDashboard'])->name('dashboard');
    Route::get('/analytics', [UserController::class, 'penjualAnalytics'])->name('analytics');

    Route::prefix('properti')->group(function () {
        Route::get('/', [PropertiController::class, 'penjualIndex'])->name('properti.index');
        Route::get('/create', [PropertiController::class, 'create'])->name('properti.create');
        Route::post('/', [PropertiController::class, 'store'])->name('properti.store');
        Route::get('/{id}/edit', [PropertiController::class, 'edit'])->name('properti.edit');
        Route::put('/{id}', [PropertiController::class, 'update'])->name('properti.update');
        Route::delete('/{id}', [PropertiController::class, 'destroy'])->name('properti.destroy');
    });

    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'penjualIndex'])->name('transaksi.index');
        Route::get('/{id}', [TransaksiController::class, 'penjualShow'])->name('transaksi.show');
        Route::put('/{id}/approve', [TransaksiController::class, 'approve'])->name('transaksi.approve');
        Route::put('/{id}/reject', [TransaksiController::class, 'reject'])->name('transaksi.reject');
    });
});

// ===========================================================================================
// PEMBELI ROUTES
// ===========================================================================================
Route::middleware(['auth', 'rolesession:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () { // <-- Middleware rolesession:pembeli
    // Rute dashboard_search diubah namanya menjadi 'dashboard' untuk pembeli
    Route::get('/dashboard_search', [UserController::class, 'pembeliDashboard'])->name('dashboard');
    Route::get('/favorit', [UserController::class, 'pembeliFavorit'])->name('favorit');

    Route::prefix('properti')->group(function () {
        Route::post('/{id}/save', [PropertiController::class, 'saveProperty'])->name('properti.save');
        Route::delete('/{id}/unsave', [PropertiController::class, 'unsaveProperty'])->name('properti.unsave');
        Route::post('/{id}/interest', [PropertiController::class, 'showInterest'])->name('properti.interest');
    });

    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'pembeliIndex'])->name('transaksi.index');
        Route::get('/{id}', [TransaksiController::class, 'pembeliShow'])->name('transaksi.show');
        Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::delete('/{id}', [TransaksiController::class, 'cancel'])->name('transaksi.cancel');
    });
});