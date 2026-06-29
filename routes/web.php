<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DevController;

use App\Livewire\Chats\ChatIndex;
use App\Livewire\Actions\Logout;

use App\Livewire\PostAd\PostAdIndex;
use App\Livewire\PostAd\AdPosted;
use App\Livewire\PostAd\EditAdIndex;

use App\Livewire\Listings\ListingIndex;
use App\Livewire\Listings\SingleListingView;
use App\Livewire\Listings\WishlistIndex;

use App\Livewire\Profile\ProfileIndex;
use App\Livewire\Profile\MyAds;
use App\Livewire\Profile\GetVerified;
use App\Livewire\Profile\BoostAds;


Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'hi', 'pa'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('change-locale');

Route::view('/', 'index');



Route::get('/ads', ListingIndex::class);
Route::get('/ads/{location}', ListingIndex::class);
Route::get('/ads/{location}/{category}', ListingIndex::class);

Route::middleware('auth')->group(function () {

    Route::get('/dev', [DevController::class, 'index']);

    Route::get('/profile/my-ads', MyAds::class);
    Route::get('/profile/boost-ads', BoostAds::class)->name('boost-ads');

    Route::get('/post-ad', PostAdIndex::class)->name('post-ad');
    Route::get('/post-ad/success/{ad_id}', AdPosted::class);
    Route::get('/edit-ad/{id}', EditAdIndex::class)->name('edit-ad');
    
    Route::get('/chat', ChatIndex::class)->name('chat');

    Route::get('/wishlist', WishlistIndex::class)->name('wishlist');

    Route::get('/get-verified', GetVerified::class)->name('get-verified');

    Route::view('/ad-limit-exceeded', 'errors.ad-limit-exceeded')->name('ad-limit-exceeded');

    Route::get('/logout', Logout::class)->name('logout');

});

Route::get('/profile/verification-status/{id?}', \App\Livewire\Profile\VerificationStatus::class)->name('verification-status');
Route::get('/profile/{id?}', ProfileIndex::class);

Route::view('/privacy-policy', 'policies.privacy')->name('privacy-policy');
Route::view('/terms-conditions', 'policies.terms')->name('terms-conditions');
Route::view('/refund-policy', 'policies.refund')->name('refund-policy');
Route::view('/cookie-policy', 'policies.cookie')->name('cookie-policy');
Route::view('/help-center', 'policies.help')->name('help-center');
Route::view('/about', 'policies.about')->name('about');
Route::view('/contact', 'policies.contact')->name('contact');
Route::post('/contact', function (Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:10000',
    ]);

    App\Models\ContactEnquiry::create($data);

    return response()->json(['success' => true]);
});
Route::view('/sitemap', 'policies.sitemap')->name('sitemap');

require __DIR__.'/auth.php';

// for listing view
Route::get('/{slug}', SingleListingView::class);
