<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function search()
    {
        $properties = Property::all();
        return view('Home.dashboard_search', compact('properties'));
    }

    public function detail()
    {
        return view('Home.dashboard_detail');
    }

    public function penjual()
    {
        $user = Auth::user();
        $properties = Property::where('user_id', $user->id)->get();
        return view('Home.dashboard_search', compact('properties'));
    }

    public function pembeli()
    {
        return view('Home.dashboard_search');
    }
}
