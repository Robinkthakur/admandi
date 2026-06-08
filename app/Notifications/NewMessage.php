<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification
{
    use Queueable;

    public $conversationId;
    public $senderName;
    public $listingTitle;

    /**
     * Create a new notification instance.
     */
    public function __construct($conversationId, $senderName, $listingTitle)
    {
        $this->conversationId = $conversationId;
        $this->senderName = $senderName;
        $this->listingTitle = $listingTitle;
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
            'title' => 'New Message',
            'message' => "{$this->senderName} sent you a message about your ad '{$this->listingTitle}'.",
            'action_url' => url('/chat?c=' . $this->conversationId),
            'icon' => 'bi-chat-dots',
            'type' => 'message'
        ];
    }
}
