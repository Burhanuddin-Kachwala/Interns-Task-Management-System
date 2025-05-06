<?php
namespace App\Services;

use App\Models\Message;

class ChatService
{
    public function getConversation($senderId, $senderType, $receiverId, $receiverType)
    {
        return Message::where(function ($query) use ($senderId, $senderType, $receiverId, $receiverType) {
            $query->where('sender_id', $senderId)
                  ->where('sender_type', $senderType)
                  ->where('receiver_id', $receiverId)
                  ->where('receiver_type', $receiverType);
        })
        ->orWhere(function ($query) use ($senderId, $senderType, $receiverId, $receiverType) {
            $query->where('sender_id', $receiverId)
                  ->where('sender_type', $receiverType)
                  ->where('receiver_id', $senderId)
                  ->where('receiver_type', $senderType);
        })
        ->orderBy('created_at')
        ->get();
    }

    public function sendMessage($senderId, $senderType, $receiverId, $receiverType, $messageContent)
    {
        return Message::create([
            'sender_id' => $senderId,
            'sender_type' => $senderType,
            'receiver_id' => $receiverId,
            'receiver_type' => $receiverType,
            'message' => $messageContent,
        ]);
    }
    
}
