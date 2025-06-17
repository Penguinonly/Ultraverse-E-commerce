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
use App\Events\PaymentProcessed; // Not used in this controller, consider removing if truly unused.
use App\Events\WithdrawalRequested;
use Barryvdh\DomPDF\Facade\Pdf; // Not used in this controller, consider removing if truly unused.

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
        // Eager load properties to prevent N+1 query if you display property details later
        $properties = Property::where('user_id', $user->id)->get();
        $totalProperties = $properties->count();

        // Use 'where' on the original collection to avoid modifying it for subsequent counts.
        // Or, better yet, use separate queries for clarity and efficiency if the collection is large.
        $activeProperties = Property::where('user_id', $user->id)
                                    ->where('status', 'active')
                                    ->count();

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
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        return view('penjual.profile', compact('user'));
    }

    /**
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
                // This regex allows digits, spaces, hyphens, plus signs, and parentheses,
                // and requires at least 10 characters.
                'phone' => ['required', 'string', 'max:20', 'regex:/^[\d\s\-\+\(\)]{10,}$/'],
                'address' => 'required|string|max:500',
                'avatar' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg',
                    'max:2048', // 2MB
                    'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
                ]
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');

                // Validate image is valid - This check is somewhat redundant with 'image' and 'mimes' validation,
                // but good for explicit safety.
                if (!$avatar->isValid()) {
                    throw new \Exception('Invalid image file uploaded.');
                }

                // Generate secure filename
                $filename = 'avatar-' . Str::uuid() . '.' . $avatar->getClientOriginalExtension();

                try {
                    // Delete old avatar if exists
                    if ($user->avatar) {
                        $oldAvatarPath = 'public/avatars/' . $user->avatar;
                        if (Storage::exists($oldAvatarPath)) {
                            Storage::delete($oldAvatarPath);
                            Log::info('Old avatar deleted: ' . $oldAvatarPath); // Log deletion for debugging
                        }
                    }

                    // Store new avatar
                    // Laravel's storeAs returns the path relative to the disk's root.
                    // 'public' disk usually maps to storage/app/public.
                    $path = $avatar->storeAs('public/avatars', $filename);
                    if (!$path) {
                        throw new \Exception('Failed to store avatar file.');
                    }

                    $user->avatar = $filename; // Store only the filename in the database
                    Log::info('New avatar uploaded: ' . $filename);
                } catch (\Exception $e) {
                    Log::error('Avatar upload error for user ' . Auth::id() . ': ' . $e->getMessage());
                    throw new \Exception('Failed to process avatar upload. ' . $e->getMessage());
                }
            }

            // Update user profile
            $user->forceFill([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ])->save(); // No need for forceFill if you have fillable properties on the User model.
                        // If 'avatar' is fillable, you can include it here directly.

            DB::commit();

            return redirect()->back()
                ->with('success', 'Profile updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Profile validation error for user ' . Auth::id() . ': ' . $e->getMessage(), $e->errors());
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Profile update error for user ' . Auth::id() . ': ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating profile. Please try again. ' . $e->getMessage()) // Provide more specific error for development.
                ->withInput();
        }
    }

    /**
     * Property Management Methods
     * Display seller's properties
     *
     * @return \Illuminate\View\View
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
     * Display seller's transactions
     *
     * @return \Illuminate\View\View
     */
    public function transactions()
    {
        $transactions = Payment::where('seller_id', Auth::id())
            ->with('property')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('penjual.transactions', compact('transactions'));
    }

    /**
     * Display seller's payment history
     *
     * @return \Illuminate\View\View
     */
    public function paymentHistory()
    {
        $payments = Payment::where('seller_id', Auth::id())
            ->with(['property', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('penjual.payments.history', compact('payments'));
    }

    /**
     * Display a specific invoice for a payment
     *
     * @param int $paymentId
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function showInvoice($paymentId)
    {
        $payment = Payment::with(['property', 'buyer', 'seller'])
            ->findOrFail($paymentId);

        if ($payment->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized access to invoice.'); // More specific message for unauthorized access.
        }

        // Ambil notifikasi untuk ditampilkan bersama invoice
        // This query might be better placed in a View Composer or a dedicated Notification controller
        // if notifications are a global feature.
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

    /**
     * Handle a withdrawal request from the seller
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestWithdraw(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:10000', // Assuming minimum withdrawal is 10,000 units.
                'bank_name' => 'required|string|max:255',
                'account_number' => 'required|string|max:255',
                'account_name' => 'required|string|max:255'
            ]);

            DB::beginTransaction();

            $withdrawal = Withdrawal::create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'status' => 'pending' // Initial status
            ]);

            // Dispatch event for withdrawal request
            // Ensure WithdrawalRequested event and its listeners are properly set up.
            WithdrawalRequested::dispatch($withdrawal);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Withdrawal request submitted successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Withdrawal request validation error for user ' . Auth::id() . ': ' . $e->getMessage(), $e->errors());
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Withdrawal request error for user ' . Auth::id() . ': ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error processing withdrawal request. Please try again. ' . $e->getMessage()) // Provide more specific error for development.
                ->withInput();
        }
    }

    public function documents()
    {
        $documents = Document::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('view.penjual.dokumen', compact('documents'));
    }

    public function uploadDocument(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'document' => [
                    'required',
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:10240',
                    'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ],
                'type' => 'required|string|in:property_deed,business_permit,tax_document,identity_card,bank_statement',
                'description' => 'required|string|max:500|min:10'
            ]);

            if (!$request->hasFile('document') || !$request->file('document')->isValid()) {
                throw new \Exception('Invalid document file provided or file upload failed.');
            }

            $file = $request->file('document');
            $filename = 'doc-' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $userPath = 'documents/' . Auth::id();
            $path = $file->storeAs($userPath, $filename, 'private');

            if (!$path) {
                throw new \Exception('Failed to store document file.');
            }

            Document::create([
                'user_id' => Auth::id(),
                'filename' => $filename,
                'type' => $request->type,
                'description' => $request->description,
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'status' => 'pending_verification',
                'tanggal_upload' => now()
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Document uploaded successfully and pending verification.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::warning('Document upload validation error for user ' . Auth::id() . ': ' . $e->getMessage(), $e->errors());
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Document upload error for user ' . Auth::id() . ': ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error uploading document. Please try again. ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Display list of all penjual (public)
     *
     * @return \Illuminate\View\View
     */
    public function listPenjual()
    {
        $penjuals = User::where('role', 'penjual')
            ->where('is_active', true)
            ->withCount('properties') // Counts properties directly from the database for efficiency
            ->orderBy('properties_count', 'desc')
            ->paginate(12);

        return view('penjual.list', compact('penjuals'));
    }

    /**
     * Display public profile of a penjual
     *
     * @param int $id
     * @return \Illuminate\View\View
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
     *
     * @param int $id
     * @return \Illuminate\View\View
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