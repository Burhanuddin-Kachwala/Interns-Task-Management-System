<?php

namespace App\Http\Controllers\Intern;

use App\Events\NewChatMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Message;
use App\Services\ChatService;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }
    public function index()
    {
        $admins = Admin::all();
        return view('intern.chat.index', compact('admins'));
    }

    public function show($adminId)
    {
        $intern = auth()->guard('intern')->user();
        $admin = Admin::findOrFail($adminId);

        $messages = $this->chatService->getConversation(
            $intern->id,
            'intern',
            $admin->id,
            'admin'
        );
        return view('intern.chat.chatbox', compact('admin', 'intern', 'messages'));
    }


    public function send(Request $request, $adminId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
    
        $intern = auth()->guard('intern')->user();
    
        $message = $this->chatService->sendMessage(
            $intern->id,
            'intern',
            $adminId,
            'admin',
            $request->message
        );
    
        // Broadcast the new message to the admin's channel
        broadcast(new NewChatMessage($message, $adminId, 'admin'));
    
        // Return the new message as JSON
        return response()->json(['message' => $message]);
    }
}
