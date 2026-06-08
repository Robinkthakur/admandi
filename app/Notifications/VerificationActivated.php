<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerificationActivated extends Notification
{
    use Queueable;

    public $packageName;
    public $verifiedUntil;

    /**
     * Create a new notification instance.
     */
    public function __construct($packageName, $verifiedUntil)
    {
        $this->packageName = $packageName;
        $this->verifiedUntil = $verifiedUntil;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Verification Activated!',
            'message' => "Your profile is verified under the '{$this->packageName}' package until " . $this->verifiedUntil->format('d M Y') . ".",
            'action_url' => url('/profile'),
            'icon' => 'bi-shield-check',
            'type' => 'status'
        ];
    }
}
