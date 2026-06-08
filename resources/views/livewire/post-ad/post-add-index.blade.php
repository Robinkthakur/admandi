<div class="container py-5">

    <link
        href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css"
        rel="stylesheet"
    />
    <script
        src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js">
    </script>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Modern Visual Step Progress Bar --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                <div class="card-body p-4">
                    <div class="position-relative px-md-5">
                        
                        {{-- Connection line centered vertically on the circles --}}
                        <div class="position-absolute start-0 end-0 bg-light border-top border-2" style="top: 22.5px; z-index: 1; left: 10% !important; right: 10% !important;"></div>
                        
                        <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
                            
                            {{-- Step 1 --}}
                            <div class="d-flex flex-column align-items-center" style="width: 80px;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold transition-all
                                    {{ $step >= 1 ? 'bg-primary text-white border-primary shadow-sm' : 'bg-light text-muted border-light-subtle' }}" 
                                    style="width: 45px; height: 45px; border: 2px solid;">
                                    @if($step > 1)
                                        <i class="bi bi-check2 fs-5"></i>
                                    @else
                                        1
                                    @endif
                                </div>
                                <span class="small fw-semibold mt-2 text-nowrap {{ $step >= 1 ? 'text-primary' : 'text-muted' }}">{{ __('Category') }}</span>
                            </div>

                            {{-- Step 2 --}}
                            <div class="d-flex flex-column align-items-center" style="width: 80px;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold transition-all
                                    {{ $step >= 2 ? 'bg-primary text-white border-primary shadow-sm' : 'bg-light text-muted border-light-subtle' }}" 
                                    style="width: 45px; height: 45px; border: 2px solid;">
                                    @if($step > 2)
                                        <i class="bi bi-check2 fs-5"></i>
                                    @else
                                        2
                                    @endif
                                </div>
                                <span class="small fw-semibold mt-2 text-nowrap {{ $step >= 2 ? 'text-primary' : 'text-muted' }}">{{ __('Ad Details') }}</span>
                            </div>

                            {{-- Step 3 --}}
                            <div class="d-flex flex-column align-items-center" style="width: 80px;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold transition-all
                                    {{ $step >= 3 ? 'bg-primary text-white border-primary shadow-sm' : 'bg-light text-muted border-light-subtle' }}" 
                                    style="width: 45px; height: 45px; border: 2px solid;">
                                    3
                                </div>
                                <span class="small fw-semibold mt-2 text-nowrap {{ $step >= 3 ? 'text-primary' : 'text-muted' }}">{{ __('Photos') }}</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 1: Choose Category --}}
            @if($step == 1)
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-1">
                            <span class="text-primary me-2">01.</span> {{ __('Choose Category') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Select the main category that best fits your listing') }}</p>
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
                                        <span class="small fw-semibold text-truncate w-100">{{ $category->name }}</span>
                                    </button>
                                </div>
                            @endforeach

                            @error('category_id')
                                <div class="col-lg-12 text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Continue Button -->
                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button
                                class="theme-btn px-4 py-2"
                                wire:click="nextStep"
                            >
                                {{ __('Continue') }} <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>

                    </div>
                </div>
            @endif

            {{-- STEP 2: Ad Details & Location --}}
            @if($step == 2)
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-1">
                            <span class="text-primary me-2">02.</span> {{ __('Ad Details') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Provide detailed information and area location') }}</p>
                    </div>
                    <div class="card-body p-4">

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                                <span>{{ __('Title') }} <span class="text-danger">*</span></span>
                                <small class="text-muted">
                                    <span id="titleCharCount">0</span>/80
                                </small>
                            </label>
                            <input
                                maxlength="80"
                                oninput="charCount(this.value, 'titleCharCount')"
                                id="title"
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
                            <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                                <span>{{ __('Description') }} <span class="text-danger">*</span></span>
                                <small class="text-muted">
                                    <span id="descriptionCharCount">0</span>/3000
                                </small>
                            </label>
                            <textarea
                                maxlength="3000"
                                oninput="charCount(this.value, 'descriptionCharCount')"
                                id="description"
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
                        <div class="mb-4">
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

                        <!-- Location Row -->
                        <div class="row g-3">
                            <!-- State -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('State') }} <span class="text-danger">*</span></label>
                                <select
                                    id="StateSeslect"
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
                                    id="StateSselect"
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

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <button
                                class="btn btn-light rounded-4 px-4 py-2 border"
                                wire:click="previousStep"
                            >
                                <i class="bi bi-arrow-left me-1"></i> {{ __('Back') }}
                            </button>

                            <button
                                class="theme-btn px-4 py-2"
                                wire:click="nextStep"
                            >
                                {{ __('Continue') }} <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>

                    </div>
                </div>
            @endif

            {{-- STEP 3: Upload Images --}}
            @if($step == 3)
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-1">
                            <span class="text-primary me-2">03.</span> {{ __('Upload Photos') }}
                        </h5>
                        <p class="text-muted small mb-0">{{ __('Upload up to 10 high-quality photos for your listing') }}</p>
                    </div>
                    <div class="card-body p-4">

                        <!-- Dropzone area -->
                        <div class="mb-4">
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

                            <!-- Preview Grid -->
                            @if(count($images) > 0)
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
                                                        wire:click="removeImage({{ $index }})"
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

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <button
                                class="btn btn-light rounded-4 px-4 py-2 border"
                                wire:click="previousStep"
                            >
                                <i class="bi bi-arrow-left me-1"></i> {{ __('Back') }}
                            </button>

                            <button
                                class="theme-btn px-4 py-2"
                                wire:click="submit"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove wire:target="submit">
                                    {{ __('Publish Ad') }} <i class="bi bi-check2-circle ms-1"></i>
                                </span>
                                <span wire:loading wire:target="submit">
                                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                    {{ __('Publishing...') }}
                                </span>
                            </button>
                        </div>

                    </div>
                </div>
            @endif

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
        .preview-card {
            position: relative;
            background: #fafafa;
        }
    </style>

    <script>
        const dropArea = document.getElementById('dropArea');
        if (dropArea) {
            dropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropArea.classList.add('dragover');
            });
            dropArea.addEventListener('dragleave', () => {
                dropArea.classList.remove('dragover');
            });
        }

        function charCount(value, id) {
            let count = value.length;
            $('#' + id).text(count);
        }
    </script>

</div>