<div class="container py-4 min-vh-100 bg-light">
    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/profile/' . $user->id) }}">{{ $user->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Verification Status') }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Left column: Trust Card --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="p-4 @if($user->isVerified()) bg-success text-white @elseif($user->needsIdentityVerification()) bg-warning text-dark @else bg-secondary text-white @endif text-center position-relative">
                    <div class="py-3">
                        @if($user->isVerified())
                            <div class="display-1 mb-3">
                                <i class="bi bi-patch-check-fill text-white"></i>
                            </div>
                            <h3 class="fw-bold mb-1">{{ __('Verified Seller') }}</h3>
                            <p class="mb-0 opacity-75 small">{{ __('Profile checked and validated') }}</p>
                        @elseif($user->needsIdentityVerification())
                            <div class="display-1 mb-3">
                                <i class="bi bi-exclamation-triangle-fill text-dark"></i>
                            </div>
                            <h3 class="fw-bold mb-1">{{ __('Complete Verification') }}</h3>
                            <p class="mb-0 opacity-75 small">{{ __('Identity verification pending upload') }}</p>
                        @else
                            <div class="display-1 mb-3">
                                <i class="bi bi-shield-slash text-white"></i>
                            </div>
                            <h3 class="fw-bold mb-1">{{ __('Standard Seller') }}</h3>
                            <p class="mb-0 opacity-75 small">{{ __('Unverified account status') }}</p>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4 bg-white">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <img src="{{ $user->avatar ? $user->avatar : url('assets/icons/avatar.png') }}"
                             class="rounded-circle border"
                             width="60"
                             height="60"
                             style="object-fit:cover; width:60px; height:60px;">
                        <div>
                            <h5 class="fw-bold text-dark mb-0">{{ $user->name }}</h5>
                            <small class="text-muted">{{ __('Member since') }} {{ $user->created_at->format('M Y') }}</small>
                        </div>
                    </div>

                    @if($user->email_verified_at || $user->phone_verified_at || $user->isVerified())
                    <h6 class="fw-bold text-dark mb-3">{{ __('Verified Contact Details') }}</h6>
                    <div class="d-flex flex-column gap-3 mb-4">
                        @if($user->email_verified_at)
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-light border border-light-subtle">
                            <span class="text-muted"><i class="bi bi-envelope me-2 text-primary"></i>{{ __('Email Address') }}</span>
                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i>{{ __('Verified') }}</span>
                        </div>
                        @endif

                        @if($user->phone_verified_at)
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-light border border-light-subtle">
                            <span class="text-muted"><i class="bi bi-phone me-2 text-primary"></i>{{ __('Phone Number') }}</span>
                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i>{{ __('Verified') }}</span>
                        </div>
                        @endif

                        @if($user->isVerified())
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-light border border-light-subtle">
                            <span class="text-muted"><i class="bi bi-person-badge me-2 text-primary"></i>{{ __('Identity Verification') }}</span>
                            <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i>{{ __('Identity Verified') }}</span>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($user->isVerified() && $isOwner)
                        <div class="alert alert-success border-0 rounded-3 p-3">
                            <h6 class="fw-bold mb-1"><i class="bi bi-shield-check me-2"></i>{{ __('Active Trust Status') }}</h6>
                            <p class="small text-muted mb-0">
                                {{ __('Verification is active until') }} <b>{{ $user->verified_until->format('d M Y') }}</b>.
                                @if($isOwner)
                                    ({{ __('Expires in') }} {{ now()->diffInDays($user->verified_until) }} {{ __('days') }})
                                @endif
                            </p>
                        </div>
                        @if($isOwner)
                            <div class="alert alert-warning border-0 rounded-3 p-3 mt-3">
                                <h6 class="fw-bold mb-1 text-dark"><i class="bi bi-lightning-charge-fill me-2 text-warning"></i>{{ __('Featured Ad Credits') }}</h6>
                                <p class="small text-muted mb-0">
                                    {{ __('You have') }} <b>{{ $user->featured_limit }}</b> {{ __('remaining boost credits. You can boost your ads automatically without paying extra.') }}
                                </p>
                            </div>
                        @endif
                    @elseif($user->needsIdentityVerification())
                        <div class="alert alert-warning border-0 rounded-3 p-3 text-dark">
                            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ __('Verification Pending') }}</h6>
                            <p class="small text-dark opacity-75 mb-0">
                                {{ __('You have paid for verification. Please complete the identity upload in the right panel to activate your badge.') }}
                            </p>
                        </div>
                    @endif

                    @if($user->selfie && $user->id_proof)
                        <div class="mt-4 p-3 rounded-4 bg-light border border-light-subtle">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-check-fill me-2 text-success"></i>{{ __('Submitted Identity Documents') }}</h6>
                            <div class="row g-2">
                                <div class="col-6 text-center">
                                    <small class="text-muted d-block mb-1">{{ __('Selfie') }}</small>
                                    <img src="{{ $user->selfie }}" class="img-fluid rounded-3 border" style="max-height: 80px; object-fit: cover;">
                                </div>
                                <div class="col-6 text-center">
                                    <small class="text-muted d-block mb-1">{{ __('ID Proof') }}</small>
                                    <img src="{{ $user->id_proof }}" class="img-fluid rounded-3 border" style="max-height: 80px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($isOwner)
                        <div class="mt-4">
                            @if($user->isVerified())
                                <a href="{{ route('get-verified') }}" class="btn btn-outline-primary w-100 rounded-pill py-2.5 fw-bold">
                                    <i class="bi bi-arrow-repeat me-1"></i> {{ __('Extend / Upgrade Verification') }}
                                </a>
                            @elseif($user->needsIdentityVerification())
                                <a href="#identity-verification-form" class="btn btn-warning w-100 rounded-pill py-2.5 fw-bold text-dark">
                                    <i class="bi bi-shield-exclamation me-1"></i> {{ __('Complete Verification') }}
                                </a>
                            @else
                                <a href="{{ route('get-verified') }}" class="btn btn-primary w-100 rounded-pill py-2.5 fw-bold">
                                    <i class="bi bi-shield-check me-1"></i> {{ __('Verify Profile Now') }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right column: Verification Benefits & (if Owner) Transaction History --}}
        <div class="col-lg-7">
            @if($isOwner && $user->needsIdentityVerification())
                <div id="identity-verification-form" class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border-start border-warning border-4">
                    <h5 class="fw-bold text-dark mb-2">
                        <i class="bi bi-person-badge text-warning me-2"></i>
                        {{ __('Complete Identity Verification') }}
                    </h5>
                    <p class="text-muted small mb-4">
                        {{ __('Your payment has been successfully processed! Please upload a selfie and a valid ID proof to activate your trust badge.') }}
                    </p>

                    <form wire:submit.prevent="submitIdentityVerification">
                        <div class="row g-4 mb-4">
                            <!-- Selfie Upload (Direct Camera) -->
                            <div class="col-md-6 text-center">
                                <div class="p-3 border border-2 border-dashed rounded-4 h-100 d-flex flex-column align-items-center justify-content-center bg-light position-relative" style="min-height: 200px;">
                                    @if($selfie_file)
                                        <div class="position-relative w-100 h-100">
                                            <img src="{{ $selfie_file->temporaryUrl() }}" class="img-fluid rounded-3 shadow-sm border" style="max-height: 160px; object-fit: cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle rounded-circle" wire:click="$set('selfie_file', null)">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    @else
                                        <i class="bi bi-camera text-primary mb-2" style="font-size: 2.5rem;"></i>
                                        <h6 class="fw-bold mb-1 text-dark">{{ __('Take a Selfie') }}</h6>
                                        <p class="text-muted small px-2 mb-3">{{ __('Opens front-facing camera on mobile devices') }}</p>
                                        <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#webcamModal">
                                            <i class="bi bi-camera me-1"></i> {{ __('Open Camera') }}
                                        </button>
                                    @endif
                                    @error('selfie_file') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- ID Proof Upload -->
                            <div class="col-md-6 text-center">
                                <div class="p-3 border border-2 border-dashed rounded-4 h-100 d-flex flex-column align-items-center justify-content-center bg-light position-relative" style="min-height: 200px;">
                                    @if($id_proof_file)
                                        <div class="position-relative w-100 h-100">
                                            <img src="{{ $id_proof_file->temporaryUrl() }}" class="img-fluid rounded-3 shadow-sm border" style="max-height: 160px; object-fit: cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle rounded-circle" wire:click="$set('id_proof_file', null)">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    @else
                                        <i class="bi bi-card-image text-primary mb-2" style="font-size: 2.5rem;"></i>
                                        <h6 class="fw-bold mb-1 text-dark">{{ __('Upload ID Proof') }}</h6>
                                        <p class="text-muted small px-2 mb-3">{{ __('Select a photo of your Passport, License or ID card') }}</p>
                                        <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" onclick="document.getElementById('idProofInput').click();">
                                            <i class="bi bi-upload me-1"></i> {{ __('Select Image') }}
                                        </button>
                                    @endif
                                    <input type="file" class="visually-hidden" id="idProofInput" wire:model="id_proof_file" accept="image/*">
                                    @error('id_proof_file') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar / Upload state -->
                        <div wire:loading wire:target="selfie_file, id_proof_file" class="w-100 mb-3 text-center">
                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                            <span class="text-muted small">{{ __('Uploading document preview...') }}</span>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-warning w-100 rounded-pill py-2.5 fw-bold text-dark d-flex align-items-center justify-content-center gap-2" wire:loading.attr="disabled">
                                <span wire:loading.remove class="d-flex align-items-center gap-2">
                                    <i class="bi bi-shield-check fs-5"></i>
                                    {{ __('Submit Documents & Verify Profile') }}
                                </span>
                                <span wire:loading class=" align-items-center gap-2">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    {{ __('Uploading & Verifying...') }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Benefits list --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="bi bi-star-fill text-warning me-2"></i>
                    {{ __('Verified Seller Benefits') }}
                </h5>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="text-success fs-3"><i class="bi bi-patch-check-fill"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ __('Seller Badge') }}</h6>
                                <small class="text-muted">{{ __('Shows a checkmark next to your name to build trust.') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="text-primary fs-3"><i class="bi bi-lightning-fill"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1{{ __('Search Priority') }} mb-1">{{ __('Search Priority') }}</h6>
                                <small class="text-muted">{{ __('Your ads rank higher in searches for better organic reach.') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="text-warning fs-3"><i class="bi bi-award-fill"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ __('Featured Ad Credits') }}</h6>
                                <small class="text-muted">{{ __('Get credits to feature listings on top slots.') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="text-danger fs-3"><i class="bi bi-heart-pulse-fill"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ __('Dedicated Support') }}</h6>
                                <small class="text-muted">{{ __('Priority round-the-clock support for any queries.') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Transactions Table (Owner Only) --}}
            @if($isOwner)
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="bi bi-clock-history text-secondary me-2"></i>
                        {{ __('Payment & Order History') }}
                    </h5>
                    @if(empty($payments) || count($payments) == 0)
                        <div class="text-center py-4">
                            <div class="text-muted fs-1 mb-2"><i class="bi bi-credit-card"></i></div>
                            <p class="text-muted mb-0">{{ __('No verification payments logged yet.') }}</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Package') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Order ID') }}</th>
                                        <th>{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td class="small">{{ $payment->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <span class="fw-semibold text-dark">{{ $payment->package?->name ?? __('Unknown Package') }}</span>
                                            </td>
                                            <td class="fw-bold text-dark">₹{{ number_format($payment->amount) }}</td>
                                            <td class="small text-muted">{{ $payment->razorpay_order_id }}</td>
                                            <td>
                                                @if($payment->status === 'success')
                                                    <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1">{{ __('Success') }}</span>
                                                @elseif($payment->status === 'failed')
                                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1">{{ __('Failed') }}</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-2.5 py-1">{{ __('Pending') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Webcam Capture Modal -->
    <div class="modal fade" id="webcamModal" tabindex="-1" aria-labelledby="webcamModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                <div class="modal-header bg-dark text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="webcamModalLabel">
                        <i class="bi bi-camera me-2 text-warning"></i>{{ __('Capture Selfie') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="stopWebcam()"></button>
                </div>
                <div class="modal-body p-0 bg-black text-center position-relative" style="min-height: 320px;">
                    <video id="webcamVideo" autoplay playsinline class="w-100 h-100" style="object-fit: cover; max-height: 450px; transform: scaleX(-1);"></video>
                    
                    <!-- Loading overlay -->
                    <div id="webcamLoading" class="position-absolute top-50 start-50 translate-middle text-white">
                        <div class="spinner-border text-light mb-2" role="status"></div>
                        <div class="small">{{ __('Starting camera feed...') }}</div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal" onclick="stopWebcam()">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-warning rounded-pill px-4 fw-bold text-dark d-flex align-items-center gap-2" id="captureBtn" onclick="captureSelfie()">
                        <i class="bi bi-camera-fill fs-5"></i>
                        {{ __('Capture Photo') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    window.captureSelfie = function() {
        const video = document.getElementById('webcamVideo');
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth || 640;
        canvas.height = video.videoHeight || 480;
        const ctx = canvas.getContext('2d');
        
        // Mirror the canvas image to match mirrored video
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        const captureBtn = document.getElementById('captureBtn');
        captureBtn.disabled = true;
        captureBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';

        canvas.toBlob(function (blob) {
            const file = new File([blob], "selfie.jpg", { type: "image/jpeg" });
            
            $wire.upload('selfie_file', file, 
                function (uploadedName) {
                    captureBtn.disabled = false;
                    captureBtn.innerHTML = '<i class="bi bi-camera-fill fs-5"></i> Capture Photo';
                    const modalEl = document.getElementById('webcamModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        modal.hide();
                    }
                }, 
                function (error) {
                    console.error("Livewire upload error: ", error);
                    captureBtn.disabled = false;
                    captureBtn.innerHTML = '<i class="bi bi-camera-fill fs-5"></i> Capture Photo';
                    alert("Selfie upload failed. Please try again.");
                }
            );
        }, 'image/jpeg', 0.9);
    };

    window.stopWebcam = function() {
        if (window.localWebcamStream) {
            window.localWebcamStream.getTracks().forEach(function (track) {
                track.stop();
            });
            window.localWebcamStream = null;
        }
        const video = document.getElementById('webcamVideo');
        if (video) {
            video.srcObject = null;
        }
    };

    const webcamModal = document.getElementById('webcamModal');
    if (webcamModal) {
        webcamModal.addEventListener('show.bs.modal', function () {
            document.getElementById('webcamLoading').classList.remove('d-none');
            const video = document.getElementById('webcamVideo');
            
            navigator.mediaDevices.getUserMedia({
                video: { 
                    facingMode: 'user',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            }).then(function (stream) {
                window.localWebcamStream = stream;
                video.srcObject = stream;
                document.getElementById('webcamLoading').classList.add('d-none');
            }).catch(function (err) {
                console.error("Camera access failed: ", err);
                alert("Could not access webcam. Please ensure camera permissions are enabled in your browser.");
                const modal = bootstrap.Modal.getInstance(webcamModal);
                if (modal) {
                    modal.hide();
                }
            });
        });

        webcamModal.addEventListener('hidden.bs.modal', function () {
            window.stopWebcam();
        });
    }
</script>
@endscript
