<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\PaymentProcessed;

class TransactionController extends Controller
{
    public function processPayment(Request $request, Property $property)
    {
        try {
            $request->validate([
                'payment_method' => 'required|string',
                'amount' => 'required|numeric|min:1000'
            ]);

            DB::beginTransaction();

            $payment = Payment::create([
                'seller_id' => $property->user_id,
                'buyer_id' => Auth::id(),
                'property_id' => $property->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'transaction_id' => 'TRX-' . uniqid(),
                'payment_date' => now()
            ]);

            event(new PaymentProcessed($payment));

            DB::commit();

            return redirect()->route('pembeli.rincian')
                ->with('success', 'Payment processed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing error: ' . $e->getMessage());
            return back()->with('error', 'Error processing payment. Please try again.');
        }
    }

    public function sellerTransactions()
    {
        try {
            $transactions = Payment::where('seller_id', Auth::id())
                ->with(['property', 'buyer'])
                ->latest()
                ->paginate(10);

            $stats = [
                'total_earnings' => Payment::where('seller_id', Auth::id())
                    ->where('status', 'completed')
                    ->sum('amount'),
                'pending_amount' => Payment::where('seller_id', Auth::id())
                    ->where('status', 'pending')
                    ->sum('amount'),
                'this_month' => Payment::where('seller_id', Auth::id())
                    ->where('status', 'completed')
                    ->whereMonth('created_at', now()->month)
                    ->sum('amount')
            ];

            return view('penjual.transactions', compact('transactions', 'stats'));

        } catch (\Exception $e) {
            Log::error('Error loading seller transactions: ' . $e->getMessage());
            return redirect()->route('penjual.dashboard')
                ->with('error', 'Error loading transactions. Please try again.');
        }
    }
}
