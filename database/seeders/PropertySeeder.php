<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;

class PropertySeeder extends Seeder
{
    public function run()
    {
        // Create a demo user if not exists
        $user = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password'),
            ]
        );

        // Sample properties
        $properties = [
            [
                'title' => 'Rumah Modern Minimalis',
                'image_url' => 'images/Dashboard/Rumah1.jpg',
                'location' => 'PAREPARE, SULAWESI SELATAN',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area' => 90,
                'price' => 850000000,
                'status' => 'Lulus Uji',
            ],
            [
                'title' => 'Rumah Minimalis Elegan',
                'image_url' => 'images/Dashboard/Rumah2.jpg',
                'location' => 'PAREPARE, SULAWESI SELATAN',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 254,
                'price' => 1250000000,
                'status' => 'Lulus Uji',
            ],
            [
                'title' => 'Rumah Klasik Asri',
                'image_url' => 'images/Dashboard/Rumah3.jpg',
                'location' => 'PAREPARE, SULAWESI SELATAN',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 254,
                'price' => 1450000000,
                'status' => 'Lulus Uji',
            ],
        ];

        foreach ($properties as $property) {
            Property::create(array_merge($property, ['user_id' => $user->id]));
        }
    }
}
