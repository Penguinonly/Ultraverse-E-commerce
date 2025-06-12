<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('Home.home');
});

Route::get('/aboutUS', function () {
    return view('Home.aboutUS');
});

Route::get('/service', function () {
    return view('Home.service');
});


// Product CRUD
Route::resource('products', ProductController::class);

// ========== AUTH ROUTES ==========

// Register
Route::get('/create', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/create', [AuthController::class, 'register'])->name('register.post');

// Login
Route::get('/signIn', [AuthController::class, 'login'])->name('auth.login');
Route::post('/signIn', [AuthController::class, 'authenticate'])->name('authenticate');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Redirect /dashboard ke /dashboard_search agar tidak 404
Route::redirect('/dashboard', '/dashboard_search');

// ========== AUTHENTICATED ROUTES ==========
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard_search', function () {
        return view('Home.dashboard_search');
    })->name('dashboard_search');

    Route::get('/dashboard_detail', function () {
        return view('Home.dashboard_detail');
    })->name('dashboard_detail');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk halaman simpan
    Route::get('/simpan', function () {
        return view('Home.simpan');
    })->name('simpan');
});

require __DIR__.'/auth.php';