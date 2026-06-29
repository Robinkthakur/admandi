<?php

namespace App\Livewire\PostAd;

use App\Models\Category\Category;
use App\Models\Listings\Listing;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Enums\Fit;

use App\Models\Location\Location;

class PostAdIndex extends Component
{
    use WithFileUploads;

    public $step = 1;

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public $category_id;
    public $subcategory_id;

    /*
    |--------------------------------------------------------------------------
    | Details
    |--------------------------------------------------------------------------
    */

    public $title;
    public $description;
    public $price;
    public $condition = 'used';

    public $state_id;
    public $city_id;

    public $custom_values = [];
    public $custom_fields_definition = [];

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    */

    public $images = [];

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    protected $messages = [

        'category_id.required' => 'Please select category.',
        'subcategory_id.required' => 'Please select sub category.',
        'title.required' => 'Please enter title.',
        'description.required' => 'Please enter description.',
        'price.required' => 'Please enter price.',
        'state_id.required' => 'Please enter state.',
        'city_id.required' => 'Please enter city.',
        'images.*.image' => 'Only image files allowed.',
        'images.*.max' => 'Maximum image size is 5MB.',

    ];

    /*
    |--------------------------------------------------------------------------
    | Category Selection
    |--------------------------------------------------------------------------
    */

    public function selectCategory($id)
    {
        $this->category_id = $id;
        $this->subcategory_id = null;
    }

    public function selectSubcategory($id)
    {
        $this->subcategory_id = $id;
    }

    /*
    |--------------------------------------------------------------------------
    | Next Step
    |--------------------------------------------------------------------------
    */

    public function nextStep()
    {
        if ($this->step == 1) {
            $this->validate([
                'category_id' => 'required',
            ]);

            $user = auth()->user();
            $limit = $user->isVerified()
                ? config('ads.verified_limit', 25)
                : config('ads.free_limit', 5);

            $count = Listing::where('user_id', $user->id)
                ->where('category_id', $this->category_id)
                ->count();

            if ($count >= $limit) {
                return redirect()->route('ad-limit-exceeded');
            }

            // Load custom fields definition
            $category = Category::find($this->category_id);
            $this->custom_fields_definition = $category?->custom_fields ?? [];
            $this->custom_values = [];
            foreach ($this->custom_fields_definition as $field) {
                $this->custom_values[$field['name']] = '';
            }
        }

        if ($this->step == 2) {
            $rules = [
                'title' => 'required|min:5|max:120',
                'description' => 'required|min:20|max:5000',
                'price' => 'required|numeric|min:1',
                'state_id' => 'required',
                'city_id' => 'required',
            ];

            $customAttributes = [];
            foreach ($this->custom_fields_definition as $field) {
                $fieldRule = [];
                if (!empty($field['required'])) {
                    $fieldRule[] = 'required';
                } else {
                    $fieldRule[] = 'nullable';
                }
                if ($field['type'] === 'number') {
                    $fieldRule[] = 'numeric';
                }
                $rules['custom_values.' . $field['name']] = implode('|', $fieldRule);
                $customAttributes['custom_values.' . $field['name']] = $field['label'];
            }

            $this->validate($rules, [], $customAttributes);
        }

        $this->step++;
    }

    /*
    |--------------------------------------------------------------------------
    | Previous Step
    |--------------------------------------------------------------------------
    */

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Updated Images
    |--------------------------------------------------------------------------
    */

    public function updatedImages()
    {
        $this->validate([
            'images' => 'max:10',
            'images.*' => 'image|max:5120',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Remove Image
    |--------------------------------------------------------------------------
    */

    public function removeImage($index)
    {
        unset($this->images[$index]);

        $this->images = array_values(
            $this->images
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Submit
    |--------------------------------------------------------------------------
    */

    public function submit()
    {
        $rules = [
            'category_id' => 'required',
            'title' => 'required|min:5|max:120',
            'description' => 'required|min:20|max:5000',
            'price' => 'required|numeric|min:1',
            'state_id' => 'required',
            'city_id' => 'required',
            'images' => 'required|max:10',
            'images.*' => 'image|max:5120',
        ];

        $customAttributes = [];
        foreach ($this->custom_fields_definition as $field) {
            $fieldRule = [];
            if (!empty($field['required'])) {
                $fieldRule[] = 'required';
            } else {
                $fieldRule[] = 'nullable';
            }
            if ($field['type'] === 'number') {
                $fieldRule[] = 'numeric';
            }
            $rules['custom_values.' . $field['name']] = implode('|', $fieldRule);
            $customAttributes['custom_values.' . $field['name']] = $field['label'];
        }

        $this->validate($rules, [], $customAttributes);

        $user = auth()->user();
        $limit = $user->isVerified()
            ? config('ads.verified_limit', 25)
            : config('ads.free_limit', 5);

        $count = Listing::where('user_id', $user->id)
            ->where('category_id', $this->category_id)
            ->count();

        if ($count >= $limit) {
            return redirect()->route('ad-limit-exceeded');
        }

        $city = Location::find($this->city_id);

        
        $adId = $this->generateAdId();
        $slug = Str::slug(
            $this->title . '-' .
            '-in-'.
            $city->name . '-' .
            $adId
        );

        $listing = Listing::create([
            'ad_id' => $adId,
            'user_id' => auth()->id(),
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'title' => $this->title,
            'slug' => $slug,
            'description' => $this->description,
            'price' => $this->price,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'status' => 'pending',
            'custom_fields' => $this->custom_values,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Images
        |--------------------------------------------------------------------------
        */

        foreach ($this->images as $image) {

            $listing
                ->addMedia($image->getRealPath())
                ->usingFileName(
                    uniqid() . '.webp'
                )
                ->toMediaCollection('listings');
        }

        /*
        |--------------------------------------------------------------------------
        | Reset Form
        |--------------------------------------------------------------------------
        */

        $this->reset([
            'category_id',
            'subcategory_id',
            'title',
            'description',
            'price',
            'state_id',
            'city_id',
            'images',
            'custom_values',
            'custom_fields_definition',
        ]);

        $this->step = 1;

        session()->flash(
            'success',
            'Ad posted successfully.'
        );

        return redirect()->to('post-ad/success/'.encrypt($listing->ad_id));
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $data['categories'] = Category::query()
            ->whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('order_no')
            ->get();

        $data['subcategories'] = Category::query()
            ->where('parent_id', $this->category_id)
            ->where('status', 1)
            ->orderBy('order_no')
            ->get();

        $data['states'] = Location::query()
            ->where('type','state')
            ->orderBy('name')
            ->get();

        $data['cities'] = Location::query()
            ->where('parent_id' , $this->state_id)
            ->where('type','city')
            ->orderBy('name')
            ->get();

        return view('livewire.post-ad.post-add-index',$data)
            ->layout('layouts.blank', [
                'title' => 'Post a Free Classified Ad | AdMandi',
                'metaDescription' => 'Post your free classified ad on AdMandi. Sell cars, mobiles, electronics, property, furniture and more in just a few clicks to local buyers.',
                'metaKeywords' => 'post free ad, sell online, publish classified, AdMandi, free listings, sell cars, sell mobiles',
                'headerTitle' => 'Post an Ad'
            ]);
    }


    private function generateAdId(){
        $adId = null;
        do {
        $adId = mt_rand(
            1000000000,
            9999999999
        );
        } while (
            Listing::where('ad_id', $adId)->exists()
        );
        return $adId;
    }
}