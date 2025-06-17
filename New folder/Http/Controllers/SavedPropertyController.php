<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\SavedProperty;
use Illuminate\Support\Facades\Auth;

class SavedPropertyController extends Controller
{
    public function index()
    {
        // Jika kita menggunakan autentikasi, kita bisa mendapatkan properti yang disimpan oleh user yang sedang login
        // $savedProperties = Auth::user()->savedProperties()->paginate(6);
        
        // Untuk sementara, kita akan menggunakan data dummy
        $savedProperties = collect([
            (object)[
                'id' => 1,
                'image_url' => 'images/Dashboard/Rumah1.jpg',
                'title' => 'Rumah Modern Minimalis',
                'location' => 'PAREPARE, SULAWESI SELATAN',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area' => 90,
                'price' => 850000000,
                'status' => 'Lulus Uji'
            ],
            (object)[
                'id' => 2,
                'image_url' => 'images/Dashboard/Rumah2.jpg',
                'title' => 'Rumah Minimalis Elegan',
                'location' => 'PAREPARE, SULAWESI SELATAN',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 254,
                'price' => 1250000000,
                'status' => 'Lulus Uji'
            ],
            (object)[
                'id' => 3,
                'image_url' => 'images/Dashboard/Rumah3.jpg',
                'title' => 'Rumah Klasik Asri',
                'location' => 'PAREPARE, SULAWESI SELATAN',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 254,
                'price' => 1450000000,
                'status' => 'Lulus Uji'
            ]
        ]);

        // Menambahkan method paginate ke collection
        $savedProperties = new \Illuminate\Pagination\LengthAwarePaginator(
            $savedProperties,
            $savedProperties->count(),
            6,
            1,
            ['path' => request()->url()]
        );

        return view('Home.simpan', compact('savedProperties'));
    }

    public function store(Request $request, $propertyId)
    {
        // Logic untuk menyimpan properti ke daftar tersimpan
        // Akan diimplementasikan nanti
    }

    public function destroy($propertyId)
    {
        // Logic untuk menghapus properti dari daftar tersimpan
        // Akan diimplementasikan nanti
    }
}
