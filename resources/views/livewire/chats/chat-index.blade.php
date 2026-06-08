<div wire:poll.5s>
    <style>
        body {
            overflow: hidden;
            margin-top:50px;
        }
        .chat-item {
            cursor: pointer;
            transition: background-color 0.2s ease, border-left 0.1s ease;
            border-bottom: 1px solid #f0f0f0;
        }
        .chat-item:hover, .chat-item.active {
            background-color: var(--light) !important;
            border-left: 4px solid var(--primary);
        }
        .chat-history {
            display: flex;
            flex-direction: column;
            padding: 20px;
            gap: 12px;
            overflow-y: auto;
            background: #fdfdfd;
        }
        .chat-bubble {
            max-width: 70%;
            margin: 0 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .chat-bubble.is_me {
            align-self: flex-end;
            border-radius: 20px 20px 0 20px !important;
            background: var(--light) !important;
            border: 1px solid #e2e8f0;
        }
        .chat-bubble:not(.is_me) {
            align-self: flex-start;
            border-radius: 20px 20px 20px 0 !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0;
        }
        .chat-item-unread {
            background-color: var(--primary);
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: bold;
            display: inline-block;
        }
        .chat-ad-img {
            object-fit: cover;
        }
    </style>
    
    <section class="chat-area">
        <div class="container-fluid h-100">
            <div class="row">
                <!-- Sidebar Column -->
                <div class="col-lg-4 p-0 @if($this->activeConversationId) d-none d-lg-block @endif">
                    <div class="left-area">
                        <div class="left-area-header bg-white">
                            <h4>Messages</h4>
                        </div>
                        <div class="search-area">
                            <input type="search" placeholder="Search Messages..." wire:model.live="search">
                        </div>
                    
                        <div class="chat-list">
                            @forelse($this->conversations as $conversation)
                                @php
                                    $otherUser = $conversation->buyer_id === auth()->id() ? $conversation->seller : $conversation->buyer;
                                    $unreadMessages = $conversation->messages()
                                        ->where('sender_id', '!=', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                 <a href="{{ url('chat?c='.$conversation->id) }}" wire:navigate>
                                <div class="chat-item {{ $conversation->id === $this->activeConversationId ? 'active' : '' }}" 
                                    >
                                   
                                    <div class="d-flex align-items-center w-100 justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-item-avatar">
                                                <img src="{{ $otherUser->avatar ?? asset('assets/icons/avatar.png') }}" class="chat-avatar-img rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                @php
                                                    $listingImage = $conversation->listing->getMedia('*')->first();
                                                    $listingImageUrl = $listingImage ? $listingImage->getUrl('thumb') : 'https://picsum.photos/400/300?random=' . $conversation->id;
                                                @endphp
                                                <img src="{{ $listingImageUrl }}" class="chat-ad-img">
                                            </div>
                                            <div class="chat-item-info">
                                                <div class="chat-item-name fw-bold">
                                                    {{ $otherUser->name }}
                                                    @if($otherUser->isVerified())
                                                        <i class="bi bi-patch-check-fill text-primary ms-1" style="font-size: 0.85rem;" title="Verified User"></i>
                                                    @endif
                                                </div>
                                                <div class="chat-item-ad-title text-truncate" style="max-width: 180px;">
                                                    {{ $conversation->listing->title }}
                                                </div>
                                                <div class="chat-item-last-msg text-truncate" style="max-width: 180px;">
                                                    @if($conversation->latestMessage)
                                                        @if($conversation->latestMessage->message_type === 'image')
                                                            <i class="bi bi-image"></i> Image
                                                        @elseif($conversation->latestMessage->message_type === 'location')
                                                            <i class="bi bi-geo-alt"></i> Location
                                                        @else
                                                            {{ $conversation->latestMessage->message }}
                                                        @endif
                                                    @else
                                                        No messages yet
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            @if($unreadMessages > 0)
                                                <span class="chat-item-unread">{{ $unreadMessages }}</span>
                                            @endif
                                        </div>
                                    </div>
                                  
                                </div>
                                </a>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <i class="bi bi-chat-dots fs-1 mb-2 d-block"></i>
                                    No conversations found
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Chat Room Column -->
                <div class="col-lg-8 p-0">
                    @if($this->activeConversationId && $this->activeConversation)
                        @php
                            $activeConv = $this->activeConversation;
                            $otherUser = $activeConv->buyer_id === auth()->id() ? $activeConv->seller : $activeConv->buyer;
                            $isBlocked = $this->isBlocked($activeConv);
                            $isBlocker = $this->isCurrentUserBlocker($activeConv);
                        @endphp
                        
                        <div class="chat-room">
                            <div class="chat-room-header bg-white d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="chat-room-avatar me-2">
                                        <img src="{{ $otherUser->avatar ?? asset('assets/icons/avatar.png') }}" class="chat-avatar-img rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                        @php
                                            $listingImage = $activeConv->listing->getMedia('*')->first();
                                            $listingImageUrl = $listingImage ? $listingImage->getUrl('thumb') : 'https://picsum.photos/400/300?random=' . $activeConv->id;
                                        @endphp
                                        <img src="{{ $listingImageUrl }}" class="chat-ad-img">
                                    </div>
                                    <div class="chat-room-info">
                                        <div class="chat-room-name">
                                            <strong>
                                                {{ $otherUser->name }}
                                                @if($otherUser->isVerified())
                                                    <i class="bi bi-patch-check-fill text-primary ms-1" style="font-size: 1rem;" title="Verified User"></i>
                                                @endif
                                            </strong><br>
                                            @if($otherUser->isVerified())
                                                <small class="text-success fw-semibold"><i class="bi bi-shield-check me-1"></i>Verified Seller</small>
                                            @else
                                                <small class="text-muted">Standard Seller</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button class="btn border-0" data-bs-toggle="modal" data-bs-target="#tipsModal">
                                        <i class="bi bi-info-circle me-1"></i>
                                        <span>Safety Tips</span>
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item p-2" href="javascript:void(0)" wire:click="deleteChat" onclick="confirm('Are you sure you want to delete this chat?') || event.stopImmediatePropagation()">
                                                    <i class="bi bi-trash3-fill me-2 text-danger"></i>
                                                    <span class="text-danger">Delete Chat</span>
                                                </a>
                                            </li>
                                            <li>
                                                @if($isBlocker)
                                                    <a class="dropdown-item p-2" href="javascript:void(0)" wire:click="unblockUser">
                                                        <i class="bi bi-unlock-fill me-2 text-success"></i>
                                                        <span class="text-success">Unblock User</span>
                                                    </a>
                                                @else
                                                    <a class="dropdown-item p-2" href="javascript:void(0)" wire:click="blockUser" onclick="confirm('Are you sure you want to block this user?') || event.stopImmediatePropagation()">
                                                        <i class="bi bi-ban me-2 text-danger"></i>
                                                        <span class="text-danger">Block User</span>
                                                    </a>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="chat-room-ad-info" style="background: var(--light);">
                                <a href="/{{ $activeConv->listing->slug }}" class="w-100 d-flex justify-content-between align-items-center">
                                    <div class="text-truncate" style="max-width: 80%;">
                                        <strong>Ad:</strong> {{ $activeConv->listing->title }}
                                    </div>
                                    <div>
                                        <strong>₹ {{ number_format($activeConv->listing->price) }}</strong>
                                    </div>
                                </a>
                            </div>

                            <div class="chat-history" id="chatHistoryContainer">
                                @forelse($this->chatMessages as $message)
                                    <div class="chat-bubble {{ $message->sender_id === auth()->id() ? 'is_me' : '' }}">
                                        <div class="message">
                                            @if($message->message_type == 'image')
                                                <img src="{{ $message->message }}" class="img-fluid rounded" style="max-height: 250px; object-fit: contain; cursor: pointer;" onclick="window.open('{{ $message->message }}')">
                                            @elseif($message->message_type == 'location')
                                                <a href="https://www.google.com/maps?q={{ urlencode($message->message) }}" target="_blank" class="d-flex align-items-center text-primary text-decoration-none py-1">
                                                    <i class="bi bi-geo-alt-fill me-2 fs-5 text-danger"></i>
                                                    <span>View Shared Location</span>
                                                </a>
                                            @else
                                                {{ $message->message }}
                                            @endif
                                        </div>
                                        <div class="time-seen">
                                            <span class="time">{{ $message->created_at->format('h:i A') }}</span>
                                            @if($message->sender_id === auth()->id())
                                                <span class="seen">
                                                    <i class="bi {{ $message->is_read ? 'bi-check2-all text-primary' : 'bi-check2 text-muted' }}"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="m-auto text-center text-muted">
                                        <i class="bi bi-chat-text fs-2 mb-2 d-block"></i>
                                        Send a message to start the conversation!
                                    </div>
                                @endforelse
                            </div>

                            @if($isBlocked)
                                <div class="message-send justify-content-center bg-light text-muted py-3 border-top">
                                    @if($isBlocker)
                                        <span>You have blocked this user. <a href="javascript:void(0)" wire:click="unblockUser" class="text-primary fw-bold text-decoration-none">Unblock</a> to send messages.</span>
                                    @else
                                        <span>You cannot reply to this conversation.</span>
                                    @endif
                                </div>
                            @else
                                <form wire:submit.prevent="sendMessage" class="message-send border-top">
                                    <div class="dropdown dropup">
                                        <button class="btn attachment-btn border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-paperclip"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item p-2" href="javascript:void(0)" onclick="document.getElementById('chat-image-upload').click()">
                                                    <i class="bi bi-image-fill text-primary me-2"></i>
                                                    <span>Image</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item p-2" href="javascript:void(0)" onclick="shareCurrentLocation()">
                                                    <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                                    <span>Location</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Hidden File Input for Image Sharing -->
                                    <input type="file" id="chat-image-upload" style="display: none;" wire:model="image_file" accept="image/*">

                                    <input type="text" wire:model="message_text" placeholder="Type a message..." class="message-send-input">
                                    <button type="submit" class="btn send-btn">
                                        <i class="bi bi-send-fill"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="no-chat">
                            <img src="{{ asset('icons/chat.png') }}" class="mb-3" style="width: 150px;">
                            <h5 class="text-muted">Select a chat to view conversation</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Safety Tips Modal -->
    <div class="modal fade" id="tipsModal" tabindex="-1" aria-labelledby="tipsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="bi bi-exclamation-triangle-fill text-warning"></i> Safety Tips
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="mb-0 ps-3 text-dark">
                        <li class="mb-2">Never send money in advance without verifying the seller.</li>
                        <li class="mb-2">Always meet in a public and safe place.</li>
                        <li class="mb-2">Check the product carefully before making payment.</li>
                        <li class="mb-2">Avoid sharing bank details, OTPs, or passwords.</li>
                        <li class="mb-2">Beware of fake payment screenshots and scam links.</li>
                        <li class="mb-2">Prefer face-to-face deals whenever possible.</li>
                        <li class="mb-2">Do not pay booking/token amounts to unknown people.</li>
                        <li class="mb-0">adMandi is only a marketplace and is not responsible for transactions between users.</li>
                    </ul>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Got It</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for Scroll & Geolocation -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            const scrollToBottom = () => {
                const container = document.getElementById('chatHistoryContainer');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            };

            // Scroll on load
            scrollToBottom();

            // Scroll on event from server
            Livewire.on('chat-scrolled-to-bottom', () => {
                setTimeout(scrollToBottom, 50);
            });

            // Geolocation function
            window.shareCurrentLocation = function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        Livewire.dispatch('location-shared', { latitude: lat, longitude: lng });
                    }, (error) => {
                        alert("Error getting location: " + error.message);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            };
        });
    </script>
</div>
