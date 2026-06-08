<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Listings\VerificationPayment;
use Auth;

class VerificationStatus extends Component
{
    use WithFileUploads;

    public $user;
    public $isOwner = false;
    public $payments = [];

    // File fields
    public $selfie_file;
    public $id_proof_file;

    public function mount($id = null)
    {
        if ($id) {
            $this->user = User::find($id);
            if (!$this->user) {
                abort(404, 'User not found.');
            }
        } else {
            if (!auth()->check()) {
                return redirect()->route('login');
            }
            $this->user = auth()->user();
        }

        $this->isOwner = auth()->check() && (auth()->id() === $this->user->id);

        if ($this->isOwner) {
            // Load verification payment history
            $this->payments = VerificationPayment::where('user_id', $this->user->id)
                ->with('package')
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function submitIdentityVerification()
    {
        if (!$this->isOwner) {
            return;
        }

        $this->validate([
            'selfie_file' => 'required|image|max:10240', // Max 10MB
            'id_proof_file' => 'required|image|max:10240', // Max 10MB
        ]);

        // Save files
        $selfiePath = $this->selfie_file->store('selfies', 'public');
        $idProofPath = $this->id_proof_file->store('id_proofs', 'public');

        // Fetch verification payment details to set featured limit
        $lastPayment = VerificationPayment::where('user_id', $this->user->id)
            ->where('status', 'success')
            ->with('package')
            ->latest()
            ->first();
        $packageName = $lastPayment?->package?->name ?? 'Profile Verification';
        $featuredLimit = $lastPayment?->package?->featured_limit ?? 0;

        $this->user->update([
            'selfie' => asset('storage/' . $selfiePath),
            'id_proof' => asset('storage/' . $idProofPath),
            'is_verified' => true,
            'featured_limit' => $this->user->featured_limit + $featuredLimit,
        ]);

        $this->user->notify(new \App\Notifications\VerificationActivated($packageName, $this->user->verified_until ?? now()->addMonth()));

        session()->flash('success', __('Identity verified successfully! Your trust badge is now active.'));
        return redirect()->route('verification-status');
    }

    public function render()
    {
        return view('livewire.profile.verification-status')
            ->layout('layouts.app');
    }
}

