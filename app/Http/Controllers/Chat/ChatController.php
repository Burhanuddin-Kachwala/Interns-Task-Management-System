<?php
namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Display list of interns to the admin
    public function index()
    {
        // Get all interns
        $interns = Intern::all();

        return view('admin.chat.index', compact('interns'));
    }

    // Show chat messages with a specific intern
    public function show($intern_id)
    {
        // Get messages between the admin and selected intern
        $messages = Message::where(function ($query) use ($intern_id) {
                $query->where('sender_id', auth()->guard('admin')->id())
                      ->where('receiver_id', $intern_id);
            })
            ->orWhere(function ($query) use ($intern_id) {
                $query->where('sender_id', $intern_id)
                      ->where('receiver_id', auth()->guard('admin')->id());
            })
            ->get();

        $intern = Intern::findOrFail($intern_id);

        return view('admin.chat.show', compact('messages', 'intern'));
    }

    public function adminView(Intern $intern)
    {
        $messages = Message::where(function ($q) use ($intern) {
            $q->where('sender_id', Auth::id())->where('sender_type', 'admin')
              ->where('receiver_id', $intern->id)->where('receiver_type', 'intern');
        })->orWhere(function ($q) use ($intern) {
            $q->where('sender_id', $intern->id)->where('sender_type', 'intern')
              ->where('receiver_id', Auth::id())->where('receiver_type', 'admin');
        })->orderBy('created_at')->get();

        return view('admin.chat', compact('messages', 'intern'));
    }

    public function internView()
    {
        $intern = Auth::guard('intern')->user();
        $admin = \App\Models\Admin::first(); // Assuming one admin
        $messages = Message::where(function ($q) use ($intern, $admin) {
            $q->where('sender_id', $intern->id)->where('sender_type', 'intern')
              ->where('receiver_id', $admin->id)->where('receiver_type', 'admin');
        })->orWhere(function ($q) use ($intern, $admin) {
            $q->where('sender_id', $admin->id)->where('sender_type', 'admin')
              ->where('receiver_id', $intern->id)->where('receiver_type', 'intern');
        })->orderBy('created_at')->get();

        return view('intern.chat', compact('messages', 'admin'));
    }

    public function send(Request $request, $intern_id)
{
    // Validate the message
    $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    // Send the message
    Message::create([
        'sender_id' => auth()->guard('admin')->id(),
        'sender_type' => 'admin',
        'receiver_id' => $intern_id,
        'receiver_type' => 'intern',
        'message' => $request->message,
    ]);

    // Redirect back to the chat page
    return redirect()->route('admin.chat.show', $intern_id)->with('success', 'Message sent.');
}


}