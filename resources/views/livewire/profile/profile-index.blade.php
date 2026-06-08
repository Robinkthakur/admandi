<div class="container py-4">

    @if($isCurrentUser && $user->needsIdentityVerification())
        <div class="alert alert-warning border-0 rounded-4 shadow-sm p-4 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                    <i class="bi bi-shield-exclamation fs-3"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1 text-dark">{{ __('Complete Profile Verification') }}</h6>
                    <small class="text-muted d-block">{{ __('Your payment was successful. Please upload a selfie and ID proof to get your trust badge.') }}</small>
                </div>
            </div>
            <a href="{{ route('verification-status') }}" class="btn btn-warning rounded-pill py-2 px-4 fw-bold text-dark shadow-sm">
                <i class="bi bi-person-check-fill me-1"></i> {{ __('Complete Verification') }}
            </a>
        </div>
    @endif

    <div class="row">

        <!-- Sidebar/Profile Card -->
        <div class="col-lg-4 mb-4">

            <div class="custom-card p-0 rounded-4 overflow-hidden">

                <!-- Cover -->
                <div class="bg-primary" style="height:120px;"></div>

                <div class="card-body text-center position-relative">

                    <!-- Avatar -->
                    <div class="position-relative" style="margin-top:-70px;">
                        <img src="{{ $user->avatar ? $user->avatar : url('assets/icons/avatar.png') }}"
                             class="rounded-circle border border-4 border-white shadow-sm"
                             width="120"
                             height="120"
                             style="object-fit:cover; width: 120px; height: 120px;">
                    </div>

                    <!-- Name -->
                    <h4 class="mt-3 mb-1 fw-bold">
                        {{ $user->name }}
                        @if($user->isVerified())
                            <a href="{{ route('verification-status', $user->id) }}" class="text-decoration-none" title="{{ __('Verified Seller') }}">
                                <i class="bi bi-patch-check-fill text-primary ms-1" style="font-size: 1.25rem;"></i>
                            </a>
                        @endif
                    </h4>

                    <!-- Joined -->
                    <p class="text-muted mb-3">
                        {{ __('Member since') }}  {{ $user->created_at->format('F Y') }}
                    </p>

                    <!-- Verification -->
                    @if($user->isVerified())
                        <div class="mb-2">
                            <a href="{{ route('verification-status', $user->id) }}" class="text-decoration-none">
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-patch-check-fill me-1"></i>
                                    {{ __('Verified Seller') }}
                                </span>
                            </a>
                        </div>
                        @if($isCurrentUser)
                            <div class="mb-2">
                                <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-1.5 rounded-pill small">
                                    <i class="bi bi-lightning-charge-fill text-warning me-1"></i>
                                    {{ __('Boost Credits:') }} <strong>{{ $user->featured_limit }}</strong>
                                </span>
                            </div>
                        @endif
                    @else
                        <div class="mb-2">
                            <a href="{{ route('verification-status', $user->id) }}" class="text-decoration-none">
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                                    <i class="bi bi-shield-x me-1"></i>
                                    {{ __('Standard Seller') }}
                                </span>
                            </a>
                        </div>
                    @endif

                    <!-- Account Verifications -->
                    @if($user->email_verified_at || $user->phone_verified_at || $user->isVerified())
                    <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
                        @if($user->email_verified_at)
                            <span class="badge bg-info-subtle text-info px-2 py-1 rounded-pill" style="font-size: 0.72rem;" title="{{ __('Email Address Verified') }}">
                                <i class="bi bi-envelope-check-fill me-1"></i>
                                {{ __('Email Verified') }}
                            </span>
                        @endif

                        @if($user->phone_verified_at)
                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill" style="font-size: 0.72rem;" title="{{ __('Phone Number Verified') }}">
                                <i class="bi bi-telephone-fill me-1"></i>
                                {{ __('Phone Verified') }}
                            </span>
                        @endif

                        @if($user->isVerified())
                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill" style="font-size: 0.72rem;" title="{{ __('Identity Verified') }}">
                                <i class="bi bi-shield-check me-1"></i>
                                {{ __('Identity Verified') }}
                            </span>
                        @endif
                    </div>
                    @endif

                    <!-- Stats -->
                    <div class="row text-center mb-4">

                        <div class="col">
                            <h5 class="fw-bold mb-0">{{ $user->listings()->count() }}</h5>
                            <small class="text-muted">{{ __('Ads') }}</small>
                        </div>

                        <div class="col border-start border-end">
                            <h5 class="fw-bold mb-0">{{ number_format($user->listings()->sum('views')) }}</h5>
                            <small class="text-muted">{{ __('Views') }}</small>
                        </div>

                        <div class="col">
                            <h5 class="fw-bold mb-0">{{ $user->isVerified() ? __('Pro') : __('Basic') }}</h5>
                            <small class="text-muted">{{ __('Status') }}</small>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-center p-3 gap-2" >

                        @if($isCurrentUser)
                            <a href="javascript:void(0)" class="btn btn-primary rounded-pill px-4" wire:click="initEditForm">
                                <i class="bi bi-pencil-square me-2"></i>
                                {{ __('Edit Profile') }}
                            </a>
                        @else
                            <a href="{{ url('chat') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-chat-right-text me-2"></i>
                                {{ __('Chat with Seller') }}
                            </a>
                        @endif

                        <button 
                            type="button" 
                            class="btn btn-light border rounded-pill px-4"
                            x-data="{ copied: false }"
                            @click="
                                navigator.clipboard.writeText('{{ url('profile/' . $user->id) }}');
                                copied = true;
                                setTimeout(() => copied = false, 2000);
                            "
                        >
                            <i class="bi" :class="copied ? 'bi-check-lg text-success me-2' : 'bi-share me-2'"></i>
                            <span x-text="copied ? '{{ __('Link Copied!') }}' : '{{ __('Share Profile') }}'"></span>
                        </button>

                    </div>

                </div>
            </div>

        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            
            @if($isCurrentUser)   
            <!-- Profile Info (Only if logged in or current user) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">
                            {{ __('Profile Information') }}
                        </h5>

                        @if($isCurrentUser)
                        <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary rounded-pill px-3" wire:click="initEditForm">
                            {{ __('Edit') }}
                        </a>
                        @endif
                    </div>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <small class="text-muted d-block">{{ __('Full Name') }}</small>
                            <div class="fw-semibold">{{ $user->name }}</div>
                        </div>

                        @if($isCurrentUser || auth()->check())
                            <div class="col-md-6">
                                <small class="text-muted d-block">{{ __('Email') }}</small>
                                <div class="fw-semibold d-flex align-items-center gap-1">
                                    @if($isCurrentUser)
                                        {{ $user->email }}
                                    @else
                                        {{ substr($user->email, 0, 3) . '***' . strstr($user->email, '@') }} ({{ __('Hidden') }})
                                    @endif
                                    @if($user->email_verified_at)
                                        <i class="bi bi-check-circle-fill text-success" style="font-size: 0.85rem;" title="{{ __('Verified') }}"></i>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">{{ __('Phone') }}</small>
                                <div class="fw-semibold d-flex align-items-center gap-1">
                                    @if($isCurrentUser)
                                        +91 {{ $user->phone }}
                                    @else
                                        +91 {{ substr($user->phone, 0, 2) . '******' . substr($user->phone, -2) }} ({{ __('Hidden') }})
                                    @endif
                                    @if($user->phone_verified_at)
                                        <i class="bi bi-check-circle-fill text-success" style="font-size: 0.85rem;" title="{{ __('Verified') }}"></i>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <small class="text-muted d-block">{{ __('Location') }}</small>
                            <div class="fw-semibold">{{ $user->location->display_name ?? __('Not specified') }}</div>
                        </div>

                    </div>

                </div>

            </div>
            @endif

            <!-- Ads List -->
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="fw-bold mb-0">
                            {{ $isCurrentUser ? __('Active Ads') : __('Ads by') . ' ' . $user->name }}
                        </h5>

                        @if($isCurrentUser)
                        <a href="{{ url('post-ad') }}" class="btn btn-primary rounded-pill">
                            <i class="bi bi-plus-circle me-2"></i>
                            {{ __('Post New Ad') }}
                        </a>
                        @endif

                    </div>

                    @forelse($listings as $listing)
                    <!-- Ad Item -->
                    <div class="border rounded-4 p-3 mb-3">

                        <div class="row align-items-center">

                            <div class="col-md-3 mb-3 mb-md-0">
                                <a href="{{ url($listing->slug) }}">
                                   <div class="border rounded-3 p-2 d-flex align-items-center justify-content-center bg-light" style="height:120px; width:100%; max-width: 120px; overflow: hidden;">
                                     @if($listing->getFirstMediaUrl('*', 'thumb'))
                                         <img src="{{ $listing->getFirstMediaUrl('*', 'thumb') }}"
                                              style="max-width:100%; max-height:100%; object-fit:contain;">
                                     @else
                                         <img src="{{ asset('images/no-product.webp') }}"
                                              style="max-width:100%; max-height:100%; object-fit:contain;">
                                     @endif
                                   </div>
                                </a>
                            </div>

                            <div class="col-md-6">

                                <span class="badge bg-light text-dark mb-2">
                                    {{ $listing->category?->name }}
                                </span>
                                <a href="{{ url($listing->slug) }}">
                                    <h5 class="fw-bold mb-2">
                                        {{ $listing->title }}
                                    </h5>
                                </a>

                                <p class="text-muted small mb-2">
                                    <span>{{ __('Posted') }} {{ $listing->created_at->diffForHumans() }}</span>
                                    <span>•</span> 
                                    <span>{{ $listing->location?->display_name }}</span>
                                </p>

                                <div class="fw-bold text-primary fs-5">
                                    {{ price($listing->price) }}
                                </div>

                            </div>

                            @if($isCurrentUser)
                            <div class="col-md-3 text-md-end mt-3 mt-md-0">

                                <div class="d-flex gap-2 justify-content-md-end">

                                    <a href="{{ route('edit-ad', $listing->id) }}" class="btn btn-light border btn-sm rounded-pill px-3">
                                        {{ __('Edit') }}
                                    </a>

                                    <button 
                                        type="button"
                                        class="btn btn-danger btn-sm rounded-pill px-3"
                                        wire:click="deleteAd({{ $listing->id }})"
                                        wire:confirm="{{ __('Are you sure you want to remove this ad?') }}"
                                    >
                                        {{ __('Delete') }}
                                    </button>

                                </div>

                            </div>
                            @endif

                        </div>

                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-folder-x mb-2" style="font-size: 2.5rem; display: block;"></i>
                        <span>{{ __('No listings found.') }}</span>
                    </div>
                    @endforelse

                    <div class="mt-4">
                        {{ $listings->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="fw-bold mb-0">{{ __('Edit Profile') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="saveProfile">
                    <div class="modal-body py-4">

                        <!-- Avatar Upload and Preview -->
                        <div class="mb-4 text-center position-relative">
                            <div class="d-inline-block position-relative">
                                @if($avatar_file)
                                    <img src="{{ $avatar_file->temporaryUrl() }}" class="rounded-circle border border-4 border-white shadow" width="100" height="100" style="object-fit: cover; width: 100px; height: 100px;">
                                @else
                                    <img src="{{ $user->avatar ? $user->avatar : url('assets/icons/avatar.png') }}" class="rounded-circle border border-4 border-white shadow" width="100" height="100" style="object-fit: cover; width: 100px; height: 100px;">
                                @endif
                                <label for="avatar_file_input" class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 p-0 d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; cursor: pointer;">
                                    <i class="bi bi-camera-fill text-white" style="font-size: 0.9rem;"></i>
                                </label>
                                <input type="file" id="avatar_file_input" class="visually-hidden" wire:model="avatar_file" accept="image/*">
                            </div>
                            <div class="mt-2 text-muted small">{{ __('Click camera icon to change profile picture') }}</div>
                            @error('avatar_file') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>
                        
                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ __('Full Name') }}</label>
                            <input type="text" class="form-control rounded-3" wire:model="name">
                            @error('name') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ __('Email Address') }}</label>
                            <input type="email" class="form-control rounded-3" wire:model="email">
                            @error('email') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label class="form-label small text-muted">{{ __('Phone Number') }}</label>
                            <input type="text" class="form-control rounded-3" wire:model="phone">
                            @error('phone') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>

                        <!-- Location Dropdown -->
                        <div class="mb-3 position-relative" x-data="{ locOpen: false }" @click.outside="locOpen = false">
                            <label class="form-label small text-muted">{{ __('Location') }}</label>
                            <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center rounded-3 p-2 bg-white text-dark border" type="button" @click="locOpen = !locOpen">
                                <span>{{ $location_name }}</span>
                                <i class="bi bi-chevron-down text-sm"></i>
                            </button>

                            <div class="dropdown-menu w-100 p-2 border shadow-sm rounded-3 mt-1" :class="{ 'show': locOpen }" x-show="locOpen" style="display: block; position: absolute; max-height: 250px; overflow-y: auto; z-index: 1060;">
                                <input wire:model.live="edit_location_search" type="search" class="form-control form-control-sm mb-2 rounded-2" placeholder="{{ __('Search Location') }}">
                                
                                @forelse($edit_locations as $loc)
                                    <button type="button" class="dropdown-item rounded-2 p-2 text-start border-0 bg-transparent w-100" wire:click="setEditLocation({{ $loc->id }}, '{{ $loc->display_name }}')" @click="locOpen = false">
                                        {{ $loc->display_name }}
                                    </button>
                                @empty
                                    <div class="text-muted small text-center p-2">{{ __('No locations found.') }}</div>
                                @endforelse
                            </div>
                            @error('location_id') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>

                    </div>

                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <span wire:loading.remove wire:target="saveProfile">{{ __('Save Changes') }}</span>
                            <span wire:loading wire:target="saveProfile">
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                            </span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

@script
<script>
    $wire.on('open-edit-modal', () => {
        setTimeout(() => {
            $('#editProfileModal').modal('show');
        }, 50);
    });
    $wire.on('close-edit-modal', () => {
        $('#editProfileModal').modal('hide');
    });
</script>
@endscript