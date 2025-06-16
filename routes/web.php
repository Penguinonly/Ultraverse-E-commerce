<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\PropertiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InspeksiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\FavoritController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/properti', [PropertiController::class, 'index'])->name('properti.index');
Route::get('/properti/{properti}', [PropertiController::class, 'show'])->name('properti.show');

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::post('/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('admin.users.verify');
    
    // Property Management
    Route::get('/properti', [AdminController::class, 'properti'])->name('admin.properti');
    Route::get('/properti/{properti}', [AdminController::class, 'showProperti'])->name('admin.properti.show');
    Route::post('/properti/{properti}/verify', [AdminController::class, 'verifyProperti'])->name('admin.properti.verify');
      // Transaction Management
    Route::get('/transaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');
    Route::get('/transaksi/{transaksi}', [AdminController::class, 'showTransaksi'])->name('admin.transaksi.show');
    
    // Reports & Inspections
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    Route::resource('inspeksi', InspeksiController::class);
    Route::post('/inspeksi/{properti}/create', [InspeksiController::class, 'create'])->name('inspeksi.create.properti');
});

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    // Property Routes
    Route::middleware(['role:penjual'])->group(function () {
        Route::get('/properti/create', [PropertiController::class, 'create'])->name('properti.create');
        Route::post('/properti', [PropertiController::class, 'store'])->name('properti.store');
        Route::get('/properti/{properti}/edit', [PropertiController::class, 'edit'])->name('properti.edit');
        Route::put('/properti/{properti}', [PropertiController::class, 'update'])->name('properti.update');
        Route::delete('/properti/{properti}', [PropertiController::class, 'destroy'])->name('properti.delete');
    });    // Favorite Routes
    Route::get('/favorit', [FavoritController::class, 'index'])->name('favorit.index');
    Route::post('/favorit/{properti}', [FavoritController::class, 'store'])->name('favorit.store');
    Route::delete('/favorit/{properti}', [FavoritController::class, 'destroy'])->name('favorit.destroy');

    // Transaction Routes
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/properti/{properti}', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::put('/transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.status.update');

    // Payment Routes
    Route::post('/pembayaran/transaksi/{transaksi}', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::put('/pembayaran/{pembayaran}/confirm', [PembayaranController::class, 'confirm'])->name('pembayaran.confirm');
    Route::put('/pembayaran/{pembayaran}/reject', [PembayaranController::class, 'reject'])->name('pembayaran.reject');

    // Messaging Routes
    Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/{user}', [PesanController::class, 'show'])->name('pesan.show');
    Route::post('/pesan/{user}', [PesanController::class, 'store'])->name('pesan.store');

    // Notification Routes
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::put('/notifikasi/{notifikasi}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');

    // User Profile Routes
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('user.password.update');
});

// Dokumen Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dokumen/properti/{properti}', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::post('/dokumen/upload', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])->name('dokumen.show');
    Route::delete('/dokumen/{dokumen}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
    Route::post('/dokumen/{dokumen}/status', [DokumenController::class, 'updateStatus'])->name('dokumen.status.update');
});

require __DIR__.'/auth.php';