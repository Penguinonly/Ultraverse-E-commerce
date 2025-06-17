<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\DashboardController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/aboutUS', [HomeController::class, 'aboutUs'])->name('aboutUS');
Route::get('/service', [HomeController::class, 'service'])->name('service');

Route::prefix('properti')->group(function () {
    Route::get('/', [PropertiController::class, 'index'])->name('properti.index');
    Route::get('/search', [PropertiController::class, 'search'])->name('properti.search');
    Route::get('/{id}', [PropertiController::class, 'show'])->name('properti.show');
});

Route::middleware('guest')->group(function () {
    Route::get('/create', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/create', [AuthController::class, 'register'])->name('register.post');
    Route::get('/signIn', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/signIn', [AuthController::class, 'login'])->name('login.post');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    Route::prefix('pesan')->group(function () {
        Route::get('/', [PesanController::class, 'index'])->name('pesan.index');
        Route::get('/{id}', [PesanController::class, 'show'])->name('pesan.show');
        Route::post('/', [PesanController::class, 'store'])->name('pesan.store');
        Route::delete('/{id}', [PesanController::class, 'destroy'])->name('pesan.destroy');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');

    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('users.index');
        Route::get('/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::put('/{user}/activate', [AdminController::class, 'activateUser'])->name('users.activate');
        Route::put('/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
        Route::delete('/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });

    Route::prefix('properti')->group(function () {
        Route::get('/', [AdminController::class, 'propertiIndex'])->name('properti.index');
        Route::get('/{id}', [AdminController::class, 'propertiShow'])->name('properti.show');
        Route::put('/{id}/approve', [AdminController::class, 'propertiApprove'])->name('properti.approve');
        Route::put('/{id}/reject', [AdminController::class, 'propertiReject'])->name('properti.reject');
    });

    Route::get('/transaksi', [AdminController::class, 'transaksiIndex'])->name('transaksi.index');
});

// Penjual Routes
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
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

// Pembeli Routes
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard_search', [UserController::class, 'pembeliDashboard'])->name('pembeli.dashboard');
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