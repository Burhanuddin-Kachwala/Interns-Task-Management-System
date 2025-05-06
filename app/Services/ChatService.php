<?php
namespace App\Services;

use App\Models\Message;

class ChatService
{
    public function getConversation($senderId, $senderType, $receiverId, $receiverType)
    {
        //the first query checks if the sender is the first user and the receiver is the second user        
        return Message::where(function ($query) use ($senderId, $senderType, $receiverId, $receiverType) {
            $query->where('sender_id', $senderId)
                  ->where('sender_type', $senderType)
                  ->where('receiver_id', $receiverId)
                  ->where('receiver_type', $receiverType);
        })
        //the second query checks if the sender is the second user and the receiver is the first user
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
