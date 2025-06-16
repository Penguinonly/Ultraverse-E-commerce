<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Properti;
use App\Models\Favorit;
use App\Models\Transaksi;
use App\Models\Notifikasi;
use App\Models\Payment;
use App\Models\SavedProperty;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request and redirect to appropriate dashboard
     * based on user role
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Check if user is active
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda belum diaktifkan. Silakan hubungi admin.');
        }
        
        // Get unread notifications
        $notifications = Notifikasi::where('user_id', $user->id)
            ->where('read', false)
            ->latest()
            ->get();
            
        // Store notifications in view share for all views
        view()->share('notifications', $notifications);
        session(['unread_notifications_count' => $notifications->count()]);
        
        // Redirect based on role with role-specific data
        switch ($user->role) {
            case 'admin':
                $pendingUsers = \App\Models\User::where('is_active', false)->count();
                $pendingProperties = Properti::where('approved', false)->count();
                
                return redirect()->route('admin.dashboard')->with([
                    'pending_users' => $pendingUsers,
                    'pending_properties' => $pendingProperties
                ]);
                
            case 'penjual':
                $myProperties = Properti::where('user_id', $user->id)->count();
                $pendingProperties = Properti::where('user_id', $user->id)
                    ->where('approved', false)
                    ->count();
                $activeListings = Properti::where('user_id', $user->id)
                    ->where('approved', true)
                    ->where('is_active', true)
                    ->count();
                $pendingTransaksi = Transaksi::whereHas('properti', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->where('status', 'pending')->count();
                
                return redirect()->route('penjual.dashboard')->with([
                    'my_properties' => $myProperties,
                    'pending_properties' => $pendingProperties,
                    'active_listings' => $activeListings,
                    'pending_transaksi' => $pendingTransaksi
                ]);
                
            case 'pembeli':
                $savedProperties = SavedProperty::where('user_id', $user->id)->count();
                $activeTransaksi = Transaksi::where('user_id', $user->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->count();
                $recentProperties = Properti::where('approved', true)
                    ->where('is_active', true)
                    ->latest()
                    ->take(6)
                    ->get();
                    
                return redirect()->route('pembeli.dashboard')->with([
                    'saved_properties' => $savedProperties,
                    'active_transaksi' => $activeTransaksi,
                    'recent_properties' => $recentProperties
                ]);
                
            default:
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Invalid user role. Please contact administrator.');
        }
    }

    /**
     * Show property search page with filters
     */
    public function search(Request $request)
    {
        $query = Properti::with(['user', 'gambar_properti'])
            ->where('approved', true)
            ->where('is_active', true);
            
        // Apply filters
        if ($request->has('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }
        if ($request->has('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }
        if ($request->has('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }
        if ($request->has('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        
        $properti = $query->latest()->paginate(12);
        return view('dashboard.search', compact('properti'));
    }

    /**
     * Show property details with related properties
     */
    public function detail(Properti $properti)
    {
        // Check if property is approved and active
        if (!$properti->approved || !$properti->is_active) {
            return redirect()->route('properti.index')
                ->with('error', 'Properti tidak ditemukan atau sudah tidak tersedia.');
        }
        
        $properti->load(['user', 'gambar_properti', 'dokumen']);
        
        // Check if property is saved by current user
        $isSaved = false;
        if (Auth::check()) {
            $isSaved = SavedProperty::where('user_id', Auth::id())
                ->where('properti_id', $properti->id)
                ->exists();
        }
        
        // Get related properties
        $relatedProperties = Properti::where('id', '!=', $properti->id)
            ->where('approved', true)
            ->where('is_active', true)
            ->where(function($q) use ($properti) {
                $q->where('lokasi', 'like', '%' . $properti->lokasi . '%')
                    ->orWhere('tipe', $properti->tipe);
            })
            ->take(4)
            ->get();
            
        return view('dashboard.detail', compact('properti', 'isSaved', 'relatedProperties'));
    }
}
