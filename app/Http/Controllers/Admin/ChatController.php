<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        // List of all interns the admin can chat with
        $interns = Intern::all();
        return view('admin.chat.index', compact('interns'));
    }

    public function show($internId)
    {
        $admin = Auth::guard('admin')->user();
        $intern = Intern::findOrFail($internId);

        $messages = $this->chatService->getConversation(
            $admin->id,
            'admin',
            $internId,
            'intern'
        );

        return view('admin.chat.chatbox', compact('admin', 'intern', 'messages'));
    }

    public function send(Request $request, $internId)
    {
        $request->validate(['message' => 'required|string']);

        $admin = Auth::guard('admin')->user();

        $this->chatService->sendMessage(
            $admin->id,
            'admin',
            $internId,
            'intern',
            $request->message
        );

        return redirect()->back()->with('success', 'Message sent!');
    }
}
