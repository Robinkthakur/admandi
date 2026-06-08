<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class Login extends Component
{
    public string $method     = 'phone';
    public string $identifier = '';
    public string $name       = '';
    public string $otp        = '';
    public bool   $otpSent    = false;
    public bool   $isNewUser  = false;

    public $redirect = null;

    protected OtpService $otpService;

    public function boot(OtpService $otpService): void
    {
        $this->otpService = $otpService;
    }

    public function render()
    {
        return view('livewire.auth.login');
    }

    // ----------------------------------------------------------------
    // Rules — switches based on current step
    // ----------------------------------------------------------------
    protected function rules(): array
    {
        if ($this->otpSent) {
            return ['otp' => 'required|digits:6'];
        }

        $identifierRule = $this->method === 'email'
            ? 'required|email|max:255'
            : ['required', 'string', 'max:15', 'regex:/^\+?[0-9]{7,15}$/'];

        $rules = ['identifier' => $identifierRule];

        if ($this->isNewUser) {
            $rules['name'] = 'required|string|min:2|max:100';
        }

        return $rules;
    }

    // ----------------------------------------------------------------
    // Real-time validation
    // ----------------------------------------------------------------
    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    // ----------------------------------------------------------------
    // Toggle email <-> phone
    // ----------------------------------------------------------------
    public function toggleLoginMode(): void
    {
        $this->method = $this->method === 'email' ? 'phone' : 'email';
        $this->reset(['identifier', 'otp', 'otpSent', 'isNewUser', 'name']);
        $this->resetErrorBag();
    }

    // ----------------------------------------------------------------
    // Go back to step 1
    // ----------------------------------------------------------------
    public function goBack(): void
    {
        $this->reset(['otpSent', 'otp', 'isNewUser', 'name']);
        $this->resetErrorBag();
    }

    // ----------------------------------------------------------------
    // Step 1 — Find or register user, then send OTP
    // ----------------------------------------------------------------
    public function sendOtp(): void
    {
        if ($this->method === 'phone') {
            $this->validate(
                ['identifier' => ['required', 'string', 'regex:/^[0-9]{10}$/']],
                ['identifier.regex' => 'The mobile number must be exactly 10 digits.']
            );
        } else {
            $this->validate(['identifier' => 'required|email|max:255']);
        }

        // Rate limit OTP sends
        $key = 'otp-send:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('identifier', "Too many attempts. Retry in {$seconds}s.");
            return;
        }

        // Enforce max 3 OTPs per 3 hours for phone numbers
        if ($this->method === 'phone') {
            $smsKey = 'otp-sms-send:' . $this->identifier;
            if (RateLimiter::tooManyAttempts($smsKey, 3)) {
                $seconds = RateLimiter::availableIn($smsKey);
                if ($seconds >= 3600) {
                    $hours = floor($seconds / 3600);
                    $minutes = ceil(($seconds % 3600) / 60);
                    $timeString = "{$hours}h {$minutes}m";
                } else {
                    $minutes = ceil($seconds / 60);
                    $timeString = "{$minutes}m";
                }
                $this->addError('identifier', "Too many OTP requests. Please try again after {$timeString}.");
                return;
            }
        }

        $field = $this->method === 'email' ? 'email' : 'phone';
        $user  = User::where($field, $this->identifier)->first();

        if ($user && $user->is_suspended) {
            $this->addError('identifier', 'Your account has been suspended. Please contact support.');
            return;
        }

        // New user detected
        $this->isNewUser = is_null($user);

        if ($this->isNewUser) {
            // Show name field first, wait for name input
            if (empty(trim($this->name))) {
                return;
            }

            // Validate name before creating
            $this->validate(['name' => 'required|string|min:2|max:100']);

            $user = User::create([
                'name'     => trim($this->name),
                $field     => $this->identifier,
                'password' => bcrypt(Str::random(32)),
            ]);
        }

        RateLimiter::hit($key, 60);

        if ($this->method === 'phone') {
            $smsKey = 'otp-sms-send:' . $this->identifier;
            RateLimiter::hit($smsKey, 3 * 3600); // 3 hours decay
        }

        $otp = $this->otpService->generate($user);

        $this->method === 'email'
            ? $this->otpService->sendEmail($user, $otp)
            : $this->otpService->sendSms($user, $otp);

        $this->otpSent        = true;
        $this->resendCooldown = 60;

        session()->flash('status', 'OTP sent! Check your ' . $this->method . '.');
    }

    // ----------------------------------------------------------------
    // Step 2 — Verify OTP and login
    // ----------------------------------------------------------------
    public function verifyOtp(): void
    {
        // Validate only the otp field
        $this->validate(['otp' => 'required|digits:6']);

        // Rate limit verify attempts
        $key = 'otp-verify:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('otp', "Too many attempts. Retry in {$seconds}s.");
            return;
        }
        RateLimiter::hit($key, 60);

        $field = $this->method === 'email' ? 'email' : 'phone';
        $user  = User::where($field, $this->identifier)->first();

        if ($user && $user->is_suspended) {
            $this->addError('otp', 'Your account has been suspended. Please contact support.');
            return;
        }

        if (!$user || !$this->otpService->verify($user, $this->otp, $field)) {
            $this->addError('otp', 'Invalid or expired OTP. Please try again.');
            return;
        }

        if ($this->method === 'email') {
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
            }
        } else {
            if (!$user->phone_verified_at) {
                $user->phone_verified_at = now();
            }
        }
        $user->save();

        Auth::login($user, remember: true);
        session()->regenerate();

        $this->dispatch('refresh-navigation');

        if ($this->redirect === 'login') {
            redirect()->intended('/');
        } else {
            $this->dispatch('login-success'); // closes modal, stays on page
        }

        $this->reset(['identifier', 'otp', 'name', 'otpSent', 'isNewUser']);
        $this->resetErrorBag();
    }
}