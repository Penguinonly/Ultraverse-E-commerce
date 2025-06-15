<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SavedPropertyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\Pembeli\DashboardController as PembeliDashboardController;
use Illuminate\Http\Request;
use App\Models\User;

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

// Guest/Public Routes
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

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard Routes
    Route::get('/dashboard_search', [DashboardController::class, 'search'])->name('dashboard_search');
    Route::get('/dashboard_detail', [DashboardController::class, 'detail'])->name('dashboard_detail');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // Chat & Notifications
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    
    // Saved Properties
    Route::get('/simpan', [SavedPropertyController::class, 'index'])->name('simpan');
    Route::post('/simpan/{id}', [SavedPropertyController::class, 'store'])->name('simpan.store');
    Route::delete('/simpan/{id}', [SavedPropertyController::class, 'destroy'])->name('simpan.destroy');
});

// Seller (Penjual) Routes
Route::prefix('penjual')
    ->middleware(['auth', 'role:penjual', 'penjual.session'])
    ->group(function () {
        // Dashboard (Main Seller Page)
        Route::get('/dashboard', [\App\Http\Controllers\Penjual\DashboardController::class, 'index'])
            ->name('penjual.dashboard');

        // Property Management
        Route::get('/properti', [\App\Http\Controllers\Penjual\DashboardController::class, 'properti'])
            ->name('penjual.properti');
        Route::post('/properti/store', [PropertiController::class, 'store'])
            ->name('penjual.properti.store');
        Route::put('/properti/{id}', [PropertiController::class, 'update'])
            ->name('penjual.properti.update');
        Route::delete('/properti/{id}', [PropertiController::class, 'destroy'])
            ->name('penjual.properti.destroy');

        // Document Management
        Route::get('/dokumen', [\App\Http\Controllers\Penjual\DashboardController::class, 'dokumen'])
            ->name('penjual.dokumen');
        Route::post('/dokumen/upload', [\App\Http\Controllers\Penjual\DashboardController::class, 'uploadDocument'])
            ->name('penjual.dokumen.upload');

        // House Management
        Route::get('/rumah', [\App\Http\Controllers\Penjual\DashboardController::class, 'rumah'])
            ->name('penjual.rumah');
        
        // Settings
        Route::get('/pengaturan', [\App\Http\Controllers\Penjual\DashboardController::class, 'pengaturan'])
            ->name('penjual.pengaturan');
        Route::post('/pengaturan/update', [\App\Http\Controllers\Penjual\DashboardController::class, 'updateSettings'])
            ->name('penjual.pengaturan.update');

        // Payment Management
        Route::prefix('inpay')->group(function () {
            Route::get('/', [\App\Http\Controllers\Penjual\DashboardController::class, 'inpay'])
                ->name('penjual.inpay');
            Route::get('/transactions', [\App\Http\Controllers\Penjual\DashboardController::class, 'transactions'])
                ->name('penjual.inpay.transactions');
            Route::get('/invoice/{id}', [\App\Http\Controllers\Penjual\DashboardController::class, 'showInvoice'])
                ->name('penjual.inpay.invoice');
            Route::post('/process', [\App\Http\Controllers\Penjual\DashboardController::class, 'processPayment'])
                ->name('penjual.inpay.process');
            Route::get('/history', [\App\Http\Controllers\Penjual\DashboardController::class, 'paymentHistory'])
                ->name('penjual.inpay.history');
            Route::post('/withdraw', [\App\Http\Controllers\Penjual\DashboardController::class, 'requestWithdraw'])
                ->name('penjual.inpay.withdraw');
        });
        
        // Information
        Route::get('/keterangan', [\App\Http\Controllers\Penjual\DashboardController::class, 'keterangan'])
            ->name('penjual.keterangan');
    });

// Buyer (Pembeli) Routes
Route::prefix('pembeli')
    ->middleware(['auth', 'role:pembeli', 'pembeli.session'])
    ->group(function () {
        // Dashboard (Main Buyer Page)
        Route::get('/dashboard', [\App\Http\Controllers\Pembeli\DashboardController::class, 'index'])
            ->name('pembeli.dashboard');
            
        // Property Details
        Route::get('/detail/{id}', [\App\Http\Controllers\Pembeli\DashboardController::class, 'detail'])
            ->name('pembeli.detail');
            
        // User Settings
        Route::get('/pengaturan', [\App\Http\Controllers\Pembeli\DashboardController::class, 'pengaturan'])
            ->name('pembeli.pengaturan');
        Route::post('/pengaturan/update', [\App\Http\Controllers\Pembeli\DashboardController::class, 'updatePengaturan'])
            ->name('pembeli.pengaturan.update');
            
        // Transaction Details
        Route::get('/rincian', [\App\Http\Controllers\Pembeli\DashboardController::class, 'rincian'])
            ->name('pembeli.rincian');
            
        // Payment Management
        Route::get('/inpay', [\App\Http\Controllers\Pembeli\DashboardController::class, 'inpay'])
            ->name('pembeli.inpay');
        
        // Saved Properties
        Route::get('/simpan', [\App\Http\Controllers\Pembeli\DashboardController::class, 'simpan'])
            ->name('pembeli.simpan');
        Route::post('/simpan/{property}', [SavedPropertyController::class, 'store'])
            ->name('pembeli.simpan.store');
        Route::delete('/simpan/{property}', [SavedPropertyController::class, 'destroy'])
            ->name('pembeli.simpan.destroy');
    });

// Admin Routes
Route::prefix('admin')
    ->middleware(['auth', 'role:admin', 'admin.session'])
    ->group(function () {
        // Dashboard (Main Admin Page)
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('admin.dashboard');

        // Calendar Management
        Route::get('/calendar', [\App\Http\Controllers\Admin\DashboardController::class, 'calendar'])
            ->name('admin.calendar');

        // Document Management
        Route::get('/documents', [\App\Http\Controllers\Admin\DashboardController::class, 'documents'])
            ->name('admin.documents');
        Route::post('/documents/upload', [\App\Http\Controllers\Admin\DashboardController::class, 'uploadDocument'])
            ->name('admin.documents.upload');

        // User/Property Management
        Route::get('/manage', [\App\Http\Controllers\Admin\DashboardController::class, 'manage'])
            ->name('admin.manage');
        Route::get('/users', [AdminController::class, 'users'])
            ->name('admin.users');
        Route::get('/properties', [AdminController::class, 'properties'])
            ->name('admin.properties');

        // Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\DashboardController::class, 'settings'])
            ->name('admin.settings');
        Route::post('/settings/update', [\App\Http\Controllers\Admin\DashboardController::class, 'updateSettings'])
            ->name('admin.settings.update');

        // Legality Management
        Route::get('/legality', [\App\Http\Controllers\Admin\DashboardController::class, 'legality'])
            ->name('admin.legality');
        Route::post('/legality/update', [\App\Http\Controllers\Admin\DashboardController::class, 'updateLegality'])
            ->name('admin.legality.update');

        // Information/Details
        Route::get('/information', [\App\Http\Controllers\Admin\DashboardController::class, 'information'])
            ->name('admin.information');
        Route::post('/information/update', [\App\Http\Controllers\Admin\DashboardController::class, 'updateInformation'])
            ->name('admin.information.update');
    });

require __DIR__.'/auth.php';