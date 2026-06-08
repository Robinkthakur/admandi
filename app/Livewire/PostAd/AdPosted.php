<?php

namespace App\Livewire\PostAd;

use Livewire\Component;
use App\Models\Listings\Listing;

use Illuminate\Contracts\Encryption\DecryptException;

class AdPosted extends Component
{
    public $listing;
    public function mount($ad_id){
        try{
            $ad_id = decrypt($ad_id);
        }
        catch(DecryptException $e){
            abort(404);
        }
        
        $this->listing = Listing::where('ad_id', $ad_id)
            ->where('user_id', auth()->id())
            // ->select('ad_id', 'status')
            ->firstOrFail();

    }
    public function render(){
        return view('post-ad/ad-posted')
            ->layout('layouts.blank', [
                'headerTitle' => 'Ad Posted',
                'title' => 'Ad Posted Successfully | AdMandi'
            ]);
    }
}