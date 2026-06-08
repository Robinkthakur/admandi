<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category\Category;
use App\Models\Location\Location;
use App\Models\Listings\Listing;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or retrieve test users
        $user1 = User::updateOrCreate(
            ['email' => 'rahulsounti@gmail.com'],
            [
                'name' => 'Robin Rana',
                'password' => Hash::make('password'),
                'phone' => '9876543210',
                'is_verified' => true,
                'verified_until' => now()->addYear(),
                'featured_limit' => 10,
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'rahul@example.com'],
            [
                'name' => 'Rahul',
                'password' => Hash::make('password'),
                'phone' => '9876543211',
                'is_verified' => false,
                'featured_limit' => 3,
            ]
        );

        $sellers = [
            [
                'name' => 'Amit Sharma',
                'email' => 'amit@example.com',
                'phone' => '9876543212',
                'is_verified' => true,
                'verified_until' => now()->addYear(),
                'featured_limit' => 10,
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'priya@example.com',
                'phone' => '9876543213',
                'is_verified' => false,
                'featured_limit' => 3,
            ],
            [
                'name' => 'Jaspreet Singh',
                'email' => 'jaspreet@example.com',
                'phone' => '9876543214',
                'is_verified' => true,
                'verified_until' => now()->addYear(),
                'featured_limit' => 10,
            ],
            [
                'name' => 'Neha Gupta',
                'email' => 'neha@example.com',
                'phone' => '9876543215',
                'is_verified' => false,
                'featured_limit' => 3,
            ]
        ];

        $userIds = [$user1->id, $user2->id];
        foreach ($sellers as $sellerData) {
            $user = User::updateOrCreate(
                ['email' => $sellerData['email']],
                [
                    'name' => $sellerData['name'],
                    'password' => Hash::make('password'),
                    'phone' => $sellerData['phone'],
                    'is_verified' => $sellerData['is_verified'],
                    'verified_until' => $sellerData['verified_until'] ?? null,
                    'featured_limit' => $sellerData['featured_limit'],
                ]
            );
            $userIds[] = $user->id;
        }

        // 2. Fetch locations
        $ludhiana = Location::where('slug', 'ludhiana')->first();
        $amritsar = Location::where('slug', 'amritsar')->first();

        $locations = [];
        if ($ludhiana) {
            $locations[] = [
                'city_id' => $ludhiana->id,
                'state_id' => $ludhiana->parent_id ?? 29,
                'name' => 'Ludhiana'
            ];
        }
        if ($amritsar) {
            $locations[] = [
                'city_id' => $amritsar->id,
                'state_id' => $amritsar->parent_id ?? 29,
                'name' => 'Amritsar'
            ];
        }
        if (empty($locations)) {
            $locations[] = [
                'city_id' => 1,
                'state_id' => 29,
                'name' => 'Ludhiana'
            ];
        }

        // 3. Define raw test listings data
        $testListings = [
            [
                'title' => 'iPhone 15 Pro Max - 256GB - Titanium Blue',
                'category_slug' => 'mobiles',
                'subcategory_slug' => 'smartphones',
                'price' => 115000,
                'old_price' => 125000,
                'description' => 'Selling my brand new iPhone 15 Pro Max, 256GB storage, Titanium Blue color. Excellent condition, 100% battery health, comes with box and original Apple charging cable. Selling because I am upgrading. Serious buyers only.',
                'is_featured' => true,
            ],
            [
                'title' => 'Maruti Suzuki Swift VXI (2021) - Manual',
                'category_slug' => 'vehicles',
                'subcategory_slug' => null,
                'price' => 540000,
                'old_price' => 580000,
                'description' => 'First owner Maruti Suzuki Swift VXI, 2021 model, manual transmission, petrol. Driven only 24,000 km with full service history at authorized service center. Neat and clean interior, minor scratches on bumper, new tires and insurance valid for 9 months.',
                'is_featured' => false,
            ],
            [
                'title' => 'Royal Enfield Classic 350 - Gunmetal Grey',
                'category_slug' => 'bikes',
                'subcategory_slug' => null,
                'price' => 185000,
                'old_price' => 200000,
                'description' => 'Royal Enfield Classic 350 Gunmetal Grey with dual-channel ABS. 2022 model, well-maintained, smooth engine, alloy wheels, custom exhausts (original also available). Driven 12,000 km. Regularly serviced, insurance active.',
                'is_featured' => true,
            ],
            [
                'title' => '3 BHK Luxury Apartment in Ludhiana Prime Location',
                'category_slug' => 'property',
                'subcategory_slug' => null,
                'price' => 7500000,
                'old_price' => null,
                'description' => 'Beautiful 3 BHK luxury apartment for sale in a gated society with 24/7 security. Modern modular kitchen, spacious bedrooms with attached bathrooms, large balconies, dedicated parking slot, and power backup. Located close to schools and shopping malls.',
                'is_featured' => false,
            ],
            [
                'title' => 'Sony Bravia 55-inch 4K Ultra HD Smart LED TV',
                'category_slug' => 'electronics',
                'subcategory_slug' => null,
                'price' => 42000,
                'old_price' => 55000,
                'description' => 'Sony Bravia 55-inch 4K Ultra HD Smart LED TV for sale. Amazing display quality, Dolby Audio, built-in Wi-Fi, supports Netflix, Amazon Prime, YouTube, etc. 2 years old, perfect working condition, wall mount and remote included.',
                'is_featured' => false,
            ],
            [
                'title' => 'Solid Teak Wood Dining Table with 6 Chairs',
                'category_slug' => 'home-furniture',
                'subcategory_slug' => null,
                'price' => 22000,
                'old_price' => 30000,
                'description' => 'High-quality solid teak wood dining table with 6 matching cushioned chairs. Classic design, very sturdy, well-polished, no scratches or damages. Selling because we are moving to a new city.',
                'is_featured' => false,
            ],
            [
                'title' => 'Men Genuine Leather Jacket - Black (Size L)',
                'category_slug' => 'fashion',
                'subcategory_slug' => null,
                'price' => 3800,
                'old_price' => 6000,
                'description' => 'Premium genuine leather jacket for men. Black color, size L. Worn only a couple of times, looks brand new. Perfect for winters and motorcycle riders. Comfortable lining inside with multiple pockets.',
                'is_featured' => false,
            ],
            [
                'title' => 'Full Stack PHP/Laravel Developer Job Opportunity',
                'category_slug' => 'jobs',
                'subcategory_slug' => null,
                'price' => 55000,
                'old_price' => null,
                'description' => 'We are hiring a Full Stack PHP/Laravel Developer for our Ludhiana office. Candidate should have 2+ years of experience with Laravel, Livewire, MySQL, and JavaScript. Competitive salary, friendly environment, and growth opportunities. Please apply with your resume.',
                'is_featured' => false,
            ],
            [
                'title' => 'Professional Home Cleaning Services',
                'category_slug' => 'services',
                'subcategory_slug' => null,
                'price' => 1800,
                'old_price' => 2500,
                'description' => 'Get professional deep home cleaning services at affordable rates. We clean kitchens, bathrooms, living rooms, sofas, carpets, and windows using eco-friendly materials and advanced equipment. Experienced staff, 100% satisfaction guaranteed.',
                'is_featured' => false,
            ],
            [
                'title' => 'Dell XPS 13 Laptop - Core i7, 16GB RAM, 512GB SSD',
                'category_slug' => 'computers',
                'subcategory_slug' => null,
                'price' => 88000,
                'old_price' => 110000,
                'description' => 'Dell XPS 13 9310 premium laptop for sale. Intel Core i7 11th Gen, 16GB RAM, 512GB NVMe SSD, 13.4-inch Full HD+ InfinityEdge display. Extremely lightweight, great battery backup, backlit keyboard. Comes with original charger and box.',
                'is_featured' => true,
            ],
            [
                'title' => 'Samsung Galaxy S24 Ultra - 512GB - Gray',
                'category_slug' => 'mobiles',
                'subcategory_slug' => 'smartphones',
                'price' => 110000,
                'old_price' => 130000,
                'description' => 'Samsung Galaxy S24 Ultra, Titanium Gray, 512GB storage, 12GB RAM. Bill, box, S-Pen and charging cable available. 3 months old, scratchless condition, protected with screen guard since day one. Warranty active.',
                'is_featured' => false,
            ],
            [
                'title' => 'Honda Activa 6G (2022) - Excellent Condition',
                'category_slug' => 'bikes',
                'subcategory_slug' => null,
                'price' => 62000,
                'old_price' => 72000,
                'description' => 'Honda Activa 6G, Matte Blue color, 2022 model. Driven only 8,500 km. Regularly serviced at authorized Honda dealer, single hand driven, great mileage. Engine is in pristine condition. Selling because it is rarely used.',
                'is_featured' => false,
            ],
            [
                'title' => 'Spacious Office Space for Rent in Amritsar Market',
                'category_slug' => 'property',
                'subcategory_slug' => null,
                'price' => 35000,
                'old_price' => null,
                'description' => 'Commercial office space available for rent in a busy commercial area of Amritsar. 1200 sq. ft., semi-furnished, includes cabins, work stations, pantry, and private washroom. Ideal for startups, IT companies, or clinics.',
                'is_featured' => true,
            ],
            [
                'title' => 'HP LaserJet Pro Multi-function Wireless Printer',
                'category_slug' => 'computers',
                'subcategory_slug' => null,
                'price' => 15500,
                'old_price' => 19500,
                'description' => 'HP LaserJet Pro M126nw Multi-function monochrome wireless laser printer. Functions: Print, Copy, Scan. High speed printing, Wi-Fi enabled, easy mobile printing via HP Smart App. Used in home office, perfect working condition.',
                'is_featured' => false,
            ],
            [
                'title' => 'Acoustic Guitar Lessons for Beginners & Intermediate',
                'category_slug' => 'services',
                'subcategory_slug' => null,
                'price' => 1500,
                'old_price' => 2000,
                'description' => 'Learn to play acoustic guitar from an experienced guitarist. Custom lesson plans for beginners and intermediates. Classes available both online and offline (Ludhiana). Flexible timings. Call to book a trial class.',
                'is_featured' => false,
            ],
            [
                'title' => 'OnePlus 12R - 16GB RAM / 256GB - Cool Blue',
                'category_slug' => 'mobiles',
                'subcategory_slug' => 'smartphones',
                'price' => 38000,
                'old_price' => 42000,
                'description' => 'OnePlus 12R 5G, 16GB RAM, 256GB storage, Cool Blue color. 100W SUPERVOOC charger, box, and cover included. Excellent gaming performance, long-lasting battery, flawless display. 4 months old, under warranty.',
                'is_featured' => true,
            ],
            [
                'title' => 'Hyundai i20 Asta (o) 1.2 Petrol (2019)',
                'category_slug' => 'vehicles',
                'subcategory_slug' => null,
                'price' => 590000,
                'old_price' => 640000,
                'description' => 'Hyundai i20 Asta (optional), top model with sunroof, 1.2 Petrol engine. 2019 registration, second owner, driven 42,000 km. Keyless entry, push-button start, alloy wheels, touchscreen infotainment system with Apple CarPlay. Full comprehensive insurance.',
                'is_featured' => true,
            ]
        ];

        // 4. Create Listings
        $imagePath = public_path('images/app-home.webp');
        $hasImage = file_exists($imagePath);

        foreach ($testListings as $item) {
            // Find category
            $category = Category::where('slug', $item['category_slug'])->first();
            if (!$category) {
                continue;
            }

            // Find subcategory if specified
            $subcategory = null;
            if ($item['subcategory_slug']) {
                $subcategory = Category::where('slug', $item['subcategory_slug'])->first();
            }

            // Select random user and location
            $userId = $userIds[array_rand($userIds)];
            $loc = $locations[array_rand($locations)];

            // Generate unique ad ID
            $adId = null;
            do {
                $adId = mt_rand(1000000000, 9999999999);
            } while (Listing::where('ad_id', $adId)->exists());

            // Generate slug
            $slug = Str::slug($item['title'] . '-in-' . $loc['name'] . '-' . $adId);

            $listing = Listing::create([
                'ad_id' => $adId,
                'user_id' => $userId,
                'category_id' => $category->id,
                'subcategory_id' => $subcategory ? $subcategory->id : null,
                'city_id' => $loc['city_id'],
                'state_id' => $loc['state_id'],
                'area_id' => null,
                'title' => $item['title'],
                'slug' => $slug,
                'description' => $item['description'],
                'price' => $item['price'],
                'old_price' => $item['old_price'],
                'status' => 'active', // Seed directly as active so they show up
                'is_featured' => $item['is_featured'],
                'featured_until' => $item['is_featured'] ? now()->addDays(30) : null,
                'views' => rand(10, 500),
            ]);

            // Copy and attach media using Spatie Media Library
            if ($hasImage) {
                try {
                    $listing->addMedia($imagePath)
                        ->preservingOriginal()
                        ->toMediaCollection('listings');
                } catch (\Exception $e) {
                    $this->command->warn("Could not attach image to listing: " . $e->getMessage());
                }
            }
        }
        
        $this->command->info('Successfully seeded ' . count($testListings) . ' listings with realistic data!');
    }
}
