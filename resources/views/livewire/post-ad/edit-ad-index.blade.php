<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            {{-- Success Message --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3 d-flex justify-content-between align-items-center" role="alert">
                    <div>
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Form --}}
            <form wire:submit.prevent="submit">

                {{-- 1. Category Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-1">
                            <span class="text-primary me-2">01.</span> {{ __('Category') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Select the best category for your listing') }}</p>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Categories Grid -->
                        <div class="row g-3">
                            @foreach($categories as $category)
                                <div class="col-md-3 col-6">
                                    <button
                                        type="button"
                                        class="btn w-100 h-100 border rounded-4 py-3 d-flex flex-column gap-2 align-items-center justify-content-center transition-all
                                        {{ $category_id == $category->id ? 'btn-primary border-primary shadow-sm text-white' : 'btn-light border-light-subtle text-dark' }}"
                                        wire:click="selectCategory({{ $category->id }})"
                                    >
                                        @if($category->image)
                                            <img src="{{ asset('storage/'.$category->image) }}" alt="" style="height:36px; width:auto;">
                                        @endif
                                        <span class="small fw-semibold">{{ $category->name }}</span>
                                    </button>
                                </div>
                            @endforeach

                            @error('category_id')
                                <div class="col-lg-12 text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>


                {{-- 2. Details Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-1">
                            <span class="text-primary me-2">02.</span> {{ __('Listing Details') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Provide detailed information about what you are selling') }}</p>
                    </div>
                    <div class="card-body p-4">

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">{{ __('Title') }} <span class="text-danger">*</span></label>
                            <input
                                maxlength="80"
                                type="text"
                                class="form-control rounded-3"
                                placeholder="{{ __('E.g. iPhone 15 Pro Max 256GB') }}"
                                wire:model="title"
                            >
                            @error('title')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">{{ __('Description') }} <span class="text-danger">*</span></label>
                            <textarea
                                maxlength="3000"
                                class="form-control rounded-3"
                                rows="6"
                                placeholder="{{ __('Describe your item, features, condition, etc...') }}"
                                wire:model="description"
                            ></textarea>
                            @error('description')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-2">
                            <label class="form-label fw-semibold">{{ __('Price') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-3 bg-light border-end-0">₹</span>
                                <input
                                    type="number"
                                    class="form-control rounded-end-3"
                                    placeholder="{{ __('Enter price') }}"
                                    wire:model="price"
                                >
                            </div>
                            @error('price')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                </div>


                {{-- 3. Location Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-1">
                            <span class="text-primary me-2">03.</span> {{ __('Location Info') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Help buyers find your listing in their area') }}</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- State -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('State') }} <span class="text-danger">*</span></label>
                                <select
                                    class="form-select rounded-3"
                                    wire:model.live="state_id"
                                >
                                    <option value="">{{ __('Select State') }}</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('City') }} <span class="text-danger">*</span></label>
                                <select
                                    class="form-select rounded-3"
                                    wire:model="city_id"
                                    @if(!$state_id) disabled @endif
                                >
                                    <option value="">{{ __('Select City') }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                {{-- 4. Photos Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-1">
                            <span class="text-primary me-2">04.</span> {{ __('Photos') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Manage your listing photos (min 1, max 10)') }}</p>
                    </div>
                    <div class="card-body p-4">

                        <!-- Existing Photos -->
                        @if(count($existingImages) > 0)
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3 text-secondary small uppercase tracking-wider">{{ __('Current Photos') }}</h6>
                                <div class="row g-3">
                                    @foreach($existingImages as $media)
                                        <div class="col-md-3 col-6" wire:key="existing-img-{{ $media['id'] }}">
                                            <div class="preview-card border rounded-4 position-relative overflow-hidden aspect-ratio-1">
                                                <button
                                                    type="button"
                                                    class="remove-image shadow-sm border-0 position-absolute top-0 end-0 m-2 rounded-circle bg-danger text-white d-flex align-items-center justify-content-center"
                                                    style="width: 32px; height: 32px; z-index: 10;"
                                                    wire:click="deleteExistingImage({{ $media['id'] }})"
                                                    wire:confirm="{{ __('Are you sure you want to remove this photo?') }}"
                                                >
                                                    <i class="bi bi-trash fs-6"></i>
                                                </button>
                                                <img src="{{ $media['url'] }}" class="img-fluid w-100 h-100 object-fit-cover" alt="Existing photo">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Add New Photos -->
                        <div>
                            <h6 class="fw-bold mb-3 text-secondary small uppercase tracking-wider">{{ __('Add More Photos') }}</h6>
                            
                            <label
                                class="upload-area rounded-4 border border-2 border-dashed px-5 py-4 text-center position-relative d-flex flex-column align-items-center justify-content-center transition-all bg-light"
                                id="dropArea"
                                for="imageInput"
                                style="cursor: pointer; min-height: 180px;"
                            >
                                <input
                                    wire:model.live="images"
                                    type="file"
                                    id="imageInput"
                                    multiple
                                    accept="image/*"
                                    class="d-none"
                                >
                                <div class="upload-content text-center">
                                    <div class="upload-icon mb-3 mx-auto bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                        <i class="bi bi-cloud-arrow-up fs-2"></i>
                                    </div>
                                    <h5 class="fw-bold mb-1 fs-6">{{ __('Drag & Drop Images') }}</h5>
                                    <p class="text-muted small mb-0">{{ __('or click to browse photos') }}</p>
                                </div>
                            </label>

                            @error('images')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror

                            <!-- New Photos Preview Grid -->
                            @if(count($images) > 0 || $errors->has('images'))
                                <div class="row g-3 mt-3">
                                    <div class="col-md-2" wire:loading wire:target="images">
                                        <div class="preview-card border rounded-4 d-flex justify-content-center align-items-center bg-light aspect-ratio-1">
                                            <div class="text-center p-2">
                                                <div class="spinner-border spinner-border-sm text-primary mb-1" role="status"></div>
                                                <div class="small text-muted" style="font-size: 11px;">{{ __('Uploading...') }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach($images as $index => $image)
                                        @if ($image && !is_string($image) && method_exists($image, 'temporaryUrl'))
                                            <div class="col-md-2 col-4" wire:key="new-img-{{ $index }}">
                                                <div class="preview-card border rounded-4 position-relative overflow-hidden aspect-ratio-1">
                                                    <button
                                                        type="button"
                                                        class="remove-image shadow-sm border-0 position-absolute top-0 end-0 m-2 rounded-circle bg-danger text-white d-flex align-items-center justify-content-center"
                                                        style="width: 28px; height: 28px; z-index: 10;"
                                                        wire:click="removeNewImage({{ $index }})"
                                                    >
                                                        <i class="bi bi-x-lg fs-6"></i>
                                                    </button>
                                                    <img src="{{ $image->temporaryUrl() }}" class="img-fluid w-100 h-100 object-fit-cover">
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                        </div>

                    </div>
                </div>


                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a
                        href="/profile/my-ads"
                        class="btn btn-light rounded-4 px-4 py-2 border"
                    >
                        <i class="bi bi-arrow-left me-1"></i> {{ __('Cancel') }}
                    </a>

                    <button
                        type="submit"
                        class="theme-btn px-4 py-2"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="submit">
                            {{ __('Save Changes') }} <i class="bi bi-check2-circle ms-1"></i>
                        </span>
                        <span wire:loading wire:target="submit">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            {{ __('Saving...') }}
                        </span>
                    </button>
                </div>

            </form>

        </div>

    </div>

    <style>
        .aspect-ratio-1 {
            aspect-ratio: 1/1;
        }
        .transition-all {
            transition: all 0.2s ease-in-out;
        }
        .upload-area:hover {
            border-color: #6047e6 !important;
            background-color: rgba(96, 71, 230, 0.03) !important;
        }
    </style>

</div>
