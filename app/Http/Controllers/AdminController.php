<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function properties()
    {
        $properties = Property::with('user')->get();
        return view('admin.properties', compact('properties'));
    }
}
