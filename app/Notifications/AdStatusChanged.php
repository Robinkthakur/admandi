<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdStatusChanged extends Notification
{
    use Queueable;

    public $listingTitle;
    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($listingTitle, $status)
    {
        $this->listingTitle = $listingTitle;
        $this->status = $status;
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
            'title' => 'Ad Status Updated',
            'message' => "Your ad '{$this->listingTitle}' is now marked as '{$this->status}'.",
            'action_url' => url('/profile/my-ads'),
            'icon' => $this->status === 'active' ? 'bi-play-circle-fill' : ($this->status === 'sold' ? 'bi-check-circle-fill' : 'bi-pause-circle-fill'),
            'type' => 'status'
        ];
    }
}
