<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Listings\Listing;
use App\Models\User;
use App\Models\Location\Location;
use Auth;

class ProfileIndex extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $user;
    public $isCurrentUser = false;

    // Edit Profile Fields
    public $name;
    public $email;
    public $phone;
    public $location_id;
    public $location_name;
    public $edit_location_search = '';
    public $edit_locations = [];
    public $avatar_file;

    public function mount($id = null)
    {
        if ($id) {
            $this->user = User::findOrFail($id);
            $this->isCurrentUser = auth()->check() && (auth()->id() === $this->user->id);
        } else {
            if (!auth()->check()) {
                return redirect()->route('login');
            }
            $this->user = auth()->user();
            $this->isCurrentUser = true;

            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->phone = $this->user->phone;
            $this->location_id = $this->user->location_id;
            $this->location_name = $this->user->location?->display_name ?? 'Select Location';
        }
    }

    public function initEditForm()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->location_id = $this->user->location_id;
        $this->location_name = $this->user->location?->display_name ?? 'Select Location';
        $this->edit_location_search = '';
        $this->avatar_file = null;
        $this->getEditLocations();

        $this->dispatch('open-edit-modal');
    }

    public function updatedEditLocationSearch($v)
    {
        if (empty($this->edit_location_search)) {
            $this->getEditLocations();
        } else {
            $this->edit_locations = Location::where('name', 'LIKE', '%' . $this->edit_location_search . '%')
                ->limit(10)
                ->get();
        }
    }

    public function getEditLocations()
    {
        $this->edit_locations = Location::where('is_featured', true)->limit(10)->get();
    }

    public function setEditLocation($locationId, $displayName)
    {
        $this->location_id = $locationId;
        $this->location_name = $displayName;
    }

    public function saveProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:users,phone,' . $this->user->id,
            'location_id' => 'required|exists:locations,id',
            'avatar_file' => 'nullable|image|max:5120', // Max 5MB
        ], [
            'phone.regex' => 'The mobile number must be exactly 10 digits.',
        ]);

        $avatarPath = $this->user->avatar;

        if ($this->avatar_file) {
            $path = $this->avatar_file->store('avatars', 'public');
            $avatarPath = asset('storage/' . $path);
        }

        $emailChanged = $this->email !== $this->user->email;
        $phoneChanged = $this->phone !== $this->user->phone;

        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'location_id' => $this->location_id,
            'avatar' => $avatarPath,
        ];

        if ($emailChanged) {
            $updateData['email_verified_at'] = null;
        }
        if ($phoneChanged) {
            $updateData['phone_verified_at'] = null;
        }

        $this->user->update($updateData);

        $this->user = $this->user->fresh(); // Refresh user details

        $this->dispatch('refresh-navigation'); // Reload counts/details in header
        session()->flash('success', 'Profile updated successfully.');
        $this->dispatch('close-edit-modal');
    }

    public function deleteAd($id)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($id);
        $listing->delete();
        session()->flash('success', 'Ad removed successfully.');
    }

    public function render()
    {
        $query = Listing::where('user_id', $this->user->id)
            ->with(['location', 'category']);

        // For public viewing, only display active ads
        if (!$this->isCurrentUser) {
            $query->where('status', 'active');
        } else {
            // Display active ads on main profile dashboard
            $query->where('status', 'active');
        }

        $listings = $query->latest()->paginate(8);

        return view('livewire.profile.profile-index', [
            'listings' => $listings
        ]);
    }
}
