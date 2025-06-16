<?php

namespace App\Http\Controllers;

use App\Models\Properti;
use App\Models\Favorit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $favorit = $user->favorit()
            ->with('properti.user')
            ->latest()
            ->paginate(12);

        return view('favorit.index', compact('favorit'));
    }    public function store(Request $request, Properti $properti)
    {
        /** @var User $user */
        $user = Auth::user();
        $favorit = $user->favorit()->create([
            'properti_id' => $properti->properti_id,
            'tanggal_disimpan' => now()
        ]);

        return back()->with('success', 'Property has been added to favorites');
    }    public function destroy(Properti $properti)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->favorit()
            ->where('properti_id', $properti->properti_id)
            ->delete();

        return back()->with('success', 'Property has been removed from favorites');
    }
}
