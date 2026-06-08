<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listings\Package;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => '7 Days Boost',
                'duration_in_days' => 7,
                'price' => 199.00,
                'description' => 'Short term ad boost'
            ],
            [
                'name' => '14 Days Boost',
                'duration_in_days' => 14,
                'price' => 349.00,
                'description' => 'Medium term ad boost'
            ],
            [
                'name' => '1 Month Boost',
                'duration_in_days' => 30,
                'price' => 599.00,
                'description' => '30 Days Pro visibility boost'
            ],
            [
                'name' => '2 Months Boost',
                'duration_in_days' => 60,
                'price' => 999.00,
                'description' => '60 Days Ultimate visibility boost'
            ]
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['duration_in_days' => $pkg['duration_in_days']],
                $pkg
            );
        }
    }
}
