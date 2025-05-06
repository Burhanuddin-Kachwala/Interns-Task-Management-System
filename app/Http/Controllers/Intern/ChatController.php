<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('intern.chat.index', compact('admins'));
    }

    public function show($adminId)
    {
        $admin = Admin::findOrFail($adminId);
        $messages = Message::where(function ($query) use ($adminId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $adminId);
        })->orWhere(function ($query) use ($adminId) {
            $query->where('sender_id', $adminId)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();
    
        return view('intern.chat.chatbox', compact('messages', 'admin'));
    }
    

    public function send(Request $request, $adminId)
    {
        $request->validate(['message' => 'required']);

        Message::create([
            'sender_id' => auth()->guard('intern')->id(),
            'sender_type' => 'intern',
            'receiver_id' => $adminId,
            'receiver_type' => 'admin',
            'message' => $request->message,
        ]);

        return back();
    }
}
