<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listings\VerificationPackage;

class VerificationPackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'identifier' => '1_month',
                'name' => 'Starter Pro',
                'duration_in_months' => 1,
                'price' => 299.00,
                'featured_limit' => 5,
                'color' => 'primary',
                'badge' => 'Standard',
                'popular' => false
            ],
            [
                'identifier' => '3_months',
                'name' => 'Professional Seller',
                'duration_in_months' => 3,
                'price' => 799.00,
                'featured_limit' => 15,
                'color' => 'success',
                'badge' => 'Popular',
                'popular' => true
            ],
            [
                'identifier' => '6_months',
                'name' => 'Elite Marketplace Partner',
                'duration_in_months' => 6,
                'price' => 1499.00,
                'featured_limit' => 40,
                'color' => 'dark',
                'badge' => 'Best Value',
                'popular' => false
            ]
        ];

        foreach ($packages as $pkg) {
            VerificationPackage::updateOrCreate(
                ['identifier' => $pkg['identifier']],
                $pkg
            );
        }
    }
}
