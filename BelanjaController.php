<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BelanjaController extends Controller
{
    public function index()
    {
        return view('In_Home.Belanja.belanja');
    }
}
