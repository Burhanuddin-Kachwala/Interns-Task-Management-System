<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

use Log;

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

    public function broadcastOn()
    {

        $channelname="chat.{$this->receiverType}.{$this->receiverId}";
        Log::info("Broadcasting on channel: {$channelname}");
        return new PrivateChannel("chat.{$this->receiverType}.{$this->receiverId}");
    }

    public function broadcastAs(): string
    {
        return 'NewChatMessage';
    }

   public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'receiverId' => $this->receiverId,
            'receiverType' => $this->receiverType,
        ];
    }
 
}