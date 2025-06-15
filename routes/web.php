<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PropertiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SavedPropertyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\Pembeli\DashboardController as PembeliDashboardController;

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

// Public/Guest Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/aboutUS', [HomeController::class, 'about'])->name('about');
Route::get('/service', [HomeController::class, 'service'])->name('service');

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/signIn', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/signIn', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/create', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/create', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Admin Routes
Route::middleware(['auth', 'ultraverse.session:admin'])->prefix('admin')->group(function () {
    // Dashboard and List Views
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/properties', [AdminController::class, 'properties'])->name('admin.properties');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/verifications', [AdminController::class, 'verifications'])->name('admin.verifications');
    
    // Detailed Views
    Route::get('/users/{user}', [AdminController::class, 'showUserDetails'])->name('admin.users.show');
    Route::get('/properties/{property}', [AdminController::class, 'showPropertyDetails'])->name('admin.properties.show');
    Route::get('/transactions/{payment}', [AdminController::class, 'showTransactionDetails'])->name('admin.transactions.show');
    
    // Actions
    Route::post('/users/{user}/verification', [AdminController::class, 'updateVerification'])->name('admin.verification.update');
});

// Penjual Routes
Route::middleware(['auth', 'ultraverse.session:penjual'])->prefix('penjual')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'penjual'])->name('penjual.dashboard');
    
    // Property Management
    Route::prefix('properti')->group(function () {
        Route::get('/upload/{section?}', [PropertiController::class, 'showUploadForm'])
            ->where('section', 'rumah|dokumen|jadwal')
            ->name('properti.upload');
        Route::post('/upload/rumah', [PropertiController::class, 'saveRumah'])->name('properti.save.rumah');
        Route::post('/upload/dokumen', [PropertiController::class, 'saveDokumen'])->name('properti.save.dokumen');
        Route::post('/upload/jadwal', [PropertiController::class, 'saveJadwal'])->name('properti.save.jadwal');
        Route::get('/listings', [PropertiController::class, 'listings'])->name('properti.listings');
    });
    
    // Schedule Management
    Route::prefix('jadwal')->group(function () {
        Route::get('/', [PropertiController::class, 'jadwal'])->name('jadwal.index');
    });
});

// Pembeli Routes
Route::middleware(['auth', 'ultraverse.session:pembeli'])->prefix('pembeli')->group(function () {
    Route::get('/dashboard', [PembeliDashboardController::class, 'index'])->name('pembeli.dashboard');
    Route::get('/saved-properties', [SavedPropertyController::class, 'index'])->name('pembeli.saved');
    Route::post('/save-property/{id}', [SavedPropertyController::class, 'store'])->name('pembeli.save');
    Route::delete('/unsave-property/{id}', [SavedPropertyController::class, 'destroy'])->name('pembeli.unsave');
});

// Shared Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });
    
    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/mark-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    });
    
    // Chat
    Route::prefix('chat')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('chat');
        Route::get('/conversation/{id}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/send', [ChatController::class, 'send'])->name('chat.send');
    });
    
    // Property Search & View
    Route::prefix('properti')->group(function () {
        Route::get('/search', [PropertiController::class, 'search'])->name('properti.search');
        Route::get('/{id}', [PropertiController::class, 'show'])->name('properti.show');
    });
});

// Shared Saved Property Routes
Route::middleware(['auth'])->prefix('saved-properties')->group(function () {
    Route::get('/', [SavedPropertyController::class, 'index'])->name('saved-properties.index');
    Route::get('/check/{propertyId}', [SavedPropertyController::class, 'check'])->name('saved-properties.check');
    Route::post('/toggle/{propertyId}', [SavedPropertyController::class, 'toggle'])->name('saved-properties.toggle');
    Route::post('/{propertyId}', [SavedPropertyController::class, 'store'])->name('saved-properties.store');
    Route::delete('/{propertyId}', [SavedPropertyController::class, 'destroy'])->name('saved-properties.destroy');
});

// Email Verification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');
    
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'sendVerification'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});

require __DIR__.'/auth.php';