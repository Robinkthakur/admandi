<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdSaved extends Notification
{
    use Queueable;

    public $listingTitle;
    public $listingSlug;

    /**
     * Create a new notification instance.
     */
    public function __construct($listingTitle, $listingSlug)
    {
        $this->listingTitle = $listingTitle;
        $this->listingSlug = $listingSlug;
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
            'title' => 'Ad Saved',
            'message' => "Someone saved your '{$this->listingTitle}' ad.",
            'action_url' => url($this->listingSlug),
            'icon' => 'bi-heart-fill',
            'type' => 'wishlist'
        ];
    }
}
