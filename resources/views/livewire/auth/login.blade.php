<div>
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" 
         aria-hidden="true" data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- Header -->
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="loginModalLabel">Welcome Back</h5>
                    @if (request()->routeIs('login'))
                        <a href="{{ url('/') }}" class="btn-close"></a>
                    @else
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                </div>

                <!-- Body -->
                <div class="modal-body p-4">

                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-light"
                             style="width:70px;height:70px;">
                            <img src="{{ asset('assets/icons/avatar.png') }}" class="w-100">
                        </div>
                        <h4 class="fw-bold mb-1">Login Account</h4>
                        <p class="text-muted small mb-0">
                            @if($method == 'phone')
                                Enter your mobile number to continue
                            @else
                                Enter your email address to continue
                            @endif
                        </p>
                    </div>

                    <!-- Step 1: Identifier -->
                    @if(!$otpSent)

                        @if($method == 'email')
                            <div class="alert alert-warning border-0 rounded-3 py-2 px-3 mb-3 d-flex align-items-center gap-2" style="font-size: 0.8rem; background-color: rgba(255, 193, 7, 0.1); color: #856404;">
                                <i class="bi bi-info-circle-fill fs-5"></i>
                                <div>
                                    <strong>{{ __('Fast Approval Tip') }}:</strong> {{ __('Use mobile login for instant ad approval without waiting!') }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-success border-0 rounded-3 py-2 px-3 mb-3 d-flex align-items-center gap-2" style="font-size: 0.8rem; background-color: rgba(40, 167, 69, 0.1); color: #155724;">
                                <i class="bi bi-shield-check fs-5"></i>
                                <div>
                                    <strong>{{ __('Instant Approval') }}:</strong> {{ __('Logging in with mobile guarantees instant approval for your ads!') }}
                                </div>
                            </div>
                        @endif

                        @if($isNewUser)
                            <div class="alert alert-info py-2 small">
                                👋 New here! Enter your name to create an account.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input wire:model="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="John Doe">
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                {{ $method === 'email' ? 'Email Address' : 'Phone Number' }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    @if($method == 'phone')
                                        <span>+91</span>
                                    @else
                                        <i class="bi bi-envelope"></i>
                                    @endif
                                </span>
                                <input wire:model.lazy="identifier"
                                       type="{{ $method === 'email' ? 'email' : 'tel' }}"
                                       class="form-control @error('identifier') is-invalid @enderror"
                                       placeholder="Enter {{ ucfirst($method) }}">
                                @error('identifier')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="button" wire:click="sendOtp" wire:loading.attr="disabled"
                                    class="btn btn-primary py-2 rounded-3">
                                <span wire:loading.remove wire:target="sendOtp">
                                    {{ $isNewUser ? 'Create Account & Send OTP' : 'Send Verification Code' }}
                                </span>
                                <span wire:loading wire:target="sendOtp">Sending…</span>
                            </button>
                        </div>

                    <!-- Step 2: OTP -->
                    @else

                        <div class="text-center mb-3">
                            <p class="text-muted small mb-1">OTP sent to</p>
                            <strong>{{ $identifier }}</strong>
                            @if($isNewUser)
                                <div><span class="badge bg-success mt-1">New account created ✓</span></div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">6-digit OTP</label>
                            <input wire:model="otp" type="text" maxlength="6"
                                   class="form-control form-control-lg text-center @error('otp') is-invalid @enderror"
                                   placeholder="• • • • • •" style="letter-spacing: 0.5em;">
                            @error('otp')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-grid mt-3">
                            <button type="button" wire:click="verifyOtp" wire:loading.attr="disabled"
                                    class="btn btn-primary py-2 rounded-3">
                                <span wire:loading.remove wire:target="verifyOtp">Verify & Continue</span>
                                <span wire:loading wire:target="verifyOtp">Verifying…</span>
                            </button>
                        </div>

                        <div class="d-flex justify-content-between mt-2">
                            <button type="button" wire:click="goBack"
                                    class="btn btn-link btn-sm text-secondary p-0">
                                ← Change {{ $method }}
                            </button>
                            <button type="button" wire:click="sendOtp"
                                    class="btn btn-link btn-sm p-0">
                                Resend OTP
                            </button>
                        </div>

                    @endif

                    <!-- Toggle Method -->
                    @if(!$otpSent)
                    <div class="d-grid mt-2">
                        <button type="button" wire:click="toggleLoginMode"
                                class="btn btn-link text-primary w-100 py-2">
                            @if($method == 'phone')
                                Login with Email
                            @else
                                Login with Mobile
                            @endif
                        </button>
                    </div>
                    @endif

                    <!-- Divider -->
                    <div class="d-flex align-items-center my-3">
                        <hr class="flex-grow-1">
                        <span class="px-3 text-muted small">OR</span>
                        <hr class="flex-grow-1">
                    </div>

                    <!-- Google Login -->
                    <div class="d-grid">
                        <a href="{{ route('google.redirect') }}" class="theme-btn-outline rounded-3 py-2 d-flex align-items-center justify-content-center text-decoration-none">
                            <img src="{{ asset('assets/icons/google.png') }}" width="25px">
                            <span class="ms-3 text-dark">Continue with Google</span>
                        </a>
                    </div>

                    <!-- Footer -->
                    <p class="text-center text-muted small mt-4 mb-0">
                        By continuing, you agree to our
                        <a href="#">Terms</a> & <a href="#">Privacy Policy</a>
                    </p>

                </div>
            </div>
        </div>
    </div>

    {{-- Listen for login success event and close modal --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('login-success', () => {
                $('#loginModal').modal('hide');
            });
        });
    </script>
</div>