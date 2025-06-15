<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.dashboard', compact('user'));
    }

    public function calendar()
    {
        return view('admin.calendar');
    }

    public function documents()
    {
        return view('admin.dokumen');
    }

    public function manage()
    {
        return view('admin.manage');
    }

    public function settings()
    {
        return view('admin.pengaturan');
    }

    public function legality()
    {
        return view('admin.legalitas');
    }

    public function information()
    {
        return view('admin.keterangan');
    }
}
