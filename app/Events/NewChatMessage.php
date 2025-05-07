<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;
    public int $receiverId;
    public string $receiverType;

    public function __construct(Message $message, int $receiverId, string $receiverType)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
        $this->receiverType = $receiverType;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("chat.{$this->receiverType}.{$this->receiverId}"),
        ];
    }

    public function broadcastAs(): ?string
    {
        return 'new.message';
    }
}
