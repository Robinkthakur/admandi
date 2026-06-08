<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Listings\Listing;
use App\Models\Listings\Package;
use App\Models\Listings\Payment;
use Illuminate\Support\Facades\Http;

class BoostAds extends Component
{
    public $listings = [];
    public $packages = [];
    public $selectedPackageId = null;
    public $totalPrice = 0;
    public $selectedPackage = null;
    public $idsString = '';

    public function mount()
    {
        $idsStr = request()->query('ids', '');
        $this->idsString = $idsStr;
        $ids = array_filter(explode(',', $idsStr));

        if (empty($ids)) {
            session()->flash('error', 'No listings selected for boosting.');
            return redirect()->to('/profile/my-ads');
        }

        // Fetch listings belonging to auth user
        $this->listings = Listing::where('user_id', auth()->id())
            ->whereIn('id', $ids)
            ->get();

        if ($this->listings->isEmpty()) {
            session()->flash('error', 'No valid listings found to boost.');
            return redirect()->to('/profile/my-ads');
        }

        $user = auth()->user();
        $validIds = $this->listings->pluck('id')->toArray();
        $listingsCount = count($validIds);

        if ($user->isVerified() && $user->featured_limit >= $listingsCount) {
            $pkg = Package::where('duration_in_days', 30)->first() ?? Package::first();

            Payment::create([
                'user_id' => $user->id,
                'package_id' => $pkg->id,
                'listing_ids' => $validIds,
                'amount' => 0.00,
                'razorpay_payment_id' => 'credits_boost',
                'status' => 'success'
            ]);

            $untilDate = now()->addDays($pkg->duration_in_days ?? 30);
            Listing::whereIn('id', $validIds)
                ->update([
                    'is_featured' => true,
                    'featured_until' => $untilDate
                ]);

            $user->decrement('featured_limit', $listingsCount);

            session()->flash('success', __("Ads boosted automatically using your featured ad credits (Remaining credits: :credits).", ['credits' => $user->fresh()->featured_limit]));
            return redirect()->to('/profile/my-ads');
        }

        // Fetch database driven packages
        $this->packages = Package::orderBy('price', 'asc')->get();
        
        if ($this->packages->isEmpty()) {
            session()->flash('error', 'No boosting packages are currently available.');
            return redirect()->to('/profile/my-ads');
        }

        $this->selectedPackageId = $this->packages->first()->id;
        $this->updatePackageDetails();
    }

    public function updatedSelectedPackageId()
    {
        $this->updatePackageDetails();
    }

    private function updatePackageDetails()
    {
        $this->selectedPackage = Package::find($this->selectedPackageId);
        if ($this->selectedPackage) {
            $this->totalPrice = $this->selectedPackage->price * $this->listings->count();
        }
    }

    public function createRazorpayOrder()
    {
        $this->updatePackageDetails();

        $keyId = config('services.razorpay.key_id');
        $keySecret = config('services.razorpay.key_secret');
        
        // Amount in paisa
        $amountInPaisa = (int)round($this->totalPrice * 100);

        try {
            $response = Http::withBasicAuth($keyId, $keySecret)
                ->post('https://api.razorpay.com/v1/orders', [
                    'amount' => $amountInPaisa,
                    'currency' => 'INR',
                    'receipt' => 'receipt_boost_' . uniqid()
                ]);

            if ($response->successful()) {
                $order = $response->json();

                // Create a pending payment log in the database
                $payment = Payment::create([
                    'user_id' => auth()->id(),
                    'package_id' => $this->selectedPackageId,
                    'listing_ids' => $this->listings->pluck('id')->toArray(),
                    'amount' => $this->totalPrice,
                    'razorpay_order_id' => $order['id'],
                    'status' => 'pending'
                ]);

                // Dispatch event to front-end to launch checkout
                $this->dispatch('launch-razorpay', [
                    'key' => $keyId,
                    'amount' => $order['amount'],
                    'currency' => $order['currency'],
                    'name' => 'adMandi Ads Boost',
                    'description' => 'Featured Ad Boosting - ' . $this->selectedPackage->name,
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

        $payment = Payment::where('razorpay_order_id', $razorpay_order_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$payment) {
            session()->flash('error', 'Payment transaction not found in records.');
            return redirect()->to('/profile/boost-ads?ids=' . $this->idsString);
        }

        if (hash_equals($expectedSignature, $razorpay_signature)) {
            // Signature verification succeeded
            $payment->update([
                'razorpay_payment_id' => $razorpay_payment_id,
                'razorpay_signature' => $razorpay_signature,
                'status' => 'success'
            ]);

            // Set listings as featured
            $untilDate = now()->addDays($this->selectedPackage->duration_in_days);
            Listing::whereIn('id', $payment->listing_ids)
                ->where('user_id', auth()->id())
                ->update([
                    'is_featured' => true,
                    'featured_until' => $untilDate
                ]);

            session()->flash('success', "Ads successfully boosted! They will be featured until {$untilDate->format('d M Y H:i')}.");
            return redirect()->to('/profile/my-ads');
        } else {
            // Signature verification failed
            $payment->update([
                'status' => 'failed'
            ]);

            session()->flash('error', 'Payment verification failed. Invalid signature.');
            return redirect()->to('/profile/boost-ads?ids=' . $this->idsString);
        }
    }

    public function render()
    {
        return view('livewire.profile.boost-ads')
            ->layout('layouts.app');
    }
}
