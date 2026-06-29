<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use App\Models\Listings\Listing;
use App\Models\Listings\Payment;
use App\Models\Listings\VerificationPayment;
use App\Models\User;
use App\Services\ActivityLogger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Auth Events
        Event::listen(Login::class, function (Login $event) {
            $userType = get_class($event->user);
            $role = (str_contains($userType, 'Admin')) ? 'Admin' : 'User';
            ActivityLogger::log('Login', "{$role} logged in successfully.", $event->user);
        });

        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                $userType = get_class($event->user);
                $role = (str_contains($userType, 'Admin')) ? 'Admin' : 'User';
                ActivityLogger::log('Logout', "{$role} logged out.", $event->user);
            }
        });

        Event::listen(Registered::class, function (Registered $event) {
            ActivityLogger::log('Registered', "User registered a new account: {$event->user->email}", $event->user);
        });

        // 2. Listing Events
        Listing::creating(function (Listing $listing) {
            $user = $listing->user;
            if ($user && ($user->phone_verified_at || $user->isVerified())) {
                $listing->status = 'active';
            }
        });

        Listing::created(function (Listing $listing) {
            ActivityLogger::log('Listing Created', "Listing '{$listing->title}' (ID: {$listing->ad_id}) was created.", $listing->user);
        });

        Listing::updated(function (Listing $listing) {
            $dirty = $listing->getDirty();
            // Ignore views and updated_at modifications
            unset($dirty['views'], $dirty['updated_at']);
            if (!empty($dirty)) {
                if (isset($dirty['status'])) {
                    $newStatus = $listing->status;
                    
                    if ($newStatus === 'sold') {
                        ActivityLogger::log('Listing Sold', "Listing '{$listing->title}' (ID: {$listing->ad_id}) was marked as sold.", $listing->user);
                    } elseif ($newStatus === 'pending') {
                        ActivityLogger::log('Listing Paused', "Listing '{$listing->title}' (ID: {$listing->ad_id}) was paused.", $listing->user);
                    } elseif ($newStatus === 'active') {
                        ActivityLogger::log('Listing Activated', "Listing '{$listing->title}' (ID: {$listing->ad_id}) was activated/resumed.", $listing->user);
                    } else {
                        ActivityLogger::log('Listing Updated', "Listing '{$listing->title}' (ID: {$listing->ad_id}) status changed to: {$newStatus}.", $listing->user);
                    }
                    
                    unset($dirty['status']);
                }
                
                if (!empty($dirty)) {
                    ActivityLogger::log('Listing Updated', "Listing '{$listing->title}' (ID: {$listing->ad_id}) was updated.", $listing->user);
                }
            }
        });

        Listing::deleted(function (Listing $listing) {
            ActivityLogger::log('Listing Deleted', "Listing '{$listing->title}' (ID: {$listing->ad_id}) was deleted.", $listing->user);
        });

        // 3. User Profile Update Events
        User::saved(function (User $user) {
            \Illuminate\Support\Facades\Log::info("User saved: {$user->id}, phone_verified_at: {$user->phone_verified_at}");
            if ($user->phone_verified_at || $user->isVerified()) {
                $count = $user->listings()->where('status', 'pending')->update(['status' => 'active']);
                \Illuminate\Support\Facades\Log::info("Activated {$count} listings for user {$user->id}");
            }
        });

        User::updated(function (User $user) {
            $trackedFields = ['name', 'email', 'phone', 'location_id', 'avatar', 'is_suspended', 'is_verified'];
            $changes = array_intersect(array_keys($user->getChanges()), $trackedFields);
            if (!empty($changes)) {
                $fields = implode(', ', $changes);
                ActivityLogger::log('Profile Updated', "Profile updated (modified fields: {$fields}).", $user);
            }
        });

        // 4. Payment Events
        Payment::updated(function (Payment $payment) {
            if ($payment->wasChanged('status') && $payment->status === 'success') {
                $packageName = $payment->package ? $payment->package->name : 'N/A';
                ActivityLogger::log('Ad Boosted', "Ads boosted successfully using package '{$packageName}' (Amount: ₹{$payment->amount}).", $payment->user);
            }
        });

        VerificationPayment::updated(function (VerificationPayment $payment) {
            if ($payment->wasChanged('status') && $payment->status === 'success') {
                $packageName = $payment->package ? $payment->package->name : 'N/A';
                ActivityLogger::log('Verification Purchased', "Verification package '{$packageName}' purchased (Amount: ₹{$payment->amount}).", $payment->user);
            }
        });

        // 5. First Message Notification trigger
        \App\Models\Chats\Message::created(function (\App\Models\Chats\Message $message) {
            $conversation = $message->conversation;
            if ($conversation && \App\Models\Chats\Message::where('conversation_id', $conversation->id)->count() === 1) {
                // Determine recipient: if sender is buyer, recipient is seller, and vice versa
                $recipient = ($message->sender_id === $conversation->buyer_id) ? $conversation->seller : $conversation->buyer;

                if ($recipient) {
                    $buyerName = $conversation->buyer->name ?? 'User';
                    $sellerName = $conversation->seller->name ?? 'User';
                    $listingTitle = $conversation->listing->title ?? 'Listing';
                    $messageText = $message->message;
                    $chatUrl = route('chat', ['c' => $conversation->id]);

                    $search = ['{buyer_name}', '{seller_name}', '{listing_title}', '{message_text}', '{chat_url}'];
                    $replace = [$buyerName, $sellerName, $listingTitle, $messageText, $chatUrl];

                    // Send Email Notification
                    if (\App\Models\Setting::get('first_message_email_enabled', false)) {
                        $subject = str_replace($search, $replace, \App\Models\Setting::get('first_message_email_subject', 'New enquiry for your listing: {listing_title}'));
                        $body = str_replace($search, $replace, \App\Models\Setting::get('first_message_email_body', "Hello {seller_name},\n\nYou received a new message from {buyer_name} for '{listing_title}':\n\n\"{message_text}\"\n\nReply here: {chat_url}"));

                        try {
                            \Illuminate\Support\Facades\Mail::to($recipient->email)->send(new \App\Mail\DynamicMail($subject, $body));
                            \Illuminate\Support\Facades\Log::info("First message notification email sent to {$recipient->email}");
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::error("Failed to send first message notification email to {$recipient->email}: " . $e->getMessage());
                        }
                    }

                    // Send WhatsApp Notification
                    if (\App\Models\Setting::get('first_message_whatsapp_enabled', false) && $recipient->phone) {
                        $whatsappBody = str_replace($search, $replace, \App\Models\Setting::get('first_message_whatsapp_body', "Hello {seller_name}, you have a new message from {buyer_name} for '{listing_title}': \"{message_text}\". Reply: {chat_url}"));

                        try {
                            $whatsappService = app(\App\Services\WhatsAppService::class);
                            $whatsappService->send($recipient->phone, $whatsappBody);
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::error("Failed to send first message WhatsApp to {$recipient->phone}: " . $e->getMessage());
                        }
                    }
                }
            }
        });
    }
}

