<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Property;
use App\Models\SavedProperty;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display pembeli dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $savedProperties = SavedProperty::where('user_id', $user->id)
            ->with('property')
            ->get();
        $recentPayments = Payment::where('buyer_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        return view('pembeli.dashboard', compact('savedProperties', 'recentPayments'));
    }

    /**
     * Display property details
     */
    public function detail($id)
    {
        $property = Property::findOrFail($id);
        return view('pembeli.detail', compact('property'));
    }

    /**
     * Display user settings
     */
    public function pengaturan()
    {
        $user = Auth::user();
        return view('pembeli.pengaturan', compact('user'));
    }

    /**
     * Update user settings
     */
    public function updatePengaturan(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]{10,})$/'],
            'address' => 'required|string|max:500',
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ]
        ]);

        // Handle avatar upload if provided
        if ($request->hasFile('avatar')) {
            // Upload logic here (similar to penjual)
        }

        $user->update($request->only(['name', 'phone', 'address']));
        
        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    /**
     * Display transaction details
     */
    public function rincian()
    {
        $user = Auth::user();
        $transactions = Payment::where('buyer_id', $user->id)
            ->with(['property', 'seller'])
            ->latest()
            ->paginate(10);
            
        return view('pembeli.rincian', compact('transactions'));
    }

    /**
     * Display payment interface
     */
    public function inpay()
    {
        $user = Auth::user();
        $payments = Payment::where('buyer_id', $user->id)
            ->with(['property', 'seller'])
            ->latest()
            ->paginate(10);
            
        return view('pembeli.inpay', compact('payments'));
    }

    /**
     * Display saved properties
     */
    public function simpan()
    {
        $user = Auth::user();
        $savedProperties = SavedProperty::where('user_id', $user->id)
            ->with(['property', 'property.user'])
            ->latest()
            ->paginate(12);
            
        return view('pembeli.simpan', compact('savedProperties'));
    }
}
