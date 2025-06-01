<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('In_Home.Home.home');
});

Route::get('/aboutUS', function () {
    return view('In_Home.About.aboutUS');
});

Route::get('/service', function () {
    return view('In_Home.Service.service');
});

// Tambahan route untuk belanja

use App\Http\Controllers\BelanjaController;

Route::get('/belanja', [BelanjaController::class, 'index']);
