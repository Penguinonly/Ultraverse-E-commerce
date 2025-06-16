<?php

namespace App\Http\Controllers;

use App\Models\Properti;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page with featured properties
     */
    public function index()
    {
        $featuredProperties = Properti::with(['user', 'images'])
            ->where('is_active', true)
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->take(6);
            // ->get();
        return view('Home.home', compact('featuredProperties'));
    }

    /**
     * Show the about us page
     */
    public function aboutUs()
    {
        return view('home.about-us');
    }

    /**
     * Show the service page
     */
    public function service()
    {
        return view('home.service');
    }
}