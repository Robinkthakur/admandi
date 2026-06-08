<?php

use Livewire\Component;
use App\Models\Category\Category;
new class extends Component
{
    public $categories;

    public function mount(){
        $this->getCategories();
    }

    public function getCategories(){
        $this->categories = Category::where('status',1)
            ->whereNull('parent_id')
            ->orderBy('order_no','asc')
            ->get();
    }
};
?>

<section class="categories" wire:ignore>
    <div class="container">

        <div class="mobile-category row  gx-0 d-lg-none">
            @foreach($categories as $key => $category)
            @if($key == 4) @break @endif
            <div class="col-2 text-center">
                <div class="mobile-category-item">
                    <a href="{{ url('/ads/'.get_location()->slug.'/'.$category->slug) }}" class="text-center">
                        <div class="mobile-category-box">
                            <div class="image-box">
                                <img src="{{ asset('storage/'.$category->image) }}">
                            </div>
                            <span class="category-name">{{ $category->name }}</span>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach

             <div class="col-2">
                <div class="mobile-category-item">
                    <a href="#"  data-bs-toggle="modal" data-bs-target="#categoriesModal">
                        <div class="mobile-category-box">
                            <div class="image-box">
                                <i class="bi bi-ui-checks-grid"></i>
                            </div>
                            <span class="category-name">More</span>
                        </div>
                    </a>
                </div>
            </div>

        </div>
            
        <div class="category-slider d-none d-lg-block">
            @foreach($categories as $category)
            <div class="category-slider-item">
                <a href="{{ url('/ads/'.get_location()->slug.'/'.$category->slug) }}">
                    <div class="category-box">
                        <div class="image-box">
                            <img src="{{ asset('storage/'.$category->image) }}">
                        </div>
                        <span>{{ $category->name }}</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>