<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <div class="card-body text-center p-5">

                    <!-- Success Icon -->
                    <div
                        class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                        style="width: 100px; height: 100px;"
                    >

                        <i class="bi bi-check-circle-fill text-success fs-1"></i>

                    </div>

                    <!-- Title -->
                    <h2 class="fw-bold mb-3">

                        {{ __('Ad Posted Successfully') }}

                    </h2>

                    <!-- Description -->
                    <p class="text-muted mb-4">

                        {{ __('Your listing has been submitted successfully. It is now under review and will be live shortly.') }}

                    </p>

                    <!-- Ad Info -->
                    <div
                        class="p-4 mb-4 text-start bg-light rounded-4"
                    >

                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                {{ __('Ad ID') }}
                            </span>

                            <strong>
                                #{{ $listing->ad_id }}
                            </strong>

                        </div>

                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                {{ __('Category') }}
                            </span>

                            <strong>
                                {{ $listing->category?->name }}
                            </strong>

                        </div>

                        <div class="d-flex justify-content-between">

                            <span class="text-muted">
                                {{ __('Status') }}
                            </span>

                            <span class="badge py-2 bg-warning text-dark rounded-4 text-capitalize">

                                {{ __($listing->status) }}

                            </span>

                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-center gap-3">

                        <a
                            href="{{ url('profile/my-ads') }}"
                            class="theme-btn text-decoration-none"
                        >

                            {{ __('View My Ads') }}

                        </a>

                        <a
                            href="{{ url('post-ad') }}"
                            class="theme-btn-outline text-decoration-none"
                        >

                            {{ __('Post Another Ad') }}

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>