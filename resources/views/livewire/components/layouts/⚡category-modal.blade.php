<?php

use Livewire\Component;
use App\Models\Category\Category;
new class extends Component
{
    public $categories;

    public $search;

    public $parent_id;

    public function mount(){
        $this->getCategories();
    }

    public function updatedSearch(){
        $this->getCategories();
    }

    public function getCategories(){
        $this->categories = Category::where('status',1)
            ->where(function($qry){
                $qry->where('name',  'LIKE', '%'.$this->search.'%');
            })
            ->where(function($qry){
                if(!$this->search)
                   $qry->whereNull('parent_id');
                    
            })
            ->orderBy('order_no','asc')
            ->get();
    }
};
?>

<div
    class="modal fade"
    id="categoriesModal"
    tabindex="-1"
    wire:ignore.self
>


<style>

.category-card{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    padding:24px 16px;
    border:1px solid #eee;
    border-radius:20px;
    transition:.2s;
    height:100%;
}

.category-card:hover{
    border-color:#6047e6;
    transform:translateY(-3px);
    background:#faf8ff;
}

.category-icon{
    width:70px;
    height:70px;
    border-radius:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:14px;
}

.category-icon i{
    font-size:28px;
}

</style>
    <div class="modal-dialog modal-dialog-centered modal-lg" >

        <div class="modal-content border-0 rounded-4 overflow-hidden">

            <!-- Header -->
            <div class="modal-header border-0 pb-0">

                <div>

                    <h4 class="modal-title fw-bold">
                        Browse Categories
                    </h4>

                    <p class="text-muted mb-0 small">
                        Find products & services near you
                    </p>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <!-- Search -->
            <div class="px-4 pt-3">

                <div class="position-relative">

                    <i
                        class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"
                    ></i>

                    <input
                        wire:model.live="search"
                        type="text"
                        style="padding-left:40px !important"
                        class="form-control rounded-4"
                        
                        placeholder="Search categories..."
                    >

                </div>

            </div>

            <!-- Categories -->
            <div class="modal-body p-4" style="overflow-y: auto;height: 75vh">

                <div class="row g-3" wire:transition>

                    @forelse($categories as $cat)
                    <!-- Category -->
                        @if($search)
                            <div class="col-lg-4">
                                <a href="{{ url('/ads/'.get_location()->slug.'/'.$cat->slug) }}" class="category-card text-decoration-none">
                                    <h6 class="mb-0 text-dark ">
                                        {{ $cat->name }}
                                    </h6>
                                </a>
                            </div>
                        @else
                            <div class="col-4 col-md-3">

                            <a
                                href="{{ url('/ads/'.get_location()->slug.'/'.$cat->slug) }}"
                                class="category-card text-decoration-none"
                            >

                                <div class="category-icon">

                                <img src="{{ asset('storage/'.$cat->image) }}" alt="" class="w-100">

                                </div>

                                <h6 class="mb-0 text-dark ">
                                    {{ $cat->name }}
                                </h6>

                                <small class="text-muted">
                                    {{-- Phones & accessories --}}
                                </small>

                            </a>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-3">
                            <img src="{{ asset('icons/search-not-found.png') }}" alt="" style="width:120px">
                            <h6 class="mt-3">Opps! Results Not Found.</h6>
                            <small>Please check or modifiy your search</small>
                        </div>
                    @endforelse
                  
                </div>

            </div>

        </div>

    </div>

</div>