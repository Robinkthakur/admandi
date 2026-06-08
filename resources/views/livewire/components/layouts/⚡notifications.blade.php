<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    #[On('refresh-navigation')]
    #[On('wishlist-updated')]
    public function loadNotifications()
    {
        if (auth()->check()) {
            $this->notifications = auth()->user()->notifications()->latest()->limit(20)->get();
            $this->unreadCount = auth()->user()->unreadNotifications()->count();
        } else {
            $this->notifications = [];
            $this->unreadCount = 0;
        }
    }

    public function mount()
    {
        $this->loadNotifications();
    }

    public function markAllAsRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
            $this->loadNotifications();
            $this->dispatch('refresh-navigation');
        }
    }

    public function markAsRead($id)
    {
        if (auth()->check()) {
            $notification = auth()->user()->notifications()->find($id);
            if ($notification) {
                $notification->markAsRead();
                $this->loadNotifications();
                $this->dispatch('refresh-navigation');
            }
        }
    }
};
?>

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="notificationOffcanvas"
>
    <style>
    .notification-item {
        transition: .2s;
    }
    .notification-item:hover {
        background: #f8f9fa;
    }
    .notification-unread {
        background-color: #f0edff !important;
    }
    .notification-unread:hover {
        background-color: #e6e1ff !important;
    }
    </style>

    <!-- Header -->
    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title fw-bold mb-1">
                Notifications
            </h5>
            <small class="text-muted">
                Latest updates & alerts ({{ $unreadCount }} unread)
            </small>
        </div>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
        ></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body p-0">
        @forelse($notifications as $notif)
            @php
                $data = $notif->data;
                $isUnread = is_null($notif->read_at);
                $iconClass = $data['icon'] ?? 'bi-bell';
                $bgClass = match($data['type'] ?? 'default') {
                    'message' => 'bg-primary-subtle',
                    'wishlist' => 'bg-success-subtle',
                    'status' => 'bg-info-subtle',
                    default => 'bg-light'
                };
                $iconColor = match($data['type'] ?? 'default') {
                    'message' => 'text-primary',
                    'wishlist' => 'text-success',
                    'status' => 'text-info',
                    default => 'text-secondary'
                };
            @endphp
            <a
                href="{{ $data['action_url'] ?? '#' }}"
                wire:click.prevent="markAsRead('{{ $notif->id }}')"
                class="d-flex gap-3 p-3 text-decoration-none border-bottom notification-item {{ $isUnread ? 'notification-unread' : '' }}"
                onclick="window.location.href='{{ $data['action_url'] ?? '#' }}'"
            >
                <div
                    class="rounded-circle {{ $bgClass }} d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width:50px;height:50px;"
                >
                    <i class="bi {{ $iconClass }} {{ $iconColor }}" style="font-size: 1.25rem;"></i>
                </div>

                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="mb-0 text-dark {{ $isUnread ? 'fw-bold' : 'fw-semibold' }}">
                            {{ $data['title'] ?? 'Notification' }}
                        </h6>
                        <small class="text-muted">
                            {{ $notif->created_at->diffForHumans(null, true) }}
                        </small>
                    </div>

                    <p class="text-muted small mb-0 {{ $isUnread ? 'text-dark fw-normal' : '' }}">
                        {{ $data['message'] ?? '' }}
                    </p>
                </div>
            </a>
        @empty
            <div class="text-center py-5 px-3 text-muted">
                <i class="bi bi-bell-slash mb-3 text-secondary" style="font-size: 3rem; display: block;"></i>
                <h6 class="fw-semibold text-dark mb-1">No notifications yet</h6>
                <small>We'll notify you when something important happens.</small>
            </div>
        @endforelse
    </div>

    <!-- Footer -->
    @if($unreadCount > 0)
        <div class="p-3 border-top">
            <button
                wire:click="markAllAsRead"
                class="btn btn-primary w-100 rounded-3"
            >
                <span>Mark all as Read</span>
                <i class="bi bi-check-lg ms-1"></i>
            </button>
        </div>
    @endif
</div>
