<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\SavedProperty;
use App\Models\Payment;
use App\Models\User;
use App\Models\Notification;

class DashboardController extends Controller
{
    /**
     * Display pembeli dashboard with summary statistics
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Get saved properties with their details
            $savedProperties = SavedProperty::where('user_id', $user->id)
                ->with(['property', 'property.user'])
                ->latest()
                ->take(6)
                ->get();

            // Get recent payments/transactions
            $recentPayments = Payment::where('buyer_id', $user->id)
                ->with(['property', 'seller'])
                ->latest()
                ->take(5)
                ->get();

            // Calculate summary statistics
            $stats = [
                'total_saved' => SavedProperty::where('user_id', $user->id)->count(),
                'total_transactions' => Payment::where('buyer_id', $user->id)->count(),
                'total_spent' => Payment::where('buyer_id', $user->id)
                    ->where('status', 'completed')
                    ->sum('amount'),
                'active_transactions' => Payment::where('buyer_id', $user->id)
                    ->where('status', 'pending')
                    ->count()
            ];
                
            return view('pembeli.dashboard', compact(
                'savedProperties',
                'recentPayments',
                'stats'
            ));
        } catch (\Exception $e) {
            Log::error('Error loading pembeli dashboard: ' . $e->getMessage());
            return redirect()->route('home')
                ->with('error', 'Error loading dashboard. Please try again.');
        }
    }

    /**
     * Display property details with related properties
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function detail($id)
    {
        try {
            $property = Property::with(['user', 'images', 'documents'])
                ->findOrFail($id);

            // Check if property is saved by user
            $isSaved = SavedProperty::where('user_id', Auth::id())
                ->where('property_id', $id)
                ->exists();

            // Get similar properties
            $similarProperties = Property::where('type', $property->type)
                ->where('id', '!=', $id)
                ->take(4)
                ->get();

            return view('pembeli.detail', compact(
                'property',
                'isSaved',
                'similarProperties'
            ));
        } catch (\Exception $e) {
            Log::error('Error showing property detail: ' . $e->getMessage());
            return redirect()->route('pembeli.dashboard')
                ->with('error', 'Error loading property details. Please try again.');
        }
    }

    /**
     * Display user settings page
     *
     * @return \Illuminate\View\View
     */
    public function pengaturan()
    {
        try {
            $user = Auth::user();
            $settings = $user->settings;
            
            return view('pembeli.pengaturan', compact('user', 'settings'));
        } catch (\Exception $e) {
            Log::error('Error loading settings page: ' . $e->getMessage());
            return redirect()->route('pembeli.dashboard')
                ->with('error', 'Error loading settings. Please try again.');
        }
    }

    /**
     * Update user settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePengaturan(Request $request)
    {
        try {
            DB::beginTransaction();
            
            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]{10,})$/'],
                'address' => 'required|string|max:500',
                'avatar' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg',
                    'max:2048',
                    'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
                ],
                'notification_preferences' => 'nullable|array',
                'language' => 'nullable|string|in:en,id'
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                
                if (!$avatar->isValid()) {
                    throw new \Exception('Invalid image file uploaded');
                }
                
                $filename = 'avatar-' . Str::uuid() . '.' . $avatar->getClientOriginalExtension();
                
                try {
                    if ($user->avatar) {
                        $oldAvatarPath = 'public/avatars/' . $user->avatar;
                        if (Storage::exists($oldAvatarPath)) {
                            Storage::delete($oldAvatarPath);
                        }
                    }
                    
                    $path = $avatar->storeAs('public/avatars', $filename);
                    if (!$path) {
                        throw new \Exception('Failed to upload avatar');
                    }
                    
                    $user->avatar = $filename;
                } catch (\Exception $e) {
                    Log::error('Avatar upload error: ' . $e->getMessage());
                    throw new \Exception('Failed to process avatar upload');
                }
            }

            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
            
            $user->save();

            if ($request->has('notification_preferences')) {
                $user->settings()->updateOrCreate(
                    ['user_id' => $user->id],
                    ['notification_preferences' => $request->notification_preferences]
                );
            }

            if ($request->has('language')) {
                $user->settings()->updateOrCreate(
                    ['user_id' => $user->id],
                    ['language' => $request->language]
                );
            }
            
            DB::commit();
            
            return redirect()->back()
                ->with('success', 'Profile settings updated successfully');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Profile update error for user ' . Auth::id() . ': ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating profile settings. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display transaction details with filtering
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function rincian(Request $request)
    {
        try {
            $query = Payment::where('buyer_id', Auth::id())
                ->with(['property', 'seller']);

            // Apply filters
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('date_range')) {
                $dates = explode(' - ', $request->date_range);
                if (count($dates) === 2) {
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::parse($dates[0])->startOfDay(),
                        \Carbon\Carbon::parse($dates[1])->endOfDay()
                    ]);
                }
            }

            $transactions = $query->latest()->paginate(10);
            $totalAmount = $query->sum('amount');
            
            return view('pembeli.rincian', compact('transactions', 'totalAmount'));
        } catch (\Exception $e) {
            Log::error('Error loading transaction details: ' . $e->getMessage());
            return redirect()->route('pembeli.dashboard')
                ->with('error', 'Error loading transaction details. Please try again.');
        }
    }

    /**
     * Display payment interface with payment history
     *
     * @return \Illuminate\View\View
     */
    public function inpay()
    {
        try {
            $user = Auth::user();
            
            $payments = Payment::where('buyer_id', $user->id)
                ->with(['property', 'seller'])
                ->latest()
                ->paginate(10);

            $stats = [
                'total_spent' => Payment::where('buyer_id', $user->id)
                    ->where('status', 'completed')
                    ->sum('amount'),
                'pending_payments' => Payment::where('buyer_id', $user->id)
                    ->where('status', 'pending')
                    ->sum('amount'),
                'this_month' => Payment::where('buyer_id', $user->id)
                    ->where('status', 'completed')
                    ->whereMonth('created_at', now()->month)
                    ->sum('amount')
            ];
            
            return view('pembeli.inpay', compact('payments', 'stats'));
        } catch (\Exception $e) {
            Log::error('Error loading payment interface: ' . $e->getMessage());
            return redirect()->route('pembeli.dashboard')
                ->with('error', 'Error loading payment information. Please try again.');
        }
    }

    /**
     * Display saved properties with filters
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function simpan(Request $request)
    {
        try {
            $query = SavedProperty::where('user_id', Auth::id())
                ->with(['property', 'property.user']);

            // Apply filters
            if ($request->has('type')) {
                $query->whereHas('property', function($q) use ($request) {
                    $q->where('type', $request->type);
                });
            }

            if ($request->has('price_range')) {
                $query->whereHas('property', function($q) use ($request) {
                    $range = explode('-', $request->price_range);
                    if (count($range) === 2) {
                        $q->whereBetween('price', [$range[0], $range[1]]);
                    }
                });
            }

            $savedProperties = $query->latest()->paginate(12);
            
            return view('pembeli.simpan', compact('savedProperties'));
        } catch (\Exception $e) {
            Log::error('Error loading saved properties: ' . $e->getMessage());
            return redirect()->route('pembeli.dashboard')
                ->with('error', 'Error loading saved properties. Please try again.');
        }
    }
}
