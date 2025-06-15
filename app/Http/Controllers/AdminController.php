<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_properties' => Property::count(),
            'pending_verifications' => User::whereNull('verifikasi_wajah')->count(),
            'total_transactions' => Payment::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_properties' => Property::with('user')->latest()->take(5)->get(),
            'recent_transactions' => Payment::with(['user', 'property'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::withCount(['properties', 'savedProperties', 'payments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.users', compact('users'));
    }

    public function properties()
    {
        $properties = Property::with(['user', 'images'])
            ->withCount('savedProperties')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.properties', compact('properties'));
    }

    public function transactions()
    {
        $transactions = Payment::with(['user', 'property', 'property.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.transactions', compact('transactions'));
    }

    public function verifications()
    {
        $pendingVerifications = User::where(function($query) {
            $query->whereNull('verifikasi_wajah')
                  ->orWhereNull('foto_ktp');
        })
        ->where('role', 'penjual')
        ->with(['properties' => function($query) {
            $query->select('id', 'user_id', 'status');
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(10);
            
        return view('admin.verifications', compact('pendingVerifications'));
    }

    public function updateVerification(Request $request, User $user)
    {
        $request->validate([
            'verification_status' => 'required|in:approved,rejected',
            'verification_type' => 'required|in:wajah,ktp',
            'rejection_reason' => 'required_if:verification_status,rejected'
        ]);

        $updateData = [];
        if ($request->verification_type === 'wajah') {
            $updateData['verifikasi_wajah'] = $request->verification_status === 'approved' ? now() : null;
        } else {
            $updateData['foto_ktp'] = $request->verification_status === 'approved' ? 'verified' : null;
        }

        if ($request->verification_status === 'rejected') {
            $updateData['verification_rejection_reason'] = $request->rejection_reason;
        }

        $user->update($updateData);

        // Update related property statuses if needed
        if ($request->verification_status === 'rejected') {
            Property::where('user_id', $user->id)
                   ->where('status', 'pending')
                   ->update(['status' => 'rejected']);
        }

        return redirect()->back()->with('success', 'Verification status updated successfully');
    }

    public function showUserDetails(User $user)
    {
        // Loading relationships
        $userData = $user->load([
            'properties',
            'savedProperties',
            'buyerPayments',
            'sellerPayments'
        ]);

        // Getting statistics
        $stats = [
            'total_properties' => $userData->properties->count(),
            'saved_properties' => $userData->savedProperties->count(),
            'total_purchases' => $userData->buyerPayments->count(),
            'total_sales' => $userData->sellerPayments->count(),
        ];

        return view('admin.user-details', compact('userData', 'stats'));
    }

    public function showPropertyDetails(Property $property)
    {
        $property->load([
            'user',
            'images',
            'payments',
            'savedProperties.user'
        ]);

        return view('admin.property-details', compact('property'));
    }

    public function showTransactionDetails(Payment $payment)
    {
        $payment->load([
            'user',
            'property',
            'property.user',
            'property.images'
        ]);

        return view('admin.transaction-details', compact('payment'));
    }
}
