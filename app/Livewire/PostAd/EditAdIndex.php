<?php

namespace App\Livewire\PostAd;

use App\Models\Category\Category;
use App\Models\Listings\Listing;
use App\Models\Location\Location;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditAdIndex extends Component
{
    use WithFileUploads;

    public $listingId;
    public $listing;

    public $category_id;
    public $subcategory_id;
    public $title;
    public $description;
    public $price;
    public $state_id;
    public $city_id;
    public $custom_values = [];
    public $custom_fields_definition = [];

    public $existingImages = [];
    public $images = []; // new uploads

    protected $messages = [
        'category_id.required' => 'Please select category.',
        'subcategory_id.required' => 'Please select sub category.',
        'title.required' => 'Please enter title.',
        'description.required' => 'Please enter description.',
        'price.required' => 'Please enter price.',
        'state_id.required' => 'Please select state.',
        'city_id.required' => 'Please select city.',
        'images.*.image' => 'Only image files allowed.',
        'images.*.max' => 'Maximum image size is 5MB.',
    ];

    public function mount($id)
    {
        $this->listing = Listing::where('user_id', auth()->id())->findOrFail($id);
        $this->listingId = $this->listing->id;

        $this->category_id = $this->listing->category_id;
        $this->subcategory_id = $this->listing->subcategory_id;
        $this->title = $this->listing->title;
        $this->description = $this->listing->description;
        $this->price = $this->listing->price;
        $this->state_id = $this->listing->state_id;
        $this->city_id = $this->listing->city_id;

        $category = Category::find($this->category_id);
        $this->custom_fields_definition = $category?->custom_fields ?? [];
        $this->custom_values = $this->listing->custom_fields ?? [];
        
        foreach ($this->custom_fields_definition as $field) {
            if (!array_key_exists($field['name'], $this->custom_values)) {
                $this->custom_values[$field['name']] = '';
            }
        }

        $this->loadExistingImages();
    }

    public function loadExistingImages()
    {
        $this->existingImages = $this->listing->getMedia('listings')->map(function($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl('thumb'),
            ];
        })->toArray();
    }

    public function deleteExistingImage($mediaId)
    {
        $media = $this->listing->media()->findOrFail($mediaId);
        $media->delete();
        $this->loadExistingImages();
        session()->flash('success', 'Image removed.');
    }

    public function removeNewImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function updatedImages()
    {
        $this->validate([
            'images' => 'max:10',
            'images.*' => 'image|max:5120',
        ]);
    }

    public function selectCategory($id)
    {
        $this->category_id = $id;
        $this->subcategory_id = null;
        
        $category = Category::find($this->category_id);
        $this->custom_fields_definition = $category?->custom_fields ?? [];
        $this->custom_values = [];
        foreach ($this->custom_fields_definition as $field) {
            $this->custom_values[$field['name']] = '';
        }
    }

    public function selectSubcategory($id)
    {
        $this->subcategory_id = $id;
    }

    public function submit()
    {
        $rules = [
            'category_id' => 'required',
            'title' => 'required|min:5|max:120',
            'description' => 'required|min:20|max:5000',
            'price' => 'required|numeric|min:1',
            'state_id' => 'required',
            'city_id' => 'required',
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

        if (count($this->existingImages) + count($this->images) === 0) {
            $this->addError('images', 'Please upload at least one image.');
            return;
        }

        if (count($this->existingImages) + count($this->images) > 10) {
            $this->addError('images', 'You can upload up to 10 images in total.');
            return;
        }

        $this->listing->update([
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'state_id' => $this->state_id,
            'city_id' => $this->city_id,
            'custom_fields' => $this->custom_values,
        ]);

        // Upload new images if any
        foreach ($this->images as $image) {
            $this->listing
                ->addMedia($image->getRealPath())
                ->usingFileName(uniqid() . '.webp')
                ->toMediaCollection('listings');
        }

        session()->flash('success', 'Ad updated successfully.');
        return redirect()->to('/profile/my-ads');
    }

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
            ->where('type', 'state')
            ->orderBy('name')
            ->get();

        $data['cities'] = Location::query()
            ->where('parent_id', $this->state_id)
            ->where('type', 'city')
            ->orderBy('name')
            ->get();

        return view('livewire.post-ad.edit-ad-index', $data)
            ->layout('layouts.blank', [
                'title' => 'Edit Your Classified Ad | AdMandi',
                'metaDescription' => 'Edit your classified ad details on AdMandi. Update title, description, pricing, photos, or location for better buyer views.',
                'metaKeywords' => 'edit ad, update classified, manage listings, AdMandi, free classifieds',
                'headerTitle' => 'Edit Ad'
            ]);
    }
}
