<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Property;
use App\Models\Payment;
use App\Models\Withdrawal;
use App\Models\Document;
use App\Models\Notifikasi;
use App\Events\PaymentProcessed;
use App\Events\WithdrawalRequested;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * DashboardController handles seller dashboard functionalities
 * including profile, properties, payments, and document management.
 */
class DashboardController extends Controller
{
    /**
     * Display seller dashboard with summary statistics
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $properties = Property::where('user_id', $user->id)->get();
        $totalProperties = $properties->count();
        $activeProperties = $properties->where('status', 'active')->count();
        $totalEarnings = Payment::where('seller_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');
        
        return view('penjual.dashboard', compact(
            'totalProperties',
            'activeProperties',
            'totalEarnings'
        ));
    }

    /**
     * Display seller profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('penjual.profile', compact('user'));
    }

    // Profile management methods
    /**
     * Update seller profile information
     */    /**
     * Update seller profile information
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        try {
            DB::beginTransaction();
            
            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            // Enhanced validation with better phone regex
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

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                
                // Validate image is valid
                if (!$avatar->isValid()) {
                    throw new \Exception('Invalid image file uploaded');
                }
                
                // Generate secure filename
                $filename = 'avatar-' . Str::uuid() . '.' . $avatar->getClientOriginalExtension();
                
                try {
                    // Delete old avatar if exists
                    if ($user->avatar) {
                        $oldAvatarPath = 'public/avatars/' . $user->avatar;
                        if (Storage::exists($oldAvatarPath)) {
                            Storage::delete($oldAvatarPath);
                        }
                    }
                    
                    // Store new avatar
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

            // Update user profile
            $user->forceFill([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ])->save();
            
            DB::commit();
            
            return redirect()->back()
                ->with('success', 'Profile updated successfully');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Profile update error for user ' . Auth::id() . ': ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating profile. Please try again.')
                ->withInput();
        }
    }

    /**
     * Property Management Methods
     */
    
    public function properties()
    {
        $properties = Property::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('penjual.properties.index', compact('properties'));
    }

    /**
     * Financial Management Methods
     */
    
    public function transactions()
    {
        $transactions = Payment::where('seller_id', Auth::id())
            ->with('property')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('penjual.transactions', compact('transactions'));
    }

    public function paymentHistory()
    {
        $payments = Payment::where('seller_id', Auth::id())
            ->with(['property', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('penjual.payments.history', compact('payments'));
    }    public function showInvoice($paymentId)
    {
        $payment = Payment::with(['property', 'buyer', 'seller'])
            ->findOrFail($paymentId);
            
        if ($payment->seller_id !== Auth::id()) {
            abort(403);
        }

        // Ambil notifikasi untuk ditampilkan bersama invoice
        $notifications = Notifikasi::where('user_id', Auth::id())
            ->latest()
            ->get();

        // Tandai notifikasi terkait sebagai sudah dibaca
        Notifikasi::where('user_id', Auth::id())
            ->where('properti_id', $payment->property->id)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);
        
        return view('penjual.payments.show-invoice', compact('payment', 'notifications'));
    }

    public function requestWithdraw(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:10000',
                'bank_name' => 'required|string',
                'account_number' => 'required|string',
                'account_name' => 'required|string'
            ]);

            DB::beginTransaction();
            
            $withdrawal = Withdrawal::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'status' => 'pending'
            ]);

            WithdrawalRequested::dispatch($withdrawal);
            
            DB::commit();
            
            return redirect()->back()
                ->with('success', 'Withdrawal request submitted successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error processing withdrawal request')
                ->withInput();
        }
    }

    /**
     * Document Management Methods
     */
    
    public function documents()
    {
        $documents = Document::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('penjual.documents.index', compact('documents'));
    }    /**
     * Upload seller documents with enhanced security and validation
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadDocument(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'document' => [
                    'required',
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:10240', // 10MB max
                    'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ],
                'type' => 'required|string|in:property_deed,business_permit,tax_document,identity_card,bank_statement',
                'description' => 'required|string|max:500|min:10'
            ]);

            if (!$request->hasFile('document') || !$request->file('document')->isValid()) {
                throw new \Exception('Invalid document file provided');
            }

            $file = $request->file('document');
            
            // Generate secure unique filename
            $filename = 'doc-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Store in private storage with user-specific path
            $userPath = 'documents/' . Auth::id();
            $path = $file->storeAs($userPath, $filename, 'private');
            
            if (!$path) {
                throw new \Exception('Failed to store document');
            }

            // Create document record
            Document::create([
                'user_id' => Auth::id(),
                'filename' => $filename,
                'type' => $request->type,
                'description' => $request->description,
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'status' => 'pending_verification'
            ]);

            DB::commit();
            
            return redirect()->back()
                ->with('success', 'Document uploaded successfully and pending verification');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Document upload error for user ' . Auth::id() . ': ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error uploading document. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display list of all penjual (public)
     */
    public function listPenjual()
    {
        $penjuals = User::where('role', 'penjual')
            ->where('is_active', true)
            ->withCount('properties')
            ->orderBy('properties_count', 'desc')
            ->paginate(12);
            
        return view('penjual.list', compact('penjuals'));
    }

    /**
     * Display public profile of a penjual
     */
    public function publicProfile($id)
    {
        $penjual = User::where('role', 'penjual')
            ->where('is_active', true)
            ->findOrFail($id);
            
        return view('penjual.public-profile', compact('penjual'));
    }

    /**
     * Display public properties of a penjual
     */
    public function publicProperties($id)
    {
        $penjual = User::where('role', 'penjual')
            ->where('is_active', true)
            ->findOrFail($id);
            
        $properties = $penjual->properties()
            ->where('status', 'active')
            ->paginate(9);
            
        return view('penjual.public-properties', compact('penjual', 'properties'));
    }
}
