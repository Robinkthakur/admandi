<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category\Category;
use App\Models\Location\Location;

class LocationsAndCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create default locations
        // We need location with ID 29 (Punjab) and 1 (Ludhiana) for test compat
        $state = Location::updateOrCreate(
            ['slug' => 'punjab'],
            [
                'id' => 29,
                'name' => 'Punjab',
                'type' => 'state',
                'parent_id' => null,
            ]
        );

        $city = Location::updateOrCreate(
            ['slug' => 'ludhiana'],
            [
                'id' => 1,
                'name' => 'Ludhiana',
                'type' => 'city',
                'parent_id' => 29,
                'latitude' => '30.9010',
                'longitude' => '75.8573',
            ]
        );

        Location::updateOrCreate(
            ['slug' => 'amritsar'],
            [
                'id' => 2,
                'name' => 'Amritsar',
                'type' => 'city',
                'parent_id' => 29,
            ]
        );

        // 2. Create default categories
        $categories = [
            'mobiles' => 'Mobiles',
            'vehicles' => 'Vehicles',
            'bikes' => 'Bikes',
            'property' => 'Property',
            'electronics' => 'Electronics',
            'home-furniture' => 'Home & Furniture',
            'fashion' => 'Fashion',
            'jobs' => 'Jobs',
            'services' => 'Services',
            'computers' => 'Computers & Accessories'
        ];

        $order = 1;
        foreach ($categories as $slug => $name) {
            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'status' => 1,
                    'order_no' => $order++,
                    'image' => 'categories/'.$slug.'.png'
                ]
            );
        }

        // Create a subcategory under mobiles
        $parentCat = Category::where('slug', 'mobiles')->first();
        if ($parentCat) {
            Category::updateOrCreate(
                ['slug' => 'smartphones'],
                [
                    'parent_id' => $parentCat->id,
                    'name' => 'Smartphones',
                    'status' => 1,
                    'order_no' => 1
                ]
            );
        }
    }
}
