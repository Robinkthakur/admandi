<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Listings\VerificationPackage;
use App\Models\Listings\VerificationPayment;
use Illuminate\Support\Facades\Http;
use Auth;

class GetVerified extends Component
{
    public $packages = [];

    public function mount()
    {
        $this->packages = VerificationPackage::orderBy('price', 'asc')->get();
    }

    public function selectPackage($packageId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $package = VerificationPackage::find($packageId);

        if (!$package) {
            session()->flash('error', 'Invalid package selected.');
            return;
        }

        $keyId = config('services.razorpay.key_id');
        $keySecret = config('services.razorpay.key_secret');
        
        // Amount in paisa
        $amountInPaisa = (int)round($package->price * 100);

        try {
            $response = Http::withBasicAuth($keyId, $keySecret)
                ->post('https://api.razorpay.com/v1/orders', [
                    'amount' => $amountInPaisa,
                    'currency' => 'INR',
                    'receipt' => 'receipt_verify_' . uniqid()
                ]);

            if ($response->successful()) {
                $order = $response->json();

                // Create a pending payment log in the database
                VerificationPayment::create([
                    'user_id' => auth()->id(),
                    'verification_package_id' => $package->id,
                    'amount' => $package->price,
                    'razorpay_order_id' => $order['id'],
                    'status' => 'pending'
                ]);

                // Dispatch event to front-end to launch checkout
                $this->dispatch('launch-razorpay', [
                    'key' => $keyId,
                    'amount' => $order['amount'],
                    'currency' => $order['currency'],
                    'name' => 'adMandi Profile Verification',
                    'description' => 'Profile Verification - ' . $package->name,
                    'order_id' => $order['id'],
                    'prefill' => [
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                    ]
                ]);
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['description'] ?? 'Could not create order. Please try again.';
                $this->dispatch('payment-failed', $errorMessage);
            }
        } catch (\Exception $e) {
            $this->dispatch('payment-failed', 'An error occurred connection to payment gateway: ' . $e->getMessage());
        }
    }

    public function verifyPayment($razorpay_order_id, $razorpay_payment_id, $razorpay_signature)
    {
        $keySecret = config('services.razorpay.key_secret');
        
        // Calculate expected signature
        $expectedSignature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $keySecret);

        $payment = VerificationPayment::where('razorpay_order_id', $razorpay_order_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$payment) {
            session()->flash('error', 'Payment transaction not found in records.');
            return redirect()->route('get-verified');
        }

        $package = $payment->package;

        if (hash_equals($expectedSignature, $razorpay_signature)) {
            // Signature verification succeeded
            $payment->update([
                'razorpay_payment_id' => $razorpay_payment_id,
                'razorpay_signature' => $razorpay_signature,
                'status' => 'success'
            ]);

            // Save user verification target duration, but don't mark as verified yet
            $user = auth()->user();
            $months = $package->duration_in_months;
            $verifiedUntil = now()->addMonths($months);

            $user->update([
                'verified_until' => $verifiedUntil
            ]);

            session()->flash('success', "Payment received successfully! Please complete your identity verification below to activate your verified badge.");
            return redirect()->route('verification-status');
        } else {
            // Signature verification failed
            $payment->update([
                'status' => 'failed'
            ]);

            session()->flash('error', 'Payment verification failed. Invalid signature.');
            return redirect()->route('get-verified');
        }
    }

    public function render()
    {
        return view('livewire.profile.get-verified')
            ->layout('layouts.app');
    }
}
