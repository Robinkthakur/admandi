<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category\Category;

class CategoryTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $translations = [
            'mobiles' => [
                'in_hn' => 'मोबाइल',
                'in_pb' => 'ਮੋਬਾਈਲ',
            ],
            'vehicles' => [
                'in_hn' => 'वाहन',
                'in_pb' => 'ਵਾਹਨ',
            ],
            'bikes' => [
                'in_hn' => 'बाइक',
                'in_pb' => 'ਬਾਈਕ',
            ],
            'property' => [
                'in_hn' => 'संपत्ति',
                'in_pb' => 'ਪ੍ਰਾਪਰਟੀ',
            ],
            'electronics' => [
                'in_hn' => 'इलेक्ट्रॉनिक्स',
                'in_pb' => 'ਇਲੈਕਟ੍ਰੋਨਿਕਸ',
            ],
            'home-furniture' => [
                'in_hn' => 'घर और फर्नीचर',
                'in_pb' => 'ਘਰ ਅਤੇ ਫਰਨੀਚਰ',
            ],
            'fashion' => [
                'in_hn' => 'फैशन',
                'in_pb' => 'ਫੈਸ਼ਨ',
            ],
            'jobs' => [
                'in_hn' => 'नौकरियां',
                'in_pb' => 'ਨੌਕਰੀਆਂ',
            ],
            'services' => [
                'in_hn' => 'सेवाएं',
                'in_pb' => 'ਸੇਵਾਵਾਂ',
            ],
            'computers' => [
                'in_hn' => 'कंप्यूटर और एक्सेसरीज़',
                'in_pb' => 'ਕੰਪਿਊਟਰ ਅਤੇ ਐਕਸੈਸਰੀਜ਼',
            ],
        ];

        foreach ($translations as $slug => $langs) {
            Category::where('slug', $slug)->update([
                'in_hn' => $langs['in_hn'],
                'in_pb' => $langs['in_pb'],
            ]);
        }
    }
}

