<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PropertiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SavedPropertyController;
use Illuminate\Auth\Events\Verified;
use App\Providers\RouteServiceProvider;

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
// Routes for Penjual
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/dashboard_penjual', function () {
        return view('Home.dashboard_search');
    })->name('dashboard.penjual');
});

// Routes for Pembeli
Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('/dashboard_pembeli', function () {
        return view('Home.dashboard_search');
    })->name('dashboard.pembeli');
});

// Shared routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard_search', function () {
        return view('Home.dashboard_search');
    })->name('dashboard_search');

    Route::get('/dashboard_detail', function () {
        return view('Home.dashboard_detail');
    })->name('dashboard_detail');

    // Rumah routes
    Route::prefix('rumah')->group(function () {
        Route::get('/', function () {
            return view('Agen_Properti.Rumah');
        })->name('rumah.index');
    });

    // Dokumen routes
    Route::prefix('dokumen')->group(function () {
        Route::get('/', function () {
            return view('Agen_Properti.Dokumen');
        })->name('dokumen.index');
    });

    // Jadwal routes
    Route::prefix('jadwal')->group(function () {
        Route::get('/', function () {
            return view('Agen_Properti.Jadwal');
        })->name('jadwal.index');
    });

    // Data routes
    Route::prefix('data')->group(function () {
        Route::get('/', function () {
            return view('Agen_Properti.data');
        })->name('data.index');
    });

    // Admin routes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    // User Data route
    Route::get('/data', function () {
        return view('Agen_Properti.data');
    })->name('user.data');

    // Saved properties route
    Route::get('/simpan', function () {
        return view('Home.simpan');
    })->name('simpan');

    // Chat route
    Route::get('/chat', function () {
        return view('Home.chat');
    })->name('chat');

    // Notifications route
    Route::get('/notifications', function () {
        return view('Home.notifications');
    })->name('notifications');

    // Property upload routes - only for penjual role
    Route::middleware('role:penjual')->prefix('properti')->group(function () {
        // Main property upload form
        Route::get('/upload/{section?}', [PropertiController::class, 'showUploadForm'])
            ->where('section', 'rumah|dokumen|jadwal')
            ->name('properti.upload');
        
        // Property form submissions
        Route::post('/upload/rumah', [PropertiController::class, 'saveRumah'])
            ->name('properti.save.rumah');
        Route::post('/upload/dokumen', [PropertiController::class, 'saveDokumen'])
            ->name('properti.save.dokumen');
        Route::post('/upload/jadwal', [PropertiController::class, 'saveJadwal'])
            ->name('properti.save.jadwal');
    });

    // Document route with role check
    Route::get('/Dokumen', function (Request $request) {
        if (Auth::user()->role === 'penjual') {
            return redirect()->route('properti.upload', ['section' => 'dokumen']);
        }
        // For non-penjual users, show the document list
        return view('Agen_Properti.Dokumen', [
            'user' => [
                'name' => Auth::user()->name,
                'role' => Auth::user()->role
            ]
        ]);
    })->name('dokumen');
});

// Routes that only require authentication (no email verification)
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', function () {
        return view('Agen_Properti.data');
    })->name('profile.show');
    
    Route::get('/profile/edit', function () {
        $user = Auth::user();
        return view('Agen_Properti.data', compact('user'));
    })->name('profile.edit');

    // Document routes
    Route::get('/dokumen', function () {
        return view('Agen_Properti.Dokumen');
    })->name('dokumen');
});

// Routes for saved properties
Route::middleware(['auth'])->group(function () {
    Route::get('/simpan', [SavedPropertyController::class, 'index'])->name('simpan');
    Route::post('/simpan/{id}', [SavedPropertyController::class, 'store'])->name('simpan.store');
    Route::delete('/simpan/{id}', [SavedPropertyController::class, 'destroy'])->name('simpan.destroy');
});

// Email Verification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

require __DIR__.'/auth.php';