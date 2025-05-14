<?php

namespace App\Http\Controllers\Intern;

use App\Events\NewChatMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Message;
use App\Services\ChatService;
use Exception;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        try {
            $admins = Admin::all();
            return view('intern.chat.index', compact('admins'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load administrators: ' . $e->getMessage());
        }
    }

    public function show($adminId)
    {
        try {
            $intern = auth()->guard('intern')->user();
            $admin = Admin::findOrFail($adminId);

            $messages = $this->chatService->getConversation(
                $intern->id,
                'intern',
                $admin->id,
                'admin'
            );
            return view('intern.chat.chatbox', compact('admin', 'intern', 'messages'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load chat conversation: ' . $e->getMessage());
        }
    }

    public function send(Request $request, $adminId)
    {
        try {
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
        
            broadcast(new NewChatMessage($message, $adminId, 'admin'));
        
            return response()->json(['message' => $message]);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to send message: ' . $e->getMessage()
            ], 500);
        }
    }
}
