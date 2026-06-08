<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Listings\Listing;

class MyAds extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $status = 'all';

    public $selectedAdIds = []; // Checkboxes for multiple ads

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function markAsSold($id)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($id);
        $listing->update(['status' => 'sold']);

        // Notify user of status change
        auth()->user()->notify(new \App\Notifications\AdStatusChanged($listing->title, 'sold'));

        session()->flash('success', 'Ad marked as sold.');
    }

    public function toggleStatus($id)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($id);
        
        if ($listing->status === 'sold') {
            return;
        }

        $newStatus = $listing->status === 'active' ? 'pending' : 'active';
        $listing->update(['status' => $newStatus]);

        // Notify user of status change
        auth()->user()->notify(new \App\Notifications\AdStatusChanged($listing->title, $newStatus));

        session()->flash('success', 'Ad status updated.');
    }

    public function deleteAd($id)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($id);
        $listing->delete();
        session()->flash('success', 'Ad removed successfully.');
    }

    public function selectBulkForBoost()
    {
        if (empty($this->selectedAdIds)) {
            session()->flash('error', 'Please select at least one ad.');
            return;
        }

        $ids = implode(',', $this->selectedAdIds);
        return redirect()->to("/profile/boost-ads?ids={$ids}");
    }

    public function render()
    {
        
        $query = Listing::where('user_id', auth()->id())
            ->with(['location', 'category'])
            ->withCount('wishlists');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        $listings = $query->orderBy('id', 'desc')->paginate(12);

        return view('livewire.profile.my-ads', [
            'listings' => $listings
        ]);
    }
}
