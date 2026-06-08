<?php

use Livewire\Component;
use App\Models\Category\Category;
use App\Models\NewsletterSubscriber;

new class extends Component
{
    public $email = '';
    public $category_id = '';
    public $categories = [];
    public $subscribed = false;

    public function mount()
    {
        // Load parent categories (i.e. where parent_id is null) for selection
        $this->categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('order_no', 'asc')
            ->get();
    }

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'category_id' => 'nullable|exists:categories,id',
        ], [
            'email.required' => __('Please enter your email address.'),
            'email.email' => __('Please enter a valid email address.'),
            'email.unique' => __('You are already subscribed to our newsletter.'),
            'category_id.exists' => __('Please select a valid category.'),
        ]);

        NewsletterSubscriber::create([
            'email' => $this->email,
            'category_id' => $this->category_id ?: null,
        ]);

        $this->subscribed = true;
        $this->email = '';
        $this->category_id = '';
    }
};
?>

<style>
    .newsletter-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .newsletter-group .form-control,
    .newsletter-group .form-select,
    .newsletter-group .theme-btn {
        border-radius: 10px !important;
        height: 44px;
        font-size: 14px;
    }
    .newsletter-group .form-control,
    .newsletter-group .form-select {
        background-color: #fff !important;
        color: #212529 !important;
        border: 1px solid #ced4da !important;
    }
    .newsletter-group .form-control::placeholder {
        color: #6c757d !important;
    }
    .newsletter-group .theme-btn {
        border: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        background: var(--primary) !important;
        color: #fff !important;
    }
    .newsletter-group .theme-btn:hover {
        opacity: 0.9;
    }
    
    @media (min-width: 768px) {
        .newsletter-group {
            flex-direction: row;
            gap: 0;
            background: #fff;
            border-radius: 12px;
            padding: 4px;
            align-items: stretch;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .newsletter-group .form-control {
            border: none !important;
            border-radius: 0 !important;
            background: transparent !important;
            flex: 3;
            height: auto;
        }
        .newsletter-group .form-select {
            border: none !important;
            border-left: 1px solid #dee2e6 !important;
            border-radius: 0 !important;
            background-color: transparent !important;
            flex: 2;
            height: auto;
        }
        .newsletter-group .theme-btn {
            border-radius: 8px !important;
            flex: 1.5;
            height: auto;
            white-space: nowrap;
        }
    }
</style>

<section class="b text-white py-5" style="background: #000;">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5">
                <h2 class="fw-bold mb-2">
                    {{ __('Subscribe to Our Newsletter') }}
                </h2>
                <p class="mb-0 opacity-75">
                    {{ __('Get latest deals, featured ads and marketplace updates directly in your inbox.') }}
                </p>
            </div>

            <div class="col-lg-7">
                @if($subscribed)
                    <div class="alert alert-success border-0 rounded-4 p-3 mb-0 d-flex align-items-center gap-3">
                        <i class="bi bi-patch-check-fill fs-3 text-success"></i>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">{{ __('Subscribed successfully!') }}</h6>
                            <span class="small text-muted">{{ __('Thank you for subscribing to our newsletter. We will send you updates based on your preferences.') }}</span>
                        </div>
                    </div>
                @else
                    <form wire:submit="subscribe" class="w-100">
                        <div class="newsletter-group">
                            <input 
                                wire:model="email"
                                type="email"
                                class="form-control"
                                placeholder="{{ __('Enter your email') }}"
                                required
                            >

                            <select wire:model="category_id" class="form-select">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ __($cat->name) }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="theme-btn">
                                <span wire:loading.remove wire:target="subscribe">{{ __('Subscribe') }}</span>
                                <span wire:loading wire:target="subscribe" class="spinner-border spinner-border-sm" role="status"></span>
                            </button>
                        </div>

                        @error('email')
                            <div class="text-danger small mt-2 px-2">{{ $message }}</div>
                        @enderror
                        @error('category_id')
                            <div class="text-danger small mt-2 px-2">{{ $message }}</div>
                        @enderror
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>
