<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use App\Models\User;
use App\Models\Setting;
use App\Mail\DynamicMail;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('app:send-inactive-notifications', function () {
    $this->info('Starting inactive notifications process...');
    
    // Find users who have been inactive for more than 24 hours
    // i.e., last_active_at < 24 hours ago OR (last_active_at is null AND created_at < 24 hours ago)
    // and inactive_notified_at is null
    $cutoff = now()->subHours(24);
    
    $users = User::where(function ($query) use ($cutoff) {
            $query->where('last_active_at', '<', $cutoff)
                  ->orWhere(function ($q) use ($cutoff) {
                      $q->whereNull('last_active_at')
                        ->where('created_at', '<', $cutoff);
                  });
        })
        ->whereNull('inactive_notified_at')
        ->where('is_suspended', false)
        ->get();
        
    $this->info("Found {$users->count()} inactive users.");
    
    $emailEnabled = (bool) Setting::get('inactive_email_enabled', false);
    $whatsappEnabled = (bool) Setting::get('inactive_whatsapp_enabled', false);
    
    if (!$emailEnabled && !$whatsappEnabled) {
        $this->comment('Inactivity notifications are disabled in settings.');
        return;
    }
    
    $whatsappService = app(WhatsAppService::class);
    
    foreach ($users as $user) {
        $search = ['{user_name}', '{site_url}'];
        $replace = [$user->name ?? 'User', url('/')];
        
        $sentAny = false;
        
        // 1. Send Email
        if ($emailEnabled && $user->email) {
            $subject = str_replace($search, $replace, Setting::get('inactive_email_subject', 'We miss you on AdMandi!'));
            $body = str_replace($search, $replace, Setting::get('inactive_email_body', "Hello {user_name},\n\nWe noticed you haven't been active on AdMandi in the last 24 hours. Come back and see what's new!\n\nCheck out latest listings here: {site_url}"));
            
            try {
                Mail::to($user->email)->send(new DynamicMail($subject, $body));
                $sentAny = true;
                $this->info("Emailed inactive user: {$user->email}");
            } catch (\Exception $e) {
                Log::error("Failed to send inactive email to {$user->email}: " . $e->getMessage());
            }
        }
        
        // 2. Send WhatsApp
        if ($whatsappEnabled && $user->phone) {
            $whatsappBody = str_replace($search, $replace, Setting::get('inactive_whatsapp_body', "Hello {user_name}, we miss you on AdMandi! Check out the latest deals today: {site_url}"));
            
            try {
                $success = $whatsappService->send($user->phone, $whatsappBody);
                if ($success) {
                    $sentAny = true;
                    $this->info("Sent WhatsApp to inactive user: {$user->phone}");
                }
            } catch (\Exception $e) {
                Log::error("Failed to send inactive WhatsApp to {$user->phone}: " . $e->getMessage());
            }
        }
        
        // Update user so we don't notify them again until they become active and inactive again
        if ($sentAny) {
            $user->update([
                'inactive_notified_at' => now(),
            ]);
        }
    }
    
    $this->info('Inactive notifications process completed.');
})->purpose('Send email or WhatsApp notifications to users inactive for 24 hours');

// Schedule command hourly
Schedule::command('app:send-inactive-notifications')->hourly();
