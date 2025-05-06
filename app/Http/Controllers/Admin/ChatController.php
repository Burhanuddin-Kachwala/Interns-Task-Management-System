<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intern;
use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {
        $interns = Intern::all();
        return view('admin.chat.index', compact('interns'));
    }

    public function show($internId)
    {
        $intern = Intern::findOrFail($internId);
        $messages = Message::where(function ($query) use ($internId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $internId);
        })->orWhere(function ($query) use ($internId) {
            $query->where('sender_id', $internId)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();
    
        return view('admin.chat.chatbox', compact('messages', 'intern'));
    }
    

    public function send(Request $request, $internId)
    {
        $request->validate(['message' => 'required']);

        Message::create([
            'sender_id' => auth()->guard('admin')->id(),
            'sender_type' => 'admin',
            'receiver_id' => $internId,
            'receiver_type' => 'intern',
            'message' => $request->message,
        ]);

        return back();
    }
}
