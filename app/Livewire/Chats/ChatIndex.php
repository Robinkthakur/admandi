<?php

namespace App\Livewire\Chats;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Chats\Conversation;
use App\Models\Chats\Message;

class ChatIndex extends Component
{
    use WithFileUploads;

    #[Url(as: 'c')]
    public $activeConversationId = null;

    public $message_text = '';
    public $image_file = null;
    public $search = '';

    public function mount()
    {
        if ($this->activeConversationId) {
            $conversation = Conversation::find($this->activeConversationId);
            if ($conversation) {
                // Ensure user belongs to conversation
                if ($conversation->buyer_id !== auth()->id() && $conversation->seller_id !== auth()->id()) {
                    $this->activeConversationId = null;
                } else {
                    $this->markAsRead($this->activeConversationId);
                }
            } else {
                $this->activeConversationId = null;
            }
        }
    }

    #[Computed]
    public function conversations()
    {
        $userId = auth()->id();
        return Conversation::with(['buyer', 'seller', 'listing', 'latestMessage'])
            ->where(function($query) use ($userId) {
                $query->where(function($q) use ($userId) {
                    $q->where('buyer_id', $userId)
                      ->where('deleted_by_buyer', false);
                })->orWhere(function($q) use ($userId) {
                    $q->where('seller_id', $userId)
                      ->where('deleted_by_seller', false);
                });
            })
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->whereHas('listing', function($lQry) {
                        $lQry->where('title', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('buyer', function($uQry) {
                        $uQry->where('id', '!=', auth()->id())->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('seller', function($uQry) {
                        $uQry->where('id', '!=', auth()->id())->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->orderBy('last_message_at', 'desc')
            ->get();
    }

    #[Computed]
    public function activeConversation()
    {
        if (!$this->activeConversationId) {
            return null;
        }

        $userId = auth()->id();
        return Conversation::with(['buyer', 'seller', 'listing'])
            ->where('id', $this->activeConversationId)
            ->where(function($query) use ($userId) {
                $query->where('buyer_id', $userId)
                      ->orWhere('seller_id', $userId);
            })
            ->first();
    }

    #[Computed]
    public function chatMessages()
    {
        if (!$this->activeConversationId) {
            return collect();
        }

        return Message::with('sender')
            ->where('conversation_id', $this->activeConversationId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function selectConversation($id)
    {
        $conversation = Conversation::find($id);
        if ($conversation && ($conversation->buyer_id === auth()->id() || $conversation->seller_id === auth()->id())) {
            $this->activeConversationId = $id;
            $this->markAsRead($id);
            $this->dispatch('chat-scrolled-to-bottom');
        }
    }

    public function markAsRead($conversationId)
    {
        Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->dispatch('refresh-navigation');
    }

    public function sendMessage()
    {
        if (!$this->activeConversationId) {
            return;
        }

        $conversation = $this->activeConversation();
        if (!$conversation) {
            return;
        }

        // Check block status
        if ($this->isBlocked($conversation)) {
            session()->flash('error', 'You cannot send messages in this chat.');
            return;
        }

        $this->validate([
            'message_text' => 'required|string|max:5000',
        ]);

        Message::create([
            'conversation_id' => $this->activeConversationId,
            'sender_id' => auth()->id(),
            'message' => $this->message_text,
            'message_type' => 'text',
            'is_read' => false,
        ]);

        $conversation->update([
            'last_message_at' => now(),
            'deleted_by_buyer' => false,
            'deleted_by_seller' => false,
        ]);

        $this->notifyRecipient($conversation);

        $this->message_text = '';
        $this->dispatch('chat-scrolled-to-bottom');
        $this->dispatch('refresh-navigation');
    }

    public function notifyRecipient($conversation)
    {
        $recipientId = ($conversation->buyer_id === auth()->id()) ? $conversation->seller_id : $conversation->buyer_id;
        $recipient = \App\Models\User::find($recipientId);
        if ($recipient) {
            $recipient->notify(new \App\Notifications\NewMessage(
                $conversation->id,
                auth()->user()->name,
                $conversation->listing?->title ?? 'Ad'
            ));
        }
    }

    #[On('location-shared')]
    public function sendLocation($latitude, $longitude)
    {
        if (!$this->activeConversationId) {
            return;
        }

        $conversation = $this->activeConversation();
        if (!$conversation) {
            return;
        }

        if ($this->isBlocked($conversation)) {
            return;
        }

        Message::create([
            'conversation_id' => $this->activeConversationId,
            'sender_id' => auth()->id(),
            'message' => $latitude . ',' . $longitude,
            'message_type' => 'location',
            'is_read' => false,
        ]);

        $conversation->update([
            'last_message_at' => now(),
            'deleted_by_buyer' => false,
            'deleted_by_seller' => false,
        ]);

        $this->notifyRecipient($conversation);

        $this->dispatch('chat-scrolled-to-bottom');
        $this->dispatch('refresh-navigation');
    }

    public function updatedImageFile()
    {
        if (!$this->activeConversationId) {
            return;
        }

        $conversation = $this->activeConversation();
        if (!$conversation) {
            return;
        }

        if ($this->isBlocked($conversation)) {
            return;
        }

        $this->validate([
            'image_file' => 'image|max:10240', // 10MB Max
        ]);

        $path = $this->image_file->store('chats', 'public');

        Message::create([
            'conversation_id' => $this->activeConversationId,
            'sender_id' => auth()->id(),
            'message' => asset('storage/' . $path),
            'message_type' => 'image',
            'is_read' => false,
        ]);

        $conversation->update([
            'last_message_at' => now(),
            'deleted_by_buyer' => false,
            'deleted_by_seller' => false,
        ]);

        $this->notifyRecipient($conversation);

        $this->image_file = null;
        $this->dispatch('chat-scrolled-to-bottom');
        $this->dispatch('refresh-navigation');
    }

    public function deleteChat()
    {
        $conversation = $this->activeConversation();
        if (!$conversation) {
            return;
        }

        if ($conversation->buyer_id === auth()->id()) {
            $conversation->update(['deleted_by_buyer' => true]);
        } else {
            $conversation->update(['deleted_by_seller' => true]);
        }

        $this->activeConversationId = null;
        session()->flash('success', 'Conversation deleted.');
    }

    public function blockUser()
    {
        $conversation = $this->activeConversation();
        if (!$conversation) {
            return;
        }

        if ($conversation->buyer_id === auth()->id()) {
            $conversation->update(['buyer_blocked' => true]);
        } else {
            $conversation->update(['seller_blocked' => true]);
        }

        session()->flash('success', 'User blocked.');
    }

    public function unblockUser()
    {
        $conversation = $this->activeConversation();
        if (!$conversation) {
            return;
        }

        if ($conversation->buyer_id === auth()->id()) {
            $conversation->update(['buyer_blocked' => false]);
        } else {
            $conversation->update(['seller_blocked' => false]);
        }

        session()->flash('success', 'User unblocked.');
    }

    public function isBlocked($conversation)
    {
        return $conversation->buyer_blocked || $conversation->seller_blocked;
    }

    public function isCurrentUserBlocker($conversation)
    {
        if ($conversation->buyer_id === auth()->id()) {
            return $conversation->buyer_blocked;
        }
        return $conversation->seller_blocked;
    }

    public function render()
    {
        $layout = 'layouts.blank';
        // Polling will reload computed properties automatically.
        // We also mark incoming messages as read during render if active chat is open
        if ($this->activeConversationId) {
            $layout = 'layouts.blank';
            $this->markAsRead($this->activeConversationId);
        }

        return view('livewire.chats.chat-index')
            ->layout($layout,[
                'headerTitle' => "Chats"
            ]);
    }
}
